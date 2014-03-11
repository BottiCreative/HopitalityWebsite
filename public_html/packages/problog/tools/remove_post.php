<?php     
defined('C5_EXECUTE') or die("Access Denied.");

if($_GET['ccID']){
	$cID = $_GET['ccID'];
	Loader::model('page');
	$p = Page::getByID($cID);
	$p->delete();
}


?>