<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php  $c = $b->getBlockCollectionObject(); ?>

<div class="ccm-block-field-group">
<h2><?php echo t('Display Badges of which user?')?></h2>
<?php  if ($c->getCollectionPath() == '/profile') { ?>
	<?php echo t('This block appears on the user profile page. It will show the badges of the profile being viewed.'); ?>
<?php  } else { ?>

	<div id="ccm-discussion-selected-user-wrapper">
	<?php  $form = Loader::helper('form/user_selector');
		print $form->selectUser('byUserID', $byUserID);
		?>
	</div>
<?php  } ?>
</div>