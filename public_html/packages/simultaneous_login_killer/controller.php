<?php   defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

class SimultaneousLoginKillerPackage extends Package {

	protected $pkgHandle = 'simultaneous_login_killer';
	protected $appVersionRequired = '5.6.0';
	protected $pkgVersion = '1.0';

	public function getPackageDescription(){
		return t('Kill unwanted simultaneous login to your website.');
	}

	public function getPackageName(){
		return t('Simultaneous Login Killer');
	}

	public function on_start() {
		Events::extend("on_user_login", "LoginKiller", "record_login", DIRNAME_PACKAGES.'/'.$this->pkgHandle.'/models/login_killer.php');
		Events::extend("on_before_render", "LoginKiller", "track_user", DIRNAME_PACKAGES.'/'.$this->pkgHandle.'/models/login_killer.php');
		Events::extend("on_user_delete", "KillerStats", "delete_stats", DIRNAME_PACKAGES.'/'.$this->pkgHandle.'/models/killer_stats.php');
	}

	public function install(){

		if(version_compare(PHP_VERSION, '5.3.0') < 0){
			throw new Exception(t('You must be running PHP 5.3 or greater to install and use this add-on (As stated prominently on the add-on\'s marketplace page)'));
		}

		$pkg = parent::install();

		$single_pages = array(
			'/dashboard/simultaneous_login_killer'=>array('name'=>'Simultaneous Login Killer', 'icon'=>''),
			'/dashboard/simultaneous_login_killer/edit'=>array('name'=>'Settings', 'icon'=>'icon-cog'),
			'/dashboard/simultaneous_login_killer/list'=>array('name'=>'List Offenders', 'icon'=>'icon-list-alt'),
			'/dashboard/simultaneous_login_killer/help'=>array('name'=>'Critical Warning & Help', 'icon'=>'icon-fire')
		);
		foreach($single_pages as $path => $details) {
			$this->getOrAddSinglePage($pkg, $path, $details['name'], '', $details['icon']);
		}

	}

	public function uninstall(){
		parent::uninstall();
		//clean up
		Config::clear('slk_session_id');
		Config::clear('slk_session_data');
		Config::clear('slk_warning_activated');
		Config::clear('slk_logouts');
		Config::clear('slk_first_logout_time');
	}

	public function getOrAddSinglePage($pkg, $cPath, $cName = '', $cDescription = '', $cIcon = '') {
		Loader::model('single_page');

		$sp = SinglePage::add($cPath, $pkg);

		if (is_null($sp)) {
						//SinglePage::add() returns null if page already exists
			$sp = Page::getByPath($cPath);
			Loader::db()->execute('update Pages set pkgID = ? where cID = ?', array($pkg->pkgID, $sp->getCollectionID()));
		} else {
						//Set page title and/or description...
			$data = array();
			if (!empty($cName)) {
				$data['cName'] = $cName;
			}
			if (!empty($cDescription)) {
				$data['cDescription'] = $cDescription;
			}

			if (!empty($data)) {
				$sp->update($data);
			}
		}

		if (is_object($sp) && (!$sp->isError()) && (!empty($cIcon))) {
			$sp->setAttribute('icon_dashboard', $cIcon);
		}

		return $sp;
	}

}