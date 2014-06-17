<?php  defined('C5_EXECUTE') or die("Access Denied.");
$nh = Loader::helper('navigation');
?>

<!--<title>Right Testimonial</title>-->

<div class="testHolderRight">

<div class="grid-9 columns nopad">

<div class="testWrapper">

<div class="arrow-right"></div>
	
<div class="testWrapperInside">

<!-- Begin Testimonial Headline -->
<?php  if (!empty($field_4_textbox_text)): ?>
	<h6><?php  echo htmlentities($field_4_textbox_text, ENT_QUOTES, APP_CHARSET); ?></h6>
<?php  endif; ?><!-- End Testimonial Headline -->

<!-- Begin Testimonial Body -->
<?php  if (!empty($field_5_textarea_text)): ?>
	<p><?php  echo nl2br(htmlentities($field_5_textarea_text, ENT_QUOTES, APP_CHARSET)); ?></p>
<?php  endif; ?><!-- End Testimonial Body -->

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

</div><!--testWrapper-->

</div>

<div class="grid-3 columns">

<!-- Begin Testimonial Image -->
<?php  if (!empty($field_6_image)): ?>
	<div class="testImage">
	<?php  if (!empty($field_6_image_internalLinkCID)) { ?><a href="<?php  echo $nh->getLinkToCollection(Page::getByID($field_6_image_internalLinkCID), true); ?>"><?php  } ?><img src="<?php  echo $field_6_image->src; ?>" width="<?php  echo $field_6_image->width; ?>" height="<?php  echo $field_6_image->height; ?>" alt="<?php  echo $field_6_image_altText; ?>" /><?php  if (!empty($field_6_image_internalLinkCID)) { ?></a><?php  } ?>
	</div>
<?php  endif; ?><!-- End Testimonial Image -->

</div>

</div>

<div class="clearfix"></div>