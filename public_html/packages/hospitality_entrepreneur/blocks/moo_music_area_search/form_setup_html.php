<?php
defined('C5_EXECUTE') or die('Access Denied.');


?>

<div class-"ccm-block-field-group">
	<h2><?php echo t('Choose your display type for remaining Moo Music areas'); ?></h2>
	
	<table cellpadding="10" cellspacing="10" style="margin: auto auto;padding: auto auto;">
	<tr>
	<td>
	<input type="radio" name="displayTypeID" <?php echo $displayTypeID == 0 ? 'checked' : '' ?>  id="rbMap" value="0"  />
	</td>
	<td>
	<label for="rbMap"><?php echo t('Map Display (uses google maps to show all areas)'); ?></label>	
	</td>
	<tr>
	<td>
	<input type="radio" name="displayTypeID" <?php echo $displayTypeID == 1 ? 'checked' : '' ?> id="rbForm" value="1"  />
	</td>
	<td><label for="rbForm"><?php echo t('Form Display (insert your details and your target area(s))'); ?></label></td>
	</tr>
	<tr>
	<td>
	<input type="radio" name="displayTypeID" <?php echo $displayTypeID == 2 ? 'checked' : '' ?> id="rbMapForm" value="2"  />
	</td>
	<td>
	<label for="rbMapForm"><?php echo t('Display map and form together'); ?></label>
	</td>
	</tr>
	</table>
</div>