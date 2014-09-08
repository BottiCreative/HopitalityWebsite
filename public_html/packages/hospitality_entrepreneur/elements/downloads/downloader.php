<?php defined('C5_EXECUTE') or die('Access Denied'); ?>



<?php

	

	$uh = Loader::helper('concrete/urls');

	$bt = Loader::model('block_types');

	$bt = BlockType::getByHandle('moo_music_file_downloader');



	$files = $fileList->get();

	

	

	

?>



<div id="moomusic-files" class="moomusic-file-downloads moomusic-<?php echo $attributeHandle; ?>">



	<?php 

		

		if(count($files) >0)

		{

	?>

	<ul class="moomusic-file-downloads-list">

	<?php	

			foreach($files as $file)

			{

				//get the most recent version

				$recentVersion = $file->getRecentVersion();

				

	

	?>	

	<li class="<?php echo $recentVersion->getExtension(); ?>">

	<div class="moomusic-file-download">

	<a href="<?php echo $recentVersion->getDownloadURL(); ?>"><?php echo str_replace('_',' ',str_replace('.' . $recentVersion->getExtension(),'',$recentVersion->getTitle())); ?></a>

	

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



</div>

