<h1>Monitor <?php echo ucfirst($c->getCollectionName())?></h1>
<?php  if($trackSuccess) { ?>	
		<h2><?php echo t('&quot;%s&quot; is now being monitored.', $c->getCollectionName())?></h2>
		<p><a class="command" href="javascript:void(0)" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Close Window')?></a></p>
<?php  } elseif($trackRemoved) { ?>	
		<h2><?php echo t('&quot;%s&quot; is no longer being monitored.', $c->getCollectionName())?></h2>
		<p><a class="command" href="javascript:void(0)" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Close Window')?></a></p>
<?php  } else {
		if($dTrack->userIsTracking($uID)) { // display text for un-tracking.. ?>		
			<h2><?php echo t('Are you sure you would like to un-monitor &quot;%s&quot;?', $c->getCollectionName())?></h2>
			<p><?php echo t('You will no longer receive any emails related to this item.')?></p> 
			<a class="command" href="javascript:void(0)" onclick="ccmDiscussionTrack.viewTrackOverlay('<?php echo urldecode($_REQUEST['removetrackaction'])?>')"><?php echo t('Yes')?></a>
		<?php  } else { ?>
			<h2><?php echo t('Are you sure you would like to monitor &quot;%s&quot;?', $c->getCollectionName())?></h2>
			<p><?php echo t('You will receive an email when any responses are posted.')?></p> 
			<a class="command" href="javascript:void(0)" onclick="ccmDiscussionTrack.viewTrackOverlay('<?php echo urldecode($_REQUEST['trackaction'])?>')"><?php echo t('Yes')?></a>
		<?php  } ?>   
<?php  } ?>