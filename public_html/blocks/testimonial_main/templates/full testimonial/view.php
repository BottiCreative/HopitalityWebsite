<?php  defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="testBlockFull">

<div class="grid-3 column nopadLeft">

<div class="testBlockleft">
<?php  if (!empty($field_2_image)): ?>
	<img src="<?php  echo $field_2_image->src; ?>" width="<?php  echo $field_2_image->width; ?>" height="<?php  echo $field_2_image->height; ?>" alt="" />
<?php  endif; ?>

<h5><?php  if (!empty($field_3_textbox_text)): ?>
	<?php  echo htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?>

<span><?php  if (!empty($field_4_textbox_text)): ?>
	<?php  echo htmlentities($field_4_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?></span></h5>


</div>
<div class="testPartnersFull"></div>
</div>

<div class="grid-9 column">
<div class="testBlockInner">

<?php  if (!empty($field_1_textarea_text)): ?>
	<?php  echo nl2br(htmlentities($field_1_textarea_text, ENT_QUOTES, APP_CHARSET)); ?>
<?php  endif; ?>
</div>


</div>
</div>
