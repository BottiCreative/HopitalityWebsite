<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));
$filesets = $this->controller->getFileSets();
?>
<ul class="ccm-dialog-tabs" id="ccm-downloadsblock-tabs">
	<li class="ccm-nav-active"><a href="javascript:void(0)" id="ccm-downloadsblock-tab-filesets"><?php    echo t('File Set'); ?></a></li>
	<li><a href="javascript:void(0)" id="ccm-downloadsblock-tab-filters"><?php    echo t('Filters'); ?></a></li>
	<li><a href="javascript:void(0)" id="ccm-downloadsblock-tab-display"><?php    echo t('Display Options'); ?></a></li>
</ul>

<div id="ccm-downloadsBlockPane-filesets" class="ccm-downloadsBlockPane">

	<div style="padding: 10px;">
	<table>
	<tr>
		<td valign="top" width="20">
			<input type="checkbox" name="all_files" id="all_files_checkbox" value="Y" <?php  
			if ($all_files == "Y")
				echo ' checked="checked"';
			?> />
		</td>
		<td valign="top">
			<label for="all_files_checkbox"><?php   echo t("All files (file set filter is not applied)"); ?></label>
		</td>
	</tr>
	<tr style="display: none;" class="swp-downloads-list-all-files-alert">
		<td colspan="2">
			<div style="border: 2px solid #990000; margin: 5px; padding: 5px; background-color: #ffe0e0;">
			<?php   echo t("<strong>File set filter is not applied.</strong> It means that ALL files from your filemanager will be displayed unless you define some attribute filter(s). Make sure that you define correct filters (see Filters tab)"); ?>
			</div>
		</td>
	</tr>
	</table>
	<div class="swp-downloads-list-filesets" style="padding-top: 5px;">
	<h2><?php   echo t("Select file set:"); ?></h2>
	<div class="swp-downloads-list-fileset-selectors">
	<?php  
	if (empty($filesets)) {
		echo t('No file sets found. Create a new one in %sFile Manager</a> <em>(link will open in new window)</em>', '<a href="'.$this->url("/dashboard/files").'" target="_blank">');
	} else {
		echo '<table>';
		foreach($filesets as $k=>$fs) {
			echo '<tr>';
			echo '<td valign="bottom">';
			echo '<input type="radio" name="fileset" value="'. $fs->getFileSetID() .'" id="fileset-'. $fs->getFileSetID() .'" '. (($fs->getFileSetID() == $fileset) ? ' checked="checked"' : '') .' />';
			echo '</td><td valign="bottom">';
			echo '<label for="fileset-'. $fs->getFileSetID() .'" style="margin: 0;">'.$fs->getFileSetName().'</label>';
			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	?>
	</div>
	</div>

	</div>	
</div>

<div id="ccm-downloadsBlockPane-filters" class="ccm-downloadsBlockPane" style="display: none;">

	<div style="padding: 10px;">
	
	<?php  
	$checkboxes = $this->controller->getFileAttributesList();
	
	if (empty($checkboxes)) {
		echo t("No file attributes of boolean type (checkbox) found.");
	} else {
	
		echo t('Here you can define which attributes of boolean type (checkbox) the files should have switched to YES.');
	
		echo '<br />';
		echo '<table>';
		foreach($checkboxes as $attr) {
			echo '<tr>';
			
			echo '<td valign="middle">';
			
			$checked = '';
			if (in_array($attr->getAttributeKeyHandle(), $this->controller->getAttrFilters())) {
				$checked = ' checked="checked"';
			}
			
			echo '<input type="checkbox" id="checkbox_'. $attr->getAttributeKeyHandle() .'" name="attr_filters['. $attr->getAttributeKeyHandle() . ']" value="Y" '.$checked.' />';
			echo '</td>';
			
			echo '<td valign="middle">';
			echo '<label for="checkbox_'. $attr->getAttributeKeyHandle() .'">';
			echo $attr->getAttributeKeyName();
			echo '</label>';
			echo '</td>';
			
			echo '</tr>';
		}
		echo '</table>';
	
	}
	?>
	
	</div>
	
</div>

<div id="ccm-downloadsBlockPane-display" class="ccm-downloadsBlockPane" style="display: none;">

	<div style="padding: 10px;">
	
	<table>
	<tr>
		<td><input type="checkbox" id="checkbox-display_columns" name="display_columns" value="Y" <?php   if ($display_columns == "Y") echo ' checked="checked"'; ?> /></td>
		<td><label for="checkbox-display_columns" style="margin: 0;"><?php   echo t("Display column names (&quot;Filename&quot; and other)"); ?></label></td>
	</tr>
	<tr>
		<td><input type="checkbox" id="checkbox-display_date" name="display_date" value="Y" <?php   if ($display_date == "Y") echo ' checked="checked"'; ?> /></td>
		<td><label for="checkbox-display_date" style="margin: 0;"><?php   echo t("Display date and time of the latest update"); ?></label></td>
	</tr>
	<tr>
		<td><input type="checkbox"  id="checkbox-display_downloads_count" name="display_downloads_count" value="Y" <?php   if ($display_downloads_count == "Y") echo ' checked="checked"'; ?> /></td>
		<td><label for="checkbox-display_downloads_count" style="margin: 0;"><?php   echo t("Display number of downloads"); ?></label></td>
	</tr>
	<tr>
		<td><input type="checkbox" id="checkbox-display_filesize" name="display_filesize" value="Y" <?php   if ($display_filesize == "Y") echo ' checked="checked"'; ?> /></td>
		<td><label for="checkbox-display_filesize" style="margin: 0;"><?php   echo t("Display file size"); ?></label></td>
	</tr>
	</table>
	
	<?php  
	$available_attributes = $this->controller->getFileAttributesList(false);
	?>
	<table>
	<tr>
		<td><?php   echo t("Sort List By:"); ?> </td>
		<td>
		<select name="sortBy" id="swp-dl-sortBySelector">
			<option value="default">Default order</option>
			<option value="date_desc"<?php   if ($sortBy == "date_desc") echo ' selected="selected"'; ?>><?php   echo t("Date: newest first"); ?></option>
			<option value="date_asc"<?php   if ($sortBy == "date_asc") echo ' selected="selected"'; ?>><?php   echo t("Date: oldest first"); ?></option>
			<option value="filename_asc"<?php   if ($sortBy == "filename_asc") echo ' selected="selected"'; ?>><?php   echo t("Filename"); ?></option>
			<option value="filesize_desc"<?php   if ($sortBy == "filesize_desc") echo ' selected="selected"'; ?>><?php   echo t("File size: largest first"); ?></option>
			<option value="filesize_asc"<?php   if ($sortBy == "filesize_asc") echo ' selected="selected"'; ?>><?php   echo t("File size: smallest first"); ?></option>
			<option value="popularity_desc"<?php   if ($sortBy == "popularity_desc") echo ' selected="selected"'; ?>><?php   echo t("Number of downloads"); ?></option>
			<option value="attribute"<?php   if (strpos($sortBy, "attribute") === 0) echo ' selected="selected"'; ?><?php  
			if (empty($available_attributes))
				echo ' disabled="disabled" style="background-color: #cccccc;"';
			
			?>><?php   echo t("Attribute"); ?></option>			
		</select>
	<?php  
	if (!empty($available_attributes)) {
	?>
			<select name="sort_attribute" class="swp-downloads-list-sortby-attrs" style="display: none;"><?php  
			foreach($available_attributes as $attr) {
				$selected = '';
				if ($attr->getAttributeKeyHandle() == $this->controller->getSortAttribute($sortBy)) {
					$selected = ' selected="selected"';
				}
				echo '<option value="'. $attr->getAttributeKeyHandle() .'"'.$selected.'>'. $attr->getAttributeKeyName() .'</option>';
			}
			?></select>
			
			<select name="sort_attribute_dir" class="swp-downloads-list-sortby-attrs" style="display: none;">
				<option value="asc"><?php   echo t("Ascending"); ?></option>
				<option value="desc"<?php  
				if ($this->controller->getSortAttributeDirection($sortBy) == "desc")
					echo ' selected="selected"';
				?>><?php   echo t("Descending"); ?></option>
			</select>
	<?php  
	} // available attributes
	?>
		</td>
	</tr>
	</table>
	
	<br /><b><?php  echo t("Pagination"); ?></b>
	<table>
	<tr>
	<td colspan="2">
	<?php  echo t("Limit number of items displayed"); ?>
	<input type="text" size="3" name="items_per_page" value="<?php 
		if (intval($items_per_page) > 0)
			echo intval($items_per_page);
	?>" /></td>
	</tr>
	<tr>
	<td style="width: 20px;">
	<input type="checkbox" name="paginate" value="Y" <?php 
	if ($paginate == "Y") {
		echo ' checked="checked"';
	}
	?> />
	</td>
	<td>
	<?php  echo t("Display pagination if more items are available"); ?>
	</td>
	</tr>
	</table>
	</div>

</div>