<?php    defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

if( !class_exists( KillerTracker ) ){
	class KillerTracker extends Model{

		function __construct(){
			if (!ini_get('date.timezone')) {
			    $timezone = 'UTC';

			} else {
				$timezone = ini_get('date.timezone');
			}
			date_default_timezone_set($timezone);
		}

		/**
		 * track and set number of logouts
		 *
		 */

		public function track_logouts($user) {

			$userInfo = UserInfo::getByID($user->getUserID());

			$co = new Config();
			$pkg = Package::getByHandle("simultaneous_login_killer");
			$co->setPackageObject($pkg);

			$nbrLogouts = intval($user->config('slk_logouts'))+1;
			$disable = $co->get('disable_account');

			if (!empty($disable)) {
				$logout_limit = $co->get('nbr_logouts');
				$fair_warning = $co->get('fair_warning');
				if (!empty($fair_warning)) {
					$warning_limit = $co->get('nbr_logouts_warning');
				}

				if (($nbrLogouts > $logout_limit)) {
					// Deadline over, restart counting
					$nbrLogouts = 1;
				}
			}

			if ($nbrLogouts==1) {
				// Deadline over, restart counting
				$user->saveConfig('slk_first_logout_time', date('Y-m-d H:i:s'));
			}

			$user->saveConfig('slk_logouts', $nbrLogouts);

			if (!empty($disable)) {
				// Should the account be deactivated?
				$time_span = $co->get('time_span');
				$time_unit = $co->get('time_unit');

				if ($nbrLogouts == $logout_limit) {
					Loader::library('expressive_date', 'simultaneous_login_killer');
					$first_time = $user->config('slk_first_logout_time');
					$date = new ExpressiveDate($first_time);

					switch ($time_unit) {
						case 'Minute':
						$time_diff = $date->getDifferenceInMinutes();
						break;

						case 'Hour':
						$time_diff = $date->getDifferenceInHours();
						break;

						case 'Day':
						$time_diff = $date->getDifferenceInDays();
						break;

						case 'Week':
						$time_diff = $date->getDifferenceInWeeks();
						break;

						case 'Month':
						$time_diff = $date->getDifferenceInMonths();
						break;

						case 'Year':
						$time_diff = $date->getDifferenceInYears();
						break;

						default:
						break;
					}

					if (empty($time_span) || ($time_diff <= $time_span)) {
						//too many logouts in a limited time
						//deactivate account
						$userInfo->deactivate();

						return 'disable';
					}

				} else if (!empty($warning_limit) && ($nbrLogouts == $warning_limit)) {
					$user->saveConfig('slk_warning_activated', 1);
					return 'warning';
				}
			}
			return 'logout';

		}

		public function send_email($offender) {

			$co = new Config();
			$pkg = Package::getByHandle("simultaneous_login_killer");
			$co->setPackageObject($pkg);
			$email_admin = $co->get('email_admin');
			$email_user = $co->get('email_user');
			$notification_email = $co->get('notification_email');

			$adminUser = UserInfo::getByID(USER_SUPER_ID);
			$adminEmail = $adminUser->getUserEmail();

			$mh = Loader::helper('mail');
			// Offender email
			if (defined('EMAIL_ADDRESS_REGISTER_NOTIFICATION_FROM')) {
				$from_email = EMAIL_ADDRESS_REGISTER_NOTIFICATION_FROM;
			} else {
				$from_email = $adminEmail;
			}

			if (is_object($offender)) {
				$ui = UserInfo::getByID($offender->getUserID());
				$uEmail = $ui->getUserEmail();
				$uName = $offender->getUserName();
			}

			if (!empty($email_user)) {
				if (empty($notification_email)) {
					$mh->from($from_email,  html_entity_decode(SITE));
					$mh->to($uEmail, $uName);
					$mh->addParameter('uName', $uName);
					$mh->addParameter('url', BASE_URL.DIR_REL);
					$mh->load('user_email', 'simultaneous_login_killer');
					$mh->sendMail();
				} else {

					$timeFrame = $co->get('time_span').' '.$co->get('time_unit').'(s)';
					$sr_search = array("!!userName!!", "!!userEmail!!", "!!nbrLogouts!!", "!!timeFrame!!");
					$sr_replace = array($uName, $uEmail, $co->get('nbr_logouts'), $timeFrame);

					$body = str_replace($sr_search, $sr_replace, $notification_email);
					$subject = $co->get('email_subject');
					if (empty($subject)) {
						$subject = t("Your %s account was deactivated", html_entity_decode(SITE));
					}

					$mh->from($from_email,  html_entity_decode(SITE));
					$mh->to($uEmail, $uName);
					$mh->setSubject($subject);
					$mh->setBody($body);
					$mh->sendMail();
				}
				$mh->reset();
			}

			if (!empty($email_admin)) {

				$mh->from($from_email, html_entity_decode(SITE));
				$mh->to($adminEmail);
				$mh->addParameter('uName', $uName);
				$mh->addParameter('uEmail', $uEmail);
				$mh->load('admin_email', 'simultaneous_login_killer');
				$mh->sendMail();
			}

		}

		public function save_stats($offender, $nbr_logouts, $deactivated=false) {

			$db = Loader::db();
			$co = new Config();
			$pkg = Package::getByHandle("simultaneous_login_killer");
			$co->setPackageObject($pkg);
			$deactivated = $deactivated ? 1: 0;
			$uID = $offender->getUserID();
			$counting_from = $offender->config("slk_first_logout_time");

			if($nbr_logouts<=1) {
				$values = array($uID, $counting_from, 1, $counting_from, $deactivated);
				$query = 'INSERT INTO btSimultaneousLoginKillerStats
				(uID, counting_from, nbr_logouts, last_logout, deactivated)
				VALUES(?, ?, ?, ?, ?)';
			} else {
				$values = array($nbr_logouts, date('Y-m-d H:i:s'), $deactivated, $uID, $counting_from);
				$query = 'UPDATE btSimultaneousLoginKillerStats
				SET nbr_logouts=?, last_logout=?, deactivated=?
				WHERE uID=? AND counting_from=?';
			}

			$db->Execute($query, $values);

		}
	}
}

?>