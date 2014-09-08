<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));
/**
	* @ concrete5 package AutonavPro
	* @copyright  Copyright (c) 2013 Hostco. (http://www.hostco.com)  	
*/
class DashboardAutonavProFontAwesomeGeneratorController extends Controller {
function view(){
	}
public function on_start(){
$pkg=Package::getByHandle('autonav_pro');
$basic_path=Loader::helper('concrete/urls')->getPackageURL($pkg);
$this->error = Loader::helper('validation/error');  
$html = Loader::helper('html');
$v = View::getInstance();		
$v->addHeaderItem('<link rel="stylesheet" href="'.$basic_path.'/css/font-awesome.css" />');
$v->addHeaderItem('<link rel="stylesheet" href="'.$basic_path.'/css/bootstrap.css" />');
$v->addHeaderItem(' <script src="'.$basic_path.'/js/bootstrap.js"></script>');
}		
}
?>