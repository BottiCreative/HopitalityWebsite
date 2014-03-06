<?php  defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
$ps = Loader::helper('form/page_selector');
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2>Partner Logo</h2>
	<?php  echo $al->image('field_1_image_fID', 'field_1_image_fID', 'Choose Image', $field_1_image); ?>

	<table border="0" cellspacing="3" cellpadding="0" style="width: 95%;">
		<tr>
			<td align="right" nowrap="nowrap"><label for="field_1_image_internalLinkCID">Link to Page:</label>&nbsp;</td>
			<td align="left" style="width: 100%;"><?php  echo $ps->selectPage('field_1_image_internalLinkCID', $field_1_image_internalLinkCID); ?></td>
		</tr>
		<tr>
			<td align="right" nowrap="nowrap"><label for="field_1_image_altText">Alt Text:</label>&nbsp;</td>
			<td align="left" style="width: 100%;"><?php  echo $form->text('field_1_image_altText', $field_1_image_altText, array('style' => 'width: 100%;')); ?></td>
		</tr>
	</table>
</div>

<div class="ccm-block-field-group">
	<h2>Partner Name</h2>
	<?php  echo $form->text('field_2_textbox_text', $field_2_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Partner Intro</h2>
	<?php  echo $form->text('field_3_textbox_text', $field_3_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Partners Description</h2>
	<textarea id="field_4_textarea_text" name="field_4_textarea_text" rows="5" style="width: 95%;"><?php  echo $field_4_textarea_text; ?></textarea>
</div>

<div class="ccm-block-field-group">
	<h2>Link to Profile</h2>
	<?php  echo $ps->selectPage('field_5_link_cID', $field_5_link_cID); ?>
	<table border="0" cellspacing="3" cellpadding="0" style="width: 95%;">
		<tr>
			<td align="right" nowrap="nowrap"><label for="field_5_link_text">Link Text:</label>&nbsp;</td>
			<td align="left" style="width: 100%;"><?php  echo $form->text('field_5_link_text', $field_5_link_text, array('style' => 'width: 100%;')); ?></td>
		</tr>
	</table>
</div>


