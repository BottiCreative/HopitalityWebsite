<?php  defined('C5_EXECUTE') or die("Access Denied.");
$nh = Loader::helper('navigation');
?>


<!--<title>Right Testimonial</title>-->

<div class="testHolderLeft">

<div class="testWrap">

<div class="speechBox"></div>


<div class="grid-12 columns">

<!-- Begin Testimonial Headline -->
<?php  if (!empty($field_4_textbox_text)): ?>
	<h3><?php  echo htmlentities($field_4_textbox_text, ENT_QUOTES, APP_CHARSET); ?></h3>
<?php  endif; ?><!-- End Testimonial Headline -->

<!-- Begin Testimonial Body -->
<?php  if (!empty($field_5_textarea_text)): ?>
	<p><?php  echo nl2br(htmlentities($field_5_textarea_text, ENT_QUOTES, APP_CHARSET)); ?></p>
<?php  endif; ?><!-- End Testimonial Body -->

</div>

</div>


<!-- Begin Testimonial Image -->
<?php  if (!empty($field_6_image)): ?>
	<div class="testImage">
	<?php  if (!empty($field_6_image_internalLinkCID)) { ?><a href="<?php  echo $nh->getLinkToCollection(Page::getByID($field_6_image_internalLinkCID), true); ?>"><?php  } ?><img src="<?php  echo $field_6_image->src; ?>" width="<?php  echo $field_6_image->width; ?>" height="<?php  echo $field_6_image->height; ?>" alt="<?php  echo $field_6_image_altText; ?>" /><?php  if (!empty($field_6_image_internalLinkCID)) { ?></a><?php  } ?>
	</div>
<?php  endif; ?><!-- End Testimonial Image -->


<div class="grid-9 columns nopadLeft">

<p class="testName">
<!-- Begin Testimonial Name -->
<strong><?php  if (!empty($field_1_textbox_text)): ?>
	<?php  echo htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?></strong><!-- End Testimonial Name -->

<!-- Begin Testimonial Business -->
<em><?php  if (!empty($field_3_textbox_text)): ?>
	<?php  echo htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?></em><!-- End Testimonial Business -->

<!-- Begin Testimonial Area -->
<?php  if (!empty($field_2_textbox_text)): ?>
	<?php  echo htmlentities($field_2_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?><!-- End Testimonial Area -->
</p>

</div>



</div>

<div class="clearfix"></div>


