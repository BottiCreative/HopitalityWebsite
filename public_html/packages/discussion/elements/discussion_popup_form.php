<?php 
$form = Loader::helper('form');
$captcha = Loader::helper('validation/captcha');
$pkg = Package::getByHandle('discussion');
$urls = Loader::helper('concrete/urls');
$u = new User();

if(!isset($postData['noWrapper']) || !$postData['noWrapper']) {?>
<div id="ccm-discussion-post-form-wrapper" style="display:none;">
<?php  } ?>
	<?php echo Loader::packageElement('discussion_post_form','discussion');?>
<?php if(!isset($postData['noWrapper']) || !$postData['noWrapper']) {?>
</div>
<input type='hidden' id="ccm-discussion-post-form-url" value='<?php echo $urls->getToolsURL('post_form','discussion')?>'>
<?php  } ?>
