<?php  defined('C5_EXECUTE') or die("Access Denied.");
?>


<div class="PartnerFacts">

<?php  if (!empty($field_1_image)): ?>
	<?php  if (!empty($field_1_image_externalLinkURL)) { ?><a href="<?php  echo $this->controller->valid_url($field_1_image_externalLinkURL); ?>" target="_blank"><?php  } ?><img src="<?php  echo $field_1_image->src; ?>" width="<?php  echo $field_1_image->width; ?>" height="<?php  echo $field_1_image->height; ?>" alt="<?php  echo $field_1_image_altText; ?>" /><?php  if (!empty($field_1_image_externalLinkURL)) { ?></a><?php  } ?>
<?php  endif; ?>


<h3>Interesting Facts</h3>



<p><strong>Established</strong>
<?php  if (!empty($field_2_textbox_text)): ?>
	<?php  echo htmlentities($field_2_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?></p>

<p><strong>What they do</strong>
<?php  if (!empty($field_3_textbox_text)): ?>
	<?php  echo htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?></p>

<!--
<p><strong>Number of Members</strong>

<?php  if (!empty($field_4_textbox_text)): ?>
	<?php  echo htmlentities($field_4_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?>
</p>

<p><strong>Number Of Clients</strong>
<?php  if (!empty($field_5_textbox_text)): ?>
	<?php  echo htmlentities($field_5_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?></p>-->

<p><strong>Ethos</strong>
<?php  if (!empty($field_6_textbox_text)): ?>
	<?php  echo htmlentities($field_6_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?>
</p>

</div>


