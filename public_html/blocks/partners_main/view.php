<?php  defined('C5_EXECUTE') or die("Access Denied.");
$nh = Loader::helper('navigation');
?>


		<div class="row partnerBlock">
        	<div class="grid-12 columns">
            
            <?php  if (!empty($field_1_image)): ?>
	<?php  if (!empty($field_1_image_internalLinkCID)) { ?><a href="<?php  echo $nh->getLinkToCollection(Page::getByID($field_1_image_internalLinkCID), true); ?>"><?php  } ?><img src="<?php  echo $field_1_image->src; ?>" width="<?php  echo $field_1_image->width; ?>" height="<?php  echo $field_1_image->height; ?>" alt="<?php  echo $field_1_image_altText; ?>" /><?php  if (!empty($field_1_image_internalLinkCID)) { ?></a><?php  } ?>
<?php  endif; ?>

			</div>

<div class="grid-12 columns">
        
        <?php  if (!empty($field_2_textbox_text)): ?>
	<h3><?php  echo htmlentities($field_2_textbox_text, ENT_QUOTES, APP_CHARSET); ?></h3>
<?php  endif; ?>

<?php  if (!empty($field_3_textbox_text)): ?>
	<h4><?php  echo htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET); ?></h4>
<?php  endif; ?>

<?php  if (!empty($field_4_textarea_text)): ?>
	<?php  echo nl2br(htmlentities($field_4_textarea_text, ENT_QUOTES, APP_CHARSET)); ?>
<?php  endif; ?>

<?php  if (!empty($field_5_link_cID)):
	$link_url = $nh->getLinkToCollection(Page::getByID($field_5_link_cID), true);
	$link_text = empty($field_5_link_text) ? $link_url : htmlentities($field_5_link_text, ENT_QUOTES, APP_CHARSET);
	?>
	<a class="partnerLink" href="<?php  echo $link_url; ?>"><?php  echo $link_text; ?></a>
<?php  endif; ?>
			
            
            
		</div>	
	</div>
	






