<?php  defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2>Company Logo</h2>
	<?php  echo $al->image('field_1_image_fID', 'field_1_image_fID', 'Choose Image', $field_1_image); ?>

	<table border="0" cellspacing="3" cellpadding="0" style="width: 95%; margin-top: 5px;">
		<tr>
			<td align="right" nowrap="nowrap"><label for="field_1_image_externalLinkURL">Link to URL:</label>&nbsp;</td>
			<td align="left" style="width: 100%;"><?php  echo $form->text('field_1_image_externalLinkURL', $field_1_image_externalLinkURL, array('style' => 'width: 100%;')); ?></td>
		</tr>
		<tr>
			<td align="right" nowrap="nowrap"><label for="field_1_image_altText">Alt Text:</label>&nbsp;</td>
			<td align="left" style="width: 100%;"><?php  echo $form->text('field_1_image_altText', $field_1_image_altText, array('style' => 'width: 100%;')); ?></td>
		</tr>
	</table>
</div>

<div class="ccm-block-field-group">
	<h2>Established</h2>
	<?php  echo $form->text('field_2_textbox_text', $field_2_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Type of Business</h2>
	<?php  echo $form->text('field_3_textbox_text', $field_3_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Number of Members</h2>
	<?php  echo $form->text('field_4_textbox_text', $field_4_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Number Of Clients</h2>
	<?php  echo $form->text('field_5_textbox_text', $field_5_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Company Ethos</h2>
	<?php  echo $form->text('field_6_textbox_text', $field_6_textbox_text, array('style' => 'width: 95%;')); ?>
</div>


