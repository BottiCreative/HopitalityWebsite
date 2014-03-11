<?php      
defined('C5_EXECUTE') or die("Access Denied.");

Loader::block('related_pages');

$previewMode = true;
$nh = Loader::helper('navigation');
$controller = new RelatedPagesBlockController($b);


$_REQUEST['num'] = ($_REQUEST['num'] > 0) ? $_REQUEST['num'] : 0;
$_REQUEST['cThis'] = ($_REQUEST['cParentID'] == $controller->cID) ? '1' : '0';
$_REQUEST['cParentID'] = ($_REQUEST['cParentID'] == 'OTHER') ? $_REQUEST['cParentIDValue'] : $_REQUEST['cParentID'];

$controller->num 		= $_REQUEST['num'];
$controller->cParentID 	= $_REQUEST['cParentID'];
$controller->cThis 		= $_REQUEST['cThis'];
$controller->orderBy	= $_REQUEST['orderBy'];
$controller->ctID 		= $_REQUEST['ctID'];
$controller->rss 		= $_REQUEST['rss'];
$controller->akID 		= $_REQUEST['akID'];
$controller->ccID			= $_REQUEST['ccID'];
//var_dump($_REQUEST['ccID']);
if(is_array($_REQUEST['fields'])){
	foreach($_REQUEST['fields'] as $id){
		if($fs){
			$field_string .= ',';
		}
		$field_string .= $id;
		$fs++;
	}
}
$controller->fields 	= $field_string;
$controller->displayFeaturedOnly = $_REQUEST['displayFeaturedOnly'];

$cArray = $controller->getPages();


//echo var_dump($cArray);
require(dirname(__FILE__) . '/../view.php');
exit;