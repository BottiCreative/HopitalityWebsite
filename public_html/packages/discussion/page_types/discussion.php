<?php 
$u = new User();
if (in_array($this->controller->getTask(), array('track','do_track','remove_track'))) {
	$u = new User();
	$uID = $u->getUserID();
	Loader::packageElement('discussion_track', 'discussion', array('c' => $c, 'uID' => $uID, 'actionTrack' => $this->action('do_track'), 'actionRemoveTrack' => $this->action('remove_track'), 'dTrack' => $dTrack, 'trackSuccess'=> $trackSuccess, 'trackRemoved' => $trackRemoved));
} else {

	Loader::packageElement('discussion_breadcrumb', 'discussion');
	//Loader::packageElement('discussion_filter_form', 'discussion');

	$a = new Area('Main');
	$a->display($c);
	Loader::packageElement('discussion_reply_popup_form', 'discussion', array( 'postData'=>array('monitorPost'=>1, 'showTags'=>1, 'tagsValue'=>array()), 'captchaRequired'=>$captchaRequired, 'anonAttachments'=>$anonAttachments, 'formAction' => 'add_post' ));
	?>

	<ul class="ccm-discussion-menu">
		<?php  if($u->isRegistered()) { ?>
				<li><a href="javascript:void(0)" onclick="ccmDiscussionTrack.viewTrackOverlay('<?php echo $this->action('track')?>','<?php echo $this->action('do_track')?>','<?php echo $this->action('remove_track')?>');">
				<?php echo  ($dTrack->userIsTracking($u->getUserID())? t("Stop Monitoring") : t("Monitor")) ?></a></li>
		 <?php  } ?>
		<?php 
		if(!$closed) {
		?>
			<li>
			<a href="javascript:void(0)" onclick="<?php echo $startDiscussionAction?>"><?php echo t('Start Discussion')?></a>
			</li>
		<?php  } ?>
	</ul>

	<iframe src="" style="display: none" border="0" id="ccm-discussion-frame" name="ccm-discussion-frame"></iframe>

<?php  if($preload) { // pre-open the form ?>
	<script type="text/javascript">
	<!--
	$(document).ready(function () { <?php echo $startDiscussionAction?>; } );
	//-->
	</script>
<?php  } ?>

<?php  } ?>
