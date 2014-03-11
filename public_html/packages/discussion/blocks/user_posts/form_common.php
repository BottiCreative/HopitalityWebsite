<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
$form = Loader::helper('form');
?>
<fieldset>
<div class="clearfix">
	<label><?php echo t('Display Posts by User')?></label>
	<div class="input">
		<?php  if ($c->getCollectionPath() == '/profile') { ?>
			<p><?php echo t('This block is being added to the user profile page. It will show the posts of the profile being viewed.'); ?></p>
		<?php  } else { 
				print Loader::helper('form/user_selector')->selectUser('byUserID', $byUserID);?>
		<?php  } ?>
	</div>
</div>
<div class="clearfix">
	<label><?php echo t('Number of posts')?></label>
	<div class="input">
		<?php  echo $form->text('num', $num, array('class'=>'span2'));?>
	</div>
</div>
</fieldset>