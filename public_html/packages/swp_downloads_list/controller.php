<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));

class SwpDownloadsListPackage extends Package {

	protected $pkgHandle = 'swp_downloads_list';
	protected $appVersionRequired = '5.5.0';
	protected $pkgVersion = '1.4';

	public function getPackageDescription() {
		return t('Display all download links from a certain file set in a single block.<br />By <a href="http://www.smartwebprojects.net/" target="_blank">Smart Web Projects</a>');
	}

	public function getPackageName() {
		return t('Downloads List');
	}

	public function install() {
		$pkg = parent::install();

		// install block
		BlockType::installBlockTypeFromPackage('swp_downloads_list', $pkg);
	}

}