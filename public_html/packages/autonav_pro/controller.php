<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));
/**
	* @ concrete5 package Auto-Nav Pro
	* @copyright  Copyright (c) 2014 Hostco. (http://www.hostco.com)  	
*/
class AutonavProPackage extends Package {

     protected $pkgHandle = 'autonav_pro';
     protected $appVersionRequired = '5.6.2.1';
     protected $pkgVersion = '1.5.1';

     public function getPackageDescription() {
          return t("An advanced, responsive auto-nav with a built in Font Awesome icon generator and much more.");
     }

     public function getPackageName() {
          return t("Auto-Nav Pro");
     }
	
     public function install() {
          $pkg = parent::install();
	//install related page attributes
	Loader::model('collection_types');
	
	Loader::model('collection_attributes');
	$att_coll = AttributeKeyCategory::getByHandle('collection');	
	
	if (!$att_coll->allowAttributeSets()) {
	  $att_coll->setAllowAttributeSets(AttributeKeyCategory::ASET_ALLOW_SINGLE);
	 }
	$att_set = AttributeSet::getByHandle('autonav_pro');
	if(!is_object($att_set)){
	  	$att_set = $att_coll->addSet('autonav_pro', t('AutoNav Pro'),$pkg);
	 }
	$text_att = AttributeType::getByHandle('text');
	$boolean_att = AttributeType::getByHandle('boolean');
	$img_att = AttributeType::getByHandle('image_file');
	$select_att = AttributeType::getByHandle('select');
	$textarea_att = AttributeType::getByHandle('textarea');
	
	$bootstrap_att_1=CollectionAttributeKey::getByHandle('anp_hide_children'); 
	if( !is_object($bootstrap_att_1) ) {
		CollectionAttributeKey::add($boolean_att,array('akHandle' => 'anp_hide_children','akName' => t('Hide Children')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_2=CollectionAttributeKey::getByHandle('anp_remove_link'); 
	if( !is_object($bootstrap_att_2) ) {
		CollectionAttributeKey::add($boolean_att,array('akHandle' => 'anp_remove_link','akName' => t('Remove Link')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_15=CollectionAttributeKey::getByHandle('anp_overwrite_title'); 
	if( !is_object($bootstrap_att_15) ) {
		CollectionAttributeKey::add($text_att,array('akHandle' => 'anp_overwrite_title','akName' => t('Font Awesome')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_17=CollectionAttributeKey::getByHandle('anp_overwrite_html'); 
	if( !is_object($bootstrap_att_17) ) {
		CollectionAttributeKey::add($textarea_att,array('akHandle' => 'anp_overwrite_html','akName' => t('Overwrite link title with html')),$pkg)->setAttributeSet($att_set); 
	}
	
	$bootstrap_att_3=CollectionAttributeKey::getByHandle('anp_hide_nav_txt'); 
	if( !is_object($bootstrap_att_3) ) {
		CollectionAttributeKey::add($boolean_att,array('akHandle' => 'anp_hide_nav_txt','akName' => t('Hide Link Text')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_4=CollectionAttributeKey::getByHandle('anp_sublvl_stack'); 
	if( !is_object($bootstrap_att_4) ) {
		CollectionAttributeKey::add($boolean_att,array('akHandle' => 'anp_sublvl_stack','akName' => t('Add Sublevel Stack')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_5=CollectionAttributeKey::getByHandle('anp_nav_class'); 
	if( !is_object($bootstrap_att_5) ) {
		CollectionAttributeKey::add($text_att,array('akHandle' => 'anp_nav_class','akName' => t('Add Class')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_16=CollectionAttributeKey::getByHandle('anp_extra_attr_data'); 
	if( !is_object($bootstrap_att_16) ) {
		CollectionAttributeKey::add($textarea_att,array('akHandle' => 'anp_extra_attr_data','akName' => t('Add Extra Attribute Data For Link')),$pkg)->setAttributeSet($att_set); 
	}
	
	
	
	$bootstrap_att_6=CollectionAttributeKey::getByHandle('anp_overwrite_link'); 
	if( !is_object($bootstrap_att_6) ) {
		CollectionAttributeKey::add($text_att,array('akHandle' => 'anp_overwrite_link','akName' => t('Overwrite Link')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_7=CollectionAttributeKey::getByHandle('anp_sublvl_content'); 
	if( !is_object($bootstrap_att_7) ) {
		CollectionAttributeKey::add($textarea_att,array('akHandle' => 'anp_sublvl_content','akName' => t('Add HTML Content On Sublevel')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_8=CollectionAttributeKey::getByHandle('anp_add_img'); 
	if( !is_object($bootstrap_att_8) ) {
		CollectionAttributeKey::add($img_att,array('akHandle' => 'anp_add_img','akName' => t('Add Image')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_9=CollectionAttributeKey::getByHandle('anp_add_active_img'); 
	if( !is_object($bootstrap_att_9) ) {
		CollectionAttributeKey::add($img_att,array('akHandle' => 'anp_add_active_img','akName' => t('Add Image For Active Link')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_10=CollectionAttributeKey::getByHandle('anp_add_extra_img1'); 
	if( !is_object($bootstrap_att_10) ) {
		CollectionAttributeKey::add($img_att,array('akHandle' => 'anp_add_extra_img1','akName' => t('Add Extra Image 1')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_11=CollectionAttributeKey::getByHandle('anp_add_extra_img2'); 
	if( !is_object($bootstrap_att_11) ) {
		CollectionAttributeKey::add($img_att,array('akHandle' => 'anp_add_extra_img2','akName' => t('Add Extra Image 2')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_12=CollectionAttributeKey::getByHandle('anp_add_extra_img3'); 
	if( !is_object($bootstrap_att_12) ) {
		CollectionAttributeKey::add($img_att,array('akHandle' => 'anp_add_extra_img3','akName' => t('Add Extra Image 3')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_13=CollectionAttributeKey::getByHandle('anp_add_extra_img4'); 
	if( !is_object($bootstrap_att_13) ) {
		CollectionAttributeKey::add($img_att,array('akHandle' => 'anp_add_extra_img4','akName' => t('Add Extra Image 4')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_14=CollectionAttributeKey::getByHandle('anp_add_extra_img5'); 
	if( !is_object($bootstrap_att_14) ) {
		CollectionAttributeKey::add($img_att,array('akHandle' => 'anp_add_extra_img5','akName' => t('Add Extra Image 5')),$pkg)->setAttributeSet($att_set); 
	}
	
	
	
	$bootstrap_att_18=CollectionAttributeKey::getByHandle('anp_exclude_nav'); 
	if( !is_object($bootstrap_att_18) ) {
		CollectionAttributeKey::add($boolean_att,array('akHandle' => 'anp_exclude_nav','akName' => t('Exclude from AutonavPro')),$pkg)->setAttributeSet($att_set); 
	}		
		
	BlockType::installBlockTypeFromPackage('autonav_pro', $pkg);
		// install single pages				
		Loader::model('single_page');
		$p1 = SinglePage::add('/dashboard/autonav_pro',$pkg);
        $p1->update(array('cDescription'=>$this->getPackageDescription()));		
		SinglePage::add('/dashboard/autonav_pro/font_awesome_generator', $pkg);
		$this->setupDashboardIcons();
	}
   
    public function upgrade(){
	$pkg = Package::getByHandle('autonav_pro');
	//install related page attributes
	Loader::model('collection_types');
	
	Loader::model('collection_attributes');
	$att_coll = AttributeKeyCategory::getByHandle('collection');	
	
	if (!$att_coll->allowAttributeSets()) {
	  $att_coll->setAllowAttributeSets(AttributeKeyCategory::ASET_ALLOW_SINGLE);
	 }
	
	$att_set = AttributeSet::getByHandle('autonav_pro');
	if(!is_object($att_set)){
	  	$att_set = $att_coll->addSet('autonav_pro', t('AutoNav Pro'),$pkg);
	 }
	$text_att = AttributeType::getByHandle('text');
	$boolean_att = AttributeType::getByHandle('boolean');
	$img_att = AttributeType::getByHandle('image_file');
	$select_att = AttributeType::getByHandle('select');
	$textarea_att = AttributeType::getByHandle('textarea');
	
	$bootstrap_att_17=CollectionAttributeKey::getByHandle('anp_overwrite_html'); 
	if( !is_object($bootstrap_att_17) ) {
		CollectionAttributeKey::add($textarea_att,array('akHandle' => 'anp_overwrite_html','akName' => t('Overwrite link title with html')),$pkg)->setAttributeSet($att_set); 
	}
	$bootstrap_att_18=CollectionAttributeKey::getByHandle('anp_exclude_nav'); 
	if( !is_object($bootstrap_att_18) ) {
		CollectionAttributeKey::add($boolean_att,array('akHandle' => 'anp_exclude_nav','akName' => t('Exclude from AutonavPro')),$pkg)->setAttributeSet($att_set); 
	}	
	}
   
   	private function setupDashboardIcons() {
		$cak = CollectionAttributeKey::getByHandle('icon_dashboard');
		if (is_object($cak)) {
			$iconArray = array(
      // Change to list your single pages and their icons
		'/dashboard/autonav_pro/font_awesome_generator' => 'icon-wrench'
      
		);
    foreach($iconArray as $path => $icon) {
      $sp = Page::getByPath($path);
      if (is_object($sp) && (!$sp->isError())) {
        $sp->setAttribute('icon_dashboard', $icon);
      }
    }
  }
}
}
?>