<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

$c = Page::getByID($_REQUEST['blog']);
$ak = CollectionAttributeKey::getByHandle('subscription');
$subscribed = $c->getAttribute('subscription');
$ui = UserInfo::getByID($_REQUEST['user']);
$user_removed = false;
if($subscribed){
	$subscribers = array();
	foreach ($subscribed as $uID){
		if($uID != $_REQUEST['user']){
			$subscribers[] = $uID;
		}else{
			$user_removed = true;
		}
	}
}

if(!$user_removed){
	$subscribers[] = $_REQUEST['user'];
}

$c->setAttribute($ak,$subscribers);
$c->reindex();

exit;
?>