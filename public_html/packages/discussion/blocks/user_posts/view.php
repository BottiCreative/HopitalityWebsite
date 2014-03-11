<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
$textHelper = Loader::helper("text");

if(is_object($this->area)) {
	$profile = $this->area->getAttribute('profile');
}
if (is_object($profile)) {
	$uID = $profile->getUserID();
} else {
	$uID = $byUserID;
}
$messageList = $this->controller->getPosts($uID);
$messages = $messageList->getPage();
?>

<h2><?php echo t('Posts')?></h2>

<div class="ccm-discussion-messages">

<table border="0" cellspacing="0" cellpadding="0" class="ccm-discussion-message-list">
<tr>
	<th>
	<?php echo $messageList->displaySummary()?>
	</th>
</tr>
<?php  
if ($messageList->getTotal() == 0) { ?>
	<tr>
		<td><?php echo t('No posts found.')?></td>
	</tr>
<?php  } else {
	foreach($messages as $cat) { 
		$ui = $cat->getUserObject();
		$userDateAdded=($ui)?$ui->getUserDateAdded():time();
	?>
		<tr>
			<td valign="top" class="ccm-discussion-message">
			
			<h3><a href="<?php echo $nav->getLinkToCollection($cat)?>"><?php echo $cat->getCollectionName()?></a></h3>
	
			<p><?php echo  $cat->getBody()?></p>
			
			<div class="ccm-discussion-message-attachments">
			<?php  $a = new Area('Attachments'); 
			$attachments = $a->getAreaBlocksArray($cat);
			if (count($attachments) > 0) { ?>
				<?php echo t('Attachments')?>:
			<?php  } 
			$a->display($cat); ?>
			</div>
			
			<div class="ccm-discussion-message-info">
			Posted on <?php echo $cat->getCollectionDatePublic('F d, Y')?> at <?php echo $cat->getCollectionDatePublic("g:i A")?>
			</div>
			
			<?php  
			/*
			$a = new Area("Attachments");
			$attachments = $a->getAreaBlocksArray($cat);
			if(count($attachments)) { ?>
				<span class="ccm-discussion-attachment-link">
				<?php echo  t('Attachments:')?>
				<a href="javascript:void(0)" onclick="ccmDiscussion.downloadAttachments('<?php echo View::url($cat->getCollectionPath(),'download')?>')" title="Download Attachments">
					<?php echo count($attachments)?>
				</a></span>                                           
			<?php  } */
			?>
			
			</td>
			<?php  /*
			<td class="ccm-discussion-category-last-post"><?php 
				print $cat->getUserName() . ' on<br/>' . date(DATE_APP_GENERIC_MDY_FULL, strtotime($cat->getCollectionDateAdded())) . ' at<br/>' . date(DATE_APP_GENERIC_T, strtotime($cat->getCollectionDateAdded()));
			?></td>
			<td><?php echo number_format($cat->getTotalReplies())?></td>*/ ?>
			
		</tr>
	<?php  } ?>
<?php  } ?>
</table>

<?php  $messageList->displayPaging()?>

</div>