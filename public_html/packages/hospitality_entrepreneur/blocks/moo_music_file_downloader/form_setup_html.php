<?php
defined('C5_EXECUTE') or die('Access Denied.');


?>

<div class-"ccm-block-field-group">
	<h2><?php echo t('Choose your type of file to be displayed on the page'); ?></h2>
	<?php
		
		//get moomusic attribute set.
		$mooMusicAttributeSet = AttributeSet::getByHandle('moomusic');
		
		$attributeKeys = $mooMusicAttributeSet->getAttributeKeys();
		
		if(count($attributeKeys) > 0)
		{
			
	?>
	<ul>
	
	<?php
			foreach($attributeKeys as $attributeKey)
			{
	?>		
				
				<li><input type="radio" id="<?php echo $attributeKey->getKeyHandle(); ?>" <?php echo $displayTypeID == $attributeKey->getKeyID() ? 'checked' : '' ?> name="displayTypeID" value="<?php echo $attributeKey->getKeyID(); ?>" /> 
					<label for="<?php echo $attributeKey->getKeyHandle(); ?>" ><?php echo $attributeKey->getKeyName(); ?></label>
				</li>
						
	
	<?php		
		
			}
	?>
	
	</ul>
	
	<?php
	
		}
	?>
	
	
</div>