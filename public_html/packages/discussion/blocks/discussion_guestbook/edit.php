<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?> 

<div class="ccm-block-field-group">
<h2><?php echo t('Title')?></h2>
<?php echo  $form->text('title',$title,array('style'=>'width:15em'));?>
<br /><br />

<h2><?php echo t('Posting New Responses is Enabled?')?></h2>
<?php echo  $form->radio('displayGuestBookForm',1,$displayGuestBookForm); echo t('Yes'); ?><br />
<?php echo  $form->radio('displayGuestBookForm',0,$displayGuestBookForm); echo t('No'); ?><br />
</div>

<div class="ccm-block-field-group">
<h2><?php echo t('Anonymous Posting');?></h2>
  <?php echo  $form->radio('anonymousPostChoice',DiscussionGuestbookBlockController::ANON_YES,$anonymousPostChoice); echo t('Yes');?><br/>
  <?php echo  $form->radio('anonymousPostChoice',DiscussionGuestbookBlockController::ANON_NO,$anonymousPostChoice); echo t('No');?><br/>
  <?php echo  $form->radio('anonymousPostChoice',DiscussionGuestbookBlockController::ANON_DEFAULT,$anonymousPostChoice); echo t('Default - as set in dashboard options');?><br/>
</div>
<div class="ccm-block-field-group">
<h2><?php echo t('Captcha Usage');?></h2>
  <?php echo  $form->radio('captchaChoice',DiscussionGuestbookBlockController::CAPTCHA_YES,$captchaChoice); echo t('Always');?><br/>
  <?php echo  $form->radio('captchaChoice',DiscussionGuestbookBlockController::CAPTCHA_NO,$captchaChoice); echo t('Never');?><br/>
  <?php echo  $form->radio('captchaChoice',DiscussionGuestbookBlockController::CAPTCHA_ANON,$captchaChoice); echo t('Only for anonymous users');?><br/>
  <?php echo  $form->radio('captchaChoice',DiscussionGuestbookBlockController::CAPTCHA_DEFAULT,$captchaChoice); echo t('Default - as set in dashboard options');?><br/>
</div>

<?php 
	$isOtherPage = ($cParentID>0 && !$cThis);
?>

<div class="ccm-block-field-group">
<h2><?php echo t('Location in Website');?></h2>
    <?php echo t('Select discussions to display');?>:<br/>
    <br/>
    <div>
      
      <div>
        <input type="radio" name="cThis" id="cThisPageField" value="1" <?php  if ($c->getCollectionID() == $cParentID || $cThis) { ?> checked<?php  } ?> />
        <?php echo t('Located beneath this page');?>
      </div>
      
      <div>
        <input type="radio" name="cThis" id="cOtherField" value="0" <?php  if ($isOtherPage) { ?> checked<?php  } ?> />
        <?php echo t('Located beneath another page');?>
        <div id="ccm-discussion-selected-page-wrapper" style=" <?php  if (!$isOtherPage) { ?>display: none;<?php  } ?> padding: 8px 0px 8px 24px">
          <?php  $form = Loader::helper('form/page_selector');
			if ($isOtherPage) {
				print $form->selectPage('cParentIDValue', $cParentID);
			} else {
				print $form->selectPage('cParentIDValue');
			}
			?>
        </div>
      </div>
      
    </div>
</div>
