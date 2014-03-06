<?php  defined('C5_EXECUTE') or die("Access Denied.");
$nh = Loader::helper('navigation');
?>

<?php  if (!empty($field_1_textbox_text)): ?>
	<h3><?php  echo htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET); ?></h3>
<?php  endif; ?>

<?php  if (!empty($field_2_link_cID)):
	$link_url = $nh->getLinkToCollection(Page::getByID($field_2_link_cID), true);
	$link_text = empty($field_2_link_text) ? $link_url : htmlentities($field_2_link_text, ENT_QUOTES, APP_CHARSET);
	?>
	<a href="<?php  echo $link_url; ?>"><?php  echo $link_text; ?></a>
<?php  endif; ?>

<?php  if (!empty($field_3_image)): ?>
	<img src="<?php  echo $field_3_image->src; ?>" width="<?php  echo $field_3_image->width; ?>" height="<?php  echo $field_3_image->height; ?>" alt="" />
<?php  endif; ?>

<?php  if (!empty($field_4_textarea_text)): ?>
	<p><?php  echo nl2br(htmlentities($field_4_textarea_text, ENT_QUOTES, APP_CHARSET)); ?></p>
<?php  endif; ?>


