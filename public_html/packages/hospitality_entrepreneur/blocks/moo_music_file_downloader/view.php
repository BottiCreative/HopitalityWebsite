<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<?php 

$fileList->filterByAttribute($attributeHandle, true);

?>
<div id="moomusic-file-list" class="<?php echo $attributeHandle; ?>">
	
	<?php
	
	$fileList->sortBy('fvFilename','asc');
	
	switch($attributeHandle)
	{
		
		case "musicdownload" :
			
			 
			
			Loader::packageElement('downloads/musicdownloader',$packageName,array('fileList'=>$fileList, 'attributeID'=> $attributeID, 'attributeHandle' => $attributeHandle));
			
			break;
		default:
			//just load the file downloader
			Loader::packageElement('downloads/downloader',$packageName,array('fileList'=>$fileList, 'attributeID'=> $attributeID, 'attributeHandle' => $attributeHandle));
			break;	
		
		
	}	
		
	
?>	
	
	
					
	
	
</div>
<input type="hidden" id="hdAttributeID" value="<?php echo $attributeID; ?>" />
<input type="hidden" id="hdAttributeHandle" value="<?php echo $attributeHandle; ?>" />
<div id="moomusic-download-file"></div>



