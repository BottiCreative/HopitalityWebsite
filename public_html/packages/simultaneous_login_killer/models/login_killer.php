<?php  
defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

if( !class_exists( LoginKiller ) ){
	class LoginKiller extends Model {

		public function __construct() {}

		/**
		 * helper function to get browser data at login
		 *
		 */

		private function browser_data() {
			Loader::library('php_user_agent', 'simultaneous_login_killer');
			$userAgent = new PhpUserAgent();

			return $userAgent->toArray();
		}

		/**
		 * run checks for a flagged login
		 *
		 */
		public function track_user($c) {

			$co = new Config();
			$pkg = Package::getByHandle("simultaneous_login_killer");
			$co->setPackageObject($pkg);
			$enabled = $co->get('enabled');

			$u = new User();
			if($u->isLoggedIn() && !empty($enabled)) {
				$excluded_groups = explode(",", $co->get('excluded_groups'));
				$uGroups = $u->getUserGroups();
				$excluded = false;
				foreach($uGroups as $id=>$name) {
					if(in_array($id, $excluded_groups)) {
						$excluded = true;
						break;
					}
				}
				//ignore admins and excluded groups
				if($u->isSuperUser() || $excluded) {

					return;
				}

				//check the sessidentifier
				$sessidentifier = $u->config('slk_session_id');

				if(!empty($sessidentifier)) {
					if(empty($_COOKIE['slk_session_id']) || $sessidentifier != $_COOKIE['slk_session_id']) {
						self::manage_logout($c, $u, $co);

					} else if ($sessidentifier == $_COOKIE['slk_session_id']){
						Loader::library('php_user_agent', 'simultaneous_login_killer');
						$userAgent = new PhpUserAgent();
						$browser = $userAgent->toArray();

						// The system could be easily fooled by copying the value of the cookie from the other user
						// and pasting it in the local cookie.
						// To avoid that, a second verification takes place to make sure that cookie value
						// is consistent with the user's environment
						$sessidentifier_data = hash('md5', $browser['browser_name'] . $browser['operating_system'] . PASSWORD_SALT . $u->getUserID());
						$saved_data = $u->config('slk_session_data');
						if ($sessidentifier_data != $saved_data) {
							self::manage_logout($c, $u, $co);
						}

					}
				}

			}

			if($u->isLoggedIn() && !empty($enabled)) {
				$warning = $u->config('slk_warning_activated');
				//load the noty js first
				if (!empty($warning)){
					self::manage_warning($c, $u, $co);

				}
			}
		}

		private function manage_warning($c, $u, $co) {

			$warning_heading = $co->get('warning_heading');
			if (empty($warning_heading)) {
				$warning_heading = t('Suspicious Activity Detected!');
			}
			$warning_message = $co->get('warning_message');
			$nbr_logouts = $u->config('slk_logouts');
			$timeFrame = $co->get('time_span').' '.$co->get('time_unit').'(s)';
			$uName = $u->getUserName();
			if (empty($warning_message)) {
				$warning_message = t("Dear $uName,

					it seems your account is being used by more than one person. As a result you and those other users have already been logged out $nbr_logouts time(s) in less than $timeFrame.

					If this goes on, we will have no choice but to deactivate your account.

					If you feel this warning is unjustified and you have no knowledge of others using your login credentials, please contact us as soon as possible to allow us to deal with the situation accordingly.

					Thank you for your understanding.");
			} else {
				$sr_search = array("!!userName!!", "!!nbrLogouts!!", "!!timeFrame!!");
				$sr_replace = array($uName, $nbr_logouts, $timeFrame);
				$warning_message = str_replace($sr_search, $sr_replace, $warning_message);
			}

			$warning_message = nl2br(htmlentities($warning_message, ENT_QUOTES, APP_CHARSET));

			ob_start();
			Loader::packageElement('warning_modal_content', 'simultaneous_login_killer', array('warning_heading' => $warning_heading, 'warning_message' => $warning_message));
			$dom = ob_get_contents();
			ob_end_clean();

			$dom = str_replace('"', "'", $dom);
			$warning_message = str_replace(array("\r", "\n"), "", $dom);

			$html = Loader::helper('html');
			$c->addFooterItem($warning_message);

			$c->addHeaderItem($html->css('ebcaptcha/style.css', 'simultaneous_login_killer'));
			$c->addFooterItem($html->javascript('ebcaptcha/ebcaptcha.js', 'simultaneous_login_killer'));
			$c->addHeaderItem($html->css('colorbox/colorbox.css', 'simultaneous_login_killer'));
			$c->addFooterItem($html->javascript('colorbox/jquery.colorbox-min.js', 'simultaneous_login_killer'));
			$c->addFooterItem($html->javascript('warning/warning-min.js', 'simultaneous_login_killer'));
			$script = '<script type="text/javascript">';
			$script .= '$(document).ready( function() {$("#warning-agree").ebcaptcha(); $.colorbox({inline:true, href:"#warning-wrapper", overlayClose: false, scrolling:false, closeButton:false, escKey:false, width:"45%"});$.colorbox.resize();';
			$script .= '});</script>';
			$c->addFooterItem($script);
		}

		private function manage_logout($c, $u, $co) {
			//log user out
			$u->logout();

			Loader::model('killer_tracker', 'simultaneous_login_killer');
			$killer_obj = new KillerTracker();

			// check number of logouts and take proper action
			$res = $killer_obj->track_logouts($u);
			$disabled = ($res=='disable');
			$warning = ($res=='warning');

			$nbr_logouts = intval($u->config("slk_logouts"));

			// save stats data
			$killer_obj->save_stats($u, $nbr_logouts, $disabled);

			// send notification emails
			if ($disabled) {
				$killer_obj->send_email($u);
			}

			// redirect if and where needed
			$redirect = ($disabled) ? $co->get('disabled_redirect') : $co->get('logout_redirect');
			if (!empty($redirect)) {
				$page = Page::getByID(intval($redirect));
				if (is_object($page) && $page->cID) {
					$nh = Loader::helper('navigation');
					header('Location: '. ($nh->getLinkToCollection($page)));

				}
			}

		}

		/**
		 * track and set session data at login
		 *
		 */

		public function record_login() {
			$user = new User();

			// get browser data from current login
			Loader::library('php_user_agent', 'simultaneous_login_killer');
			$userAgent = new PhpUserAgent();
			$browser = $userAgent->toArray();

			//store a session identifier in user config value and in cookie
			$sessidentifier = hash('md5', $browser['browser_name'] . $browser['operating_system'] . $_SERVER['REMOTE_ADDR'] . $user->getUserID() . time());
			$user->saveConfig('slk_session_id', $sessidentifier);
			setcookie("slk_session_id", $sessidentifier, time()+3600*24*30, DIR_REL . '/');

			//store an environment identifier in user config value only, no cookie
			$sessidentifier_data = hash('md5', $browser['browser_name'] . $browser['operating_system'] . PASSWORD_SALT . $user->getUserID());
			$user->saveConfig('slk_session_data', $sessidentifier_data);
		}

	}
}