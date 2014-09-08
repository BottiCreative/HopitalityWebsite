<?php    defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<div id="swp-downloads-list-<?php   echo intval($bID)?>" class="swp-downloads-list">
<?php  
if (empty($downloads)) {

	echo t('No downloads available at the moment.');

} else {

	if ($display_columns == "Y") {
		echo '<div class="swp-download-columns">';
		
		// filename
		echo '<div class="swp-download-link">';
		echo '<b>'.t("Filename").'</b>';
		echo '</div>';
		
		if ($display_date == "Y") {
			// last update
			echo '<div class="swp-download-update">';
			echo '<b>'.t("Date").'</b>';
			echo '</div>';		
		}
		
		if ($display_downloads_count == "Y") {
			// downloads count
			echo '<div class="swp-download-count">';
			echo '<b>'.t("Downloads").'</b>';
			echo '</div>';		
		}
		
		if ($display_filesize == "Y") {
			// filesize
			echo '<div class="swp-download-filesize">';
			echo '<b>'.t("Size").'</b>';
			echo '</div>';
		}
			
		echo '<div class="swp-clear"></div>';
		echo '</div>';
	
	} // display columns
	
	foreach($downloads as $index => $fileObj) {
		$fv = $fileObj->getVersion();
		echo '<div class="swp-download-item'. (($index % 2 == 0) ? ' swp-even' : '') . '">';
		
		// filename/download URL
		echo '<div class="swp-download-link">';
		echo '<a href="'. $fv->getDownloadURL() .'" target="_blank">'. $fv->getFileName() .'</a>';
		echo '</div>';
	
		if ($display_date == "Y") {
			// last update
			echo '<div class="swp-download-update">';
			echo $fv->getDateAdded("user");
			echo '</div>';
		}
	
		if ($display_downloads_count == "Y") {
			// downloads count
			echo '<div class="swp-download-count">';
			echo $this->controller->getDownloadsCount($fileObj->getFileID());
			echo '</div>';	
		}
	
		if ($display_filesize == "Y") {
			// filesize
			echo '<div class="swp-download-filesize">';
			echo $fv->getSize();
			echo '</div>';
		}
		
		
	
		// clear:both
		echo '<div class="swp-clear"></div>';
		echo '</div>';
	}
	echo '<div class="ccm-spacer"></div>';
	
	if ($paginate == "Y" && is_object($fl)) {
		echo '<div class="swp-downloads-list-pages">';
		$fl->displayPaging();
		echo '</div>';
	}
}
?>
</div>