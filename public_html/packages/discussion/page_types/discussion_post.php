<?php 

$u = new User();
if (in_array($this->controller->getTask(), array('track','do_track','remove_track'))) {
	$u = new User();
	$uID = $u->getUserID();
	Loader::packageElement('discussion_track', 'discussion', array('c' => $c, 'uID' => $uID, 'dTrack' => $dTrack, 'actionTrack' => $this->action('do_track'), 'actionRemoveTrack' => $this->action('remove_track'), 'trackSuccess'=> $trackSuccess, 'trackRemoved' => $trackRemoved));
} else {
	Loader::packageElement('discussion_breadcrumb', 'discussion');
	if ($displayMode == 'threaded') {
		Loader::packageElement('discussion_messages_threaded', 'discussion', array('messageList' => $messageList, 'topic' => $topic, 'av' => $av, 'replies' => $replies));
	} else {
		Loader::packageElement('discussion_messages', 'discussion', array('messageList' => $messageList, 'topic' => $topic));
	}
?>

<ul class="ccm-discussion-menu">
	<?php   if($u->isRegistered()) { ?>
				<li><a href="javascript:void(0)" onclick="ccmDiscussionTrack.viewTrackOverlay('<?php  echo $this->action('track')?>','<?php  echo $this->action('do_track')?>','<?php  echo $this->action('remove_track')?>');">
			<?php  echo  ($dTrack->userIsTracking($u->getUserID())?t("Stop Monitoring"):t("Monitor")) ?></a></li>
	 <?php   } ?>
		<?php 
		if(!$closed ) { // && $u->isRegistered()
		?>
		<li>
		<a href="javascript:void(0)" onclick="<?php  echo $startDiscussionAction?>"><?php  echo t('Reply')?></a>
		</li>
	<?php   } ?>
</ul>

<input type='hidden' id="ccm-discussion-post-form-action" value='<?php echo t("Add Reply")?>'>

<?php   Loader::packageElement('discussion_reply_popup_form', 'discussion', array( 'postData'=>array('monitorPost'=>1,'subject'=>t('Re:') . ' ' . $c->getCollectionName()), 'captchaRequired'=>$captchaRequired, 'formAction'=>'reply' )); ?>

<iframe src="" style="display: none" border="0" id="ccm-discussion-frame" name="ccm-discussion-frame"></iframe>

<?php 
}
