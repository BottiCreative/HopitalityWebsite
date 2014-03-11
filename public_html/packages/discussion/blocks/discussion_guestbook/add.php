<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<div class="ccm-block-field-group">
<h2><?php echo t('Title')?></h2>
<input type="text" name="title" value="<?php echo t('Comments')?>:" /><br /><br />

<h2><?php echo t('Posting New Responses is Enabled?')?></h2>
<input type="radio" name="displayGuestBookForm" value="1" checked="checked" /> <?php echo t('Yes')?><br />
<input type="radio" name="displayGuestBookForm" value="0" /> <?php echo t('No')?><br />
</div>
<div class="ccm-block-field-group">
<h2><?php echo t('Anonymous Posting');?></h2>
  <?php echo  $form->radio('anonymousPostChoice',DiscussionGuestbookBlockController::ANON_YES,$controller->anonymousPostChoice); echo t('Yes');?><br/>
  <?php echo  $form->radio('anonymousPostChoice',DiscussionGuestbookBlockController::ANON_NO,$controller->anonymousPostChoice); echo t('No');?><br/>
  <?php echo  $form->radio('anonymousPostChoice',DiscussionGuestbookBlockController::ANON_DEFAULT,$controller->anonymousPostChoice); echo t('Default - as set in dashboard options');?><br/>
</div>
<div class="ccm-block-field-group">
<h2><?php echo t('Captcha Usage');?></h2>
  <?php echo  $form->radio('captchaChoice',DiscussionGuestbookBlockController::CAPTCHA_YES,$controller->captchaChoice); echo t('Always');?><br/>
  <?php echo  $form->radio('captchaChoice',DiscussionGuestbookBlockController::CAPTCHA_NO,$controller->captchaChoice); echo t('Never');?><br/>
  <?php echo  $form->radio('captchaChoice',DiscussionGuestbookBlockController::CAPTCHA_ANON,$controller->captchaChoice); echo t('Only for anonymous users');?><br/>
  <?php echo  $form->radio('captchaChoice',DiscussionGuestbookBlockController::CAPTCHA_DEFAULT,$controller->captchaChoice); echo t('Default - as set in dashboard options');?><br/>
</div>
<?php 
	$cThis = 1;
?>

<div class="ccm-block-field-group">
    <h2><?php echo t('Location in Website')?></h2>

      
      <div>
        <input type="radio" name="cThis" id="cThisPageField" value="1" checked />
        <?php echo t('Display discussions located beneath this page')?>
      </div>
      
      <div>
        <input type="radio" name="cThis" id="cOtherField" value="0" <?php  if ($isOtherPage) { ?> checked<?php  } ?> />
        <?php echo t('Display discussions located elsewhere')?>
        <div id="ccm-discussion-selected-page-wrapper" style=" <?php  if (!$isOtherPage) { ?>display: none;<?php  } ?> padding: 8px 0px 8px 24px">
          <?php  $form = Loader::helper('form/page_selector');
			print $form->selectPage('cParentIDValue');
			?>
        </div>
      </div>
      
</div>
