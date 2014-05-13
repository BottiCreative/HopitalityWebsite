<?php defined('C5_EXECUTE') or die('Access Denied');

class InfusionPackage extends Package {
	
	
	protected $pkgHandle = 'infusion';
	protected $appVersionRequired = '1.0.0';
	protected $pkgVersion = '1.0.1';
	
	public function getPackageDescription()
	{
		
		return t("Infusion Integration Package");
		
	}
	
	public function getPackageName()
	{
		return t('Infusion');
		
	}
	
	public function getPackageHandle()
	{
		
		return $this->pkgHandle;
	}
	
	public function install() {
			
		$pkg = parent::install();	
		
		//add the Infusion API connectionname here.
        $pkg->saveConfig('INFUSION_CONNECTIONNAME','vn172');
        	
        	
	}
	
	public function upgrade()
	{
		
		parent::upgrade();
		
		 $pkg = Package::getByHandle($this->pkgHandle);
		 $pkg->saveConfig('INFUSION_CONNECTIONNAME','vn172');
			
		
	}
	
	
		
			
							
		
		
		
		
			

}

