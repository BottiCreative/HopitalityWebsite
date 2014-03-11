<?php  
defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */
$json = Loader::helper('json');
if( $_POST['warning'] && $_POST['warning']=='read' ) {

	$u = new User();
	$u->saveConfig('slk_warning_activated', 0);

	$jsonData = array(
		'success' => true,
		'message' => ''
	);

	echo $json->encode($jsonData);

} else {
	$jsonData = array(
		'success' => false,
		'message' => t('Something went wrong, please try again.')
	);

	echo $json->encode($jsonData);
}
?>
