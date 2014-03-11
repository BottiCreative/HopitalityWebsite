<?php  
	if(defined('MOBILE_THEME_IS_ACTIVE')) { ?>

	<!-- if it's mobile, show nothing -->
	
	<?php  }else{ ?>

<div class="ccm-discussion-replies-count">
<?php   global $c; 

$f = Loader::helper('form');

?>
	
	<form method="get" action="<?php  echo DIR_REL?>/index.php">
	<?php  echo $f->hidden('cID', $c->getCollectionID())?>
	<div class="ccm-discussion-messages-display">

	<strong><?php echo t('Display Messages')?></strong>:
	
	<?php  echo $f->radio('cDiscussionDisplayMode', 'threaded', $mode, array('onclick' => "this.form.submit()")); ?> <?php  echo t('Threaded')?>
	&nbsp;&nbsp;&nbsp;
	<?php  echo $f->radio('cDiscussionDisplayMode', 'flat', $mode, array('onclick' => "this.form.submit()")); ?><?php  echo t('Flat')?>
	
	</form>
	
	</div>

	<strong><?php  echo $replies?></strong> <?php  
		if (($replies) == 1) { 
			print t('Reply');
		} else {
			print t('Replies');
		}
	?>
	

</div>

<?php  } ?>