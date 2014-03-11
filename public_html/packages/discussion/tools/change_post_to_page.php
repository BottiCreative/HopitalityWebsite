<?php 
$t = Loader::helper('text');
Loader::model('discussion_post', 'discussion');
Loader::model('discussion_track', 'discussion');
$cID = $_GET['cID'];

$ps = Loader::helper('form/page_selector');
$form = Loader::helper('form');
if (intval($cID) > 0) { 

	$discussionPost = DiscussionPostModel::getByID($cID, 'ACTIVE'); 
	if (!is_object($discussionPost) || ($discussionPost->isError())) {
		throw new Exception('Invalid page.');
	}

	?>
	<style>
	div.ccm-discussion-move-or-copy label {display: inline; font-weight: normal}
	</style>
	
	<form method="post" action="<?php echo View::url($discussionPost->getCollectionPath(), 'promote_to_page')?>" id="ccm-discussion-change-post-to-page-form" onsubmit="return ccmDiscussionCheckChangePostToPage()">
	
	<h2><?php echo t('Post to be Promoted')?></h2>
	<?php  print $discussionPost->getCollectionName()?><br/><Br/>
	
	<?php echo $form->hidden('discussionPostID', $cID); ?>
	<h2><?php echo t('New Parent Page')?></h2>
	<?php echo $ps->selectPage('cParentID')?>
	
	<h2><?php echo t('Page Type')?></h2>
	<?php 
	Loader::model('collection_types');
	$ctArray = CollectionType::getList();
	$options = array();
	foreach($ctArray as $ct) {
		$options[$ct->getCollectionTypeID()] = $ct->getCollectionTypeName();
	}
	print $form->select('ctID', $options);
	print '<br><br/>'; ?>
	
	<h2><?php echo t('Move or Copy?')?></h2>
	<div class="ccm-discussion-move-or-copy"><?php echo $form->radio('moveCopy', 'move', true)?> <?php echo $form->label('moveCopy1', t('Move (Remove Old Post after Creating Page)'))?></div>
	<div class="ccm-discussion-move-or-copy"><?php echo $form->radio('moveCopy', 'copy_retain')?> <?php echo $form->label('moveCopy2', t('Copy and Retain Existing Discussion'))?></div>
	<div class="ccm-discussion-move-or-copy"><?php echo $form->radio('moveCopy', 'copy_new')?> <?php echo $form->label('moveCopy3', t('Copy and Create New Discussion'))?></div>
	<?php 
	print '<br>';
	print $form->submit('submit', t('Change Post'), array('style' => 'float: left'));
	?>
	</form>

	<script type="text/javascript">
	
	ccmDiscussionCheckChangePostToPage = function() {
		var cParentID = $('#ccm-discussion-change-post-to-page-form input[name=cParentID]').val();
		if (cParentID < 1) {
			alert('<?php echo t("You must specify a parent page for the new page you want to create.")?>');
			return false;
		}
		return true;
	}
	
	</script>
	<?php 
}