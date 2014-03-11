<?php  
defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

class DashboardSimultaneousLoginKillerEditController extends Controller {

	public function on_start(){
		$killer = array();
		// Settings are saved in package config, no db
		$co = new Config();
		$pkg = Package::getByHandle("simultaneous_login_killer");
		$co->setPackageObject($pkg);

		$enabled = $co->get('enabled');
		$killer['enabled'] = !empty($enabled) ? 1 : 0;
		$excluded_groups = $co->get('excluded_groups');
		$killer['excluded_groups'] = explode(",", $excluded_groups);
		$killer['logout_redirect'] = $co->get('logout_redirect');
		$disable_account = $co->get('disable_account');
		$killer['disable_account'] = !empty($disable_account) ? 1 : 0;
		$killer['nbr_logouts'] = $co->get('nbr_logouts');
		$killer['time_span'] = $co->get('time_span');
		$killer['time_unit'] = $co->get('time_unit');
		$email_admin = $co->get('email_admin');
		$killer['email_admin'] = !empty($email_admin) ? 1 : 0;
		$email_user = $co->get('email_user');
		$killer['email_user'] = !empty($email_user) ? 1 : 0;
		$killer['notification_email'] = $co->get('notification_email');
		$killer['email_subject'] = $co->get('email_subject');
		$killer['disabled_redirect'] = $co->get('disabled_redirect');
		$fair_warning = $co->get('fair_warning');
		$killer['fair_warning'] = !empty($fair_warning) ? 1 : 0;
		$killer['nbr_logouts_warning'] = $co->get('nbr_logouts_warning');
		$killer['warning_heading'] = $co->get('warning_heading');
		$killer['warning_message'] = $co->get('warning_message');
		$clear_stats = $co->get('clear_stats');
		$killer['clear_stats'] = !empty($clear_stats) ? 1 : 0;

		$this->set('killer', $killer);
		$this->set('groups', $this->getGroups());

		$this->set('vth', Loader::helper('validation/token'));
		$this->set('vh', Loader::helper('concrete/validation'));
		$this->error = Loader::helper('validation/error');
	}


	public function view($res=false){

		if ($res) {
			$this->set('success', t("Settings saved Successfully!"));
		}

	}

	public function save(){
		$vth = Loader::helper('validation/token');

		if($this->isPost() && $vth->validate('slk_save_settings')){

			$fields2save = $this->validateSettings();

			if($fields2save && is_array($fields2save) && !$this->error->has()){

				$co = new Config();
				$pkg = Package::getByHandle("simultaneous_login_killer");
				$co->setPackageObject($pkg);

				$co->save('enabled', $fields2save['enabled']);
				$co->save('excluded_groups', $fields2save['excluded_groups']);
				$co->save('logout_redirect', $fields2save['logout_redirect']);
				$co->save('disable_account', $fields2save['disable_account']);
				$co->save('nbr_logouts', $fields2save['nbr_logouts']);
				$co->save('time_span', $fields2save['time_span']);
				$co->save('time_unit', $fields2save['time_unit']);
				$co->save('email_admin', $fields2save['email_admin']);
				$co->save('email_user', $fields2save['email_user']);
				$co->save('notification_email', $fields2save['notification_email']);
				$co->save('email_subject', $fields2save['email_subject']);
				$co->save('disabled_redirect', $fields2save['disabled_redirect']);
				$co->save('fair_warning', $fields2save['fair_warning']);
				$co->save('nbr_logouts_warning', $fields2save['nbr_logouts_warning']);
				$co->save('warning_heading', $fields2save['warning_heading']);
				$co->save('warning_message', $fields2save['warning_message']);
				$co->save('clear_stats', $fields2save['clear_stats']);

				$this->view(true);
			} else{
				$this->set('error', $this->error);
			}
		} else{
			$this->error->add(t("Something went wrong and settings were not saved. Please try again!"));
			$this->set('error', $this->error);
		}
	}

	private function validateSettings(){
		$disable_account = $this->post('disable_account');
		if (!empty($disable_account)) {
			$nbr_logouts = $this->post('nbr_logouts');
			if(empty($nbr_logouts) || intval($nbr_logouts)<=0){
				$this->error->add(t("Please include a number of logouts before the account is disabled (not zero)."));
			} else if(!is_numeric($nbr_logouts)){
				$this->error->add(t("The number of log outs before the account is disabled must be a number."));
			}
			$time_span = $this->post('time_span');
			if(!empty($time_span) && (!is_numeric($time_span) || $time_span < 0)){
				$this->error->add(t("The time span for disabling an account must be a number."));
			}

			$nbr_logouts_warning = $this->post('nbr_logouts_warning');
			$fair_warning = $this->post('fair_warning');
			if (!empty($fair_warning)) {
				if(empty($nbr_logouts_warning) || intval($nbr_logouts_warning)<=0){
					$this->error->add(t("Please include a number of logouts before showing a warning (not zero)."));
				} else if(!is_numeric($nbr_logouts_warning)){
					$this->error->add(t("The number of log outs before showing a warning must be a number."));
				} else if($nbr_logouts_warning >= $nbr_logouts){
					$this->error->add(t("The number of logouts before showing a warning must be inferior to the number of logouts before deactivation."));
				}
			}

		}
		if (!$this->error->has()) {
			$vals = array();

			if (count($this->post('excluded_groups'))) {
				foreach($this->post('excluded_groups') as $group){
					$excluded_groups .= $group.",";
				}
				$excluded_groups = rtrim ($excluded_groups, ",");
			} else {
				$excluded_groups = '';
			}


			$enabled = $this->post('enabled');
			$vals['enabled'] = !empty($enabled) ? 1 : 0;
			$vals['excluded_groups'] = $excluded_groups;
			$vals['logout_redirect'] = $this->post('logout_redirect');
			$vals['disable_account'] = !empty($disable_account) ? 1 : 0;
			$vals['nbr_logouts'] = $this->post('nbr_logouts');
			$vals['time_span'] = $this->post('time_span');
			$vals['time_unit'] = $this->post('time_unit');
			$email_admin = $this->post('email_admin');
			$vals['email_admin'] = !empty($email_admin) ? 1 : 0;
			$email_user = $this->post('email_user');
			$vals['email_user'] = !empty($email_user) ? 1 : 0;
			$vals['notification_email'] = $this->post('notification_email');
			$vals['email_subject'] = $this->post('email_subject');
			$vals['disabled_redirect'] = $this->post('disabled_redirect');
			$vals['fair_warning'] = !empty($fair_warning) ? 1 : 0;
			$vals['nbr_logouts_warning'] = $this->post('nbr_logouts_warning');
			$vals['warning_heading'] = $this->post('warning_heading');
			$vals['warning_message'] = $this->post('warning_message');
			$clear_stats = $this->post('clear_stats');
			$vals['clear_stats'] = !empty($clear_stats) ? 1 : 0;

			return $vals;
		} else {
			return false;
		}

	}

	//helper function - returns array of user groups
	private function getGroups(){
		Loader::model('search/group');
		$gs = new GroupSearch();
		$groupArr = $gs->get(9999, 0);
		$groups = array("All" => t("All Groups"));
		foreach($groupArr as $ga){
			$groups[$ga['gID']] = $ga['gName'];
		}
		return $groups;
	}

}