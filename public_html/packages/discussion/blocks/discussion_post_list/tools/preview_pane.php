<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::block('discussion_post_list','discussion');

$previewMode = true;
$nh = Loader::helper('navigation');
$controller = new DiscussionPostListBlockController($b);


$_REQUEST['num'] = ($_REQUEST['num'] > 0) ? $_REQUEST['num'] : 0;
$_REQUEST['cThis'] = ($_REQUEST['cParentID'] == $controller->cID) ? '1' : '0';
$_REQUEST['cParentID'] = ($_REQUEST['cParentID'] == 'OTHER') ? $_REQUEST['cParentIDValue'] : $_REQUEST['cParentID'];

$controller->num 		= $_REQUEST['num'];
$controller->cParentID 	= $_REQUEST['cParentID'];
$controller->cThis 		= $_REQUEST['cThis'];
$controller->orderBy	= $_REQUEST['orderBy'];
$controller->tagFilter	= $_REQUEST['tagFilter'];
$controller->cID 		= $_REQUEST['pageID'];

$cArray = $controller->getPosts();

//echo var_dump($cArray);
require(dirname(__FILE__) . '/../view.php');
exit;