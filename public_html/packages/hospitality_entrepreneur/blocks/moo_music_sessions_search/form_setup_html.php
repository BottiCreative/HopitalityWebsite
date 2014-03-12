<?php
defined('C5_EXECUTE') or die('Access Denied.');

Loader::element('editor_init');
Loader::element('editor_config');


?>

<div class-"ccm-block-field-group">
	<h2><?php echo t('Settings'); ?></h2>
	
	<p>Add the result message when a Moo Music Session is found here.  You can use the following tags:</p>
	<p><ul>
		<li>Area Name: [areaname]</li>
		
	</ul>
</p>
	<table>
		<tr>
			<td valign="top">
				<label for="ResultMessage"><?php echo t('No Result Message'); ?></label>
			</td>
		</tr>
		<tr>
			<td><textarea id="ResultMessage"  name="ResultMessage" class="ccm-advanced-editor"><?php echo $ResultMessage; ?></textarea></td>
		</tr>
		
	</table>
	
	<p>Add the message when a Moo Music Session is NOT found here.  You can use the following tags:</p>
	<p><ul>
		<li>The original search: [search]</li>
		
	</ul>
</p>
	<table>
		<tr>
			<td valign="top">
				<label for="ResultMessage"><?php echo t('Result Message'); ?></label>
			</td>
		</tr>
		<tr>
			<td><textarea id="NoResultMessage"  name="NoResultMessage" class="ccm-advanced-editor"><?php echo $NoResultMessage; ?></textarea></td>
		</tr>
		
	</table>
	
	
	
</div>