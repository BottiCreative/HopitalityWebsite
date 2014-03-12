<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<?php

Loader::model('areas','moo_music');
Loader::helper('utilities','moo_music');
Loader::model('product/model','core_commerce');

$productID = $_GET['areaid'];

if(is_numeric($productID))
{
	
	//ok, lets lock the area.
	$area = CoreCommerceProduct::getByID($productID);
	if($area instanceof CoreCommerceProduct)
	{
		
		//lock the area now.
		$utils = new MooMusicUtilitiesHelper();
		
		$utils->LockArea($area);
		echo 'locked';
		exit();
		
	}	
	
}

?>

