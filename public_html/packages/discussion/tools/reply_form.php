<?php 
$t = Loader::helper('text');
Loader::model('discussion_post', 'discussion');
Loader::model('discussion_track', 'discussion');
$replyCID = $_GET['replyCID'];
if (intval($replyCID) > 0) {

	$discussionPost = DiscussionPostModel::getByID($replyCID, 'ACTIVE');
	if (!is_object($discussionPost)) {
		throw new Exception(t('Invalid page.'));
	}

	if(!$discussionPost->canEdit()) { throw new Exception(t('Permission Denied - Invalid User')); }

	$a = new Area("Main");
	$abArray = $a->getAreaBlocksArray($discussionPost);
	$mainAreaContent='';
	foreach($abArray as $b) {
		$bi = $b->getInstance();
		$mainAreaContent .= $bi->getTextContent();
	}

	$dTrack = new DiscussionTrack($discussionPost);
	$postData = array('subject' => $discussionPost->getCollectionName(), 'message' => $mainAreaContent, 'cDiscussionPostID' => $replyCID);
	$postData['formActionForumPath'] = View::url($discussionPost->getCollectionPath(), 'reply');
	$u = new User();
	$postData['monitorPost']= $dTrack->userIsTracking($u->getUserID());
	$postData['noWrapper'] = true;


	if(!$_GET['isReply']) {
		Loader::model('attribute/categories/collection');
		$tags = CollectionAttributeKey::getByHandle(DISCUSSION_POST_TAG_HANDLE);
		if($tags instanceof AttributeKey) {
			$value = $discussionPost->getAttributeValueObject($tags);
			$postData['showTags'] = true;
			$postData['tags'] = $tags;
			$postData['tagsValue'] = $value;
			//$postData['tags_label'] = $tags->render('label',null,true);
			//$postData['tags_form']=$tags->render('form',$value,true);
		} else {
			$postData['showTags'] = false;
		}
	}
	Loader::packageElement('discussion_popup_form', 'discussion', array('postData' => $postData));
}
