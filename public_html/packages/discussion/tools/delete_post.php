<?php 
$t = Loader::helper('text');
Loader::model('discussion_post', 'discussion');
Loader::model('discussion_track', 'discussion');
$cID = $_GET['cID'];

if (intval($cID) > 0) { 

	$discussionPost = DiscussionPostModel::getByID($cID, 'ACTIVE'); 
	if (!is_object($discussionPost) || ($discussionPost->isError())) {
		throw new Exception('Invalid page.');
	}

	$nh = Loader::helper('navigation');
	if(!$discussionPost->canDelete()) { throw new Exception('Permission Denied'); } 
	
	?>
	
	
	<h2><?php echo t('Are you sure you want to to delete')?> &quot;<?php echo $discussionPost->getCollectionName()?>&quot;?</h2>
	<form method="post" action="<?php echo View::url($discussionPost->getCollectionPath(), 'delete_post')?>">
		<input type="submit" name="submit" value="<?php echo t('Delete')?>" />
	</form>

	
	<?php 
}