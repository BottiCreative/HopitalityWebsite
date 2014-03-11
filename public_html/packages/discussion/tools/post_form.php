<?php 
Loader::model('discussion_post', 'discussion');
Loader::model('discussion_track', 'discussion');
$postData = array();
if ($_REQUEST['type'] == 1) {
	Loader::model('attribute/categories/collection');
	$tags = CollectionAttributeKey::getByHandle(DISCUSSION_POST_TAG_HANDLE);
	if($tags instanceof AttributeKey) {
		$postData['showTags'] = true;
		$postData['tags'] = $tags;
		$postData['tagsValue'] = array();
	} else {
		$postData['showTags'] = false;
	}
}
Loader::packageElement('discussion_post_form','discussion',array('postData'=>$postData));
?>
