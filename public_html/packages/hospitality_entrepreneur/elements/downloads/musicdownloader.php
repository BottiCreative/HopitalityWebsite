<?php defined('C5_EXECUTE') or die('Access Denied'); ?>

<?php
	
	$uh = Loader::helper('concrete/urls');
	$bt = Loader::model('block_types');
	$bt = BlockType::getByHandle('moo_music_file_downloader');
	
	$fileList->setItemsPerPage(10);
	
	$filesCount = $fileList->getItemsPerPage();
	$files = $fileList->getPage();
	
	
	$fileList->displaySummary();
	$fileList->displayPagingV2();
	
	global $c;
   $nh = Loader::helper('navigation');
   $cpl = $nh->getCollectionURL($c);
   
	//$files = $fileList->get($filesCount);
	
	
	
?>
<div class="clear"></div>
<div id="moomusic-music" class="moomusic-music-downloads">

	<?php 
		
		if(count($files) >0)
		{
	?>
	<ul class="moomusic-music-downloads-list">
	<?php	
			foreach($files as $file)
			{
				//get the most recent version
				$recentVersion = $file->getRecentVersion();
				
	
	?>	
	<li class="<?php echo $recentVersion->getExtension(); ?>">
	<div class="moomusic-music-download">
	</div>
	<div class="settings">
	<form method="get" action="<?php echo $cpl; ?>">
	<p class="song-title"><?php echo str_replace('_',' ',str_replace('.mp3','',$recentVersion->getTitle())); ?></p>
	<p><input type="submit" class="btn-download" value="Download" name="btnDownloadFile" /></p>
	<p><a href="<?php echo $recentVersion->getDownloadURL(); ?>" onclick="PlayMusic(this);return false;" class="moomusic-play-music"  >Play</a></p>
	<ul class="moomusic-file-stats">
		<li>Downloads: <strong><?php echo $file->getTotalDownloads(); ?></strong></li>
		<li>Last updated:<br /><strong><?php echo $recentVersion->getDateAdded(); ?></strong></li>
		
	</ul>
	
	
	<input type="hidden" name="hdFileID" value="<?php echo $recentVersion->getFileID(); ?>" />
	<input type="hidden" name="hdAttributeID" value="<?php echo $attributeID; ?>" />
	<input type="hidden" name="hdPageNumber" value="<?php echo $attributeID; ?>" />
	</form>
	
	
	
	</div>
	</li>
	<?php			
			}
	?>
	</ul>
	<div class="clear"></div>
	
	
	
	<?php
		
		
		
		}
	
	?>
	
<div id="musicplayer"></div>	

</div>
