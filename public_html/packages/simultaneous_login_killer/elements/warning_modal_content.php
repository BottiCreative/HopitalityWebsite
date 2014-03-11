<?php  
defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */
$form = Loader::helper('form');
// $captcha = Loader::helper('validation/captcha');
$th = Loader::helper('concrete/urls');
?>
<script>
var WARNING_TOOL_URL = "<?php    echo $th->getToolsURL('exit_warning','simultaneous_login_killer');?>"
</script>
<div style="display:none;">
<div id="warning-wrapper" class="cbcf" style="padding:5px 15px 20px 15px; background:#fff;">
	<h2><?php   echo $warning_heading; ?></h2>
<div class="warning-message"><?php   echo $warning_message; ?></div>
<p><?php   echo t('After reading the message above, please answer this question to activate the button:'); ?><br>
	<form id="warning-agree" method="post" action="">
	<div class="control-group">

		<div class="controls">
			<?php   echo $form->submit('agree', t('I have read and I understand'), array('class' => 'btn-agree', 'style'=>'float:left;'))?>
			<div class="throbber" style="display: none; float:left;">
				<img src="<?php   echo ASSETS_URL_IMAGES; ?>/throbber_white_16.gif" width="16" height="16" alt="" />
				<span><?php   echo t('Processing...'); ?></span>
			</div>
		</div>
	</div>
	</form>
</p>
</div>
</div>