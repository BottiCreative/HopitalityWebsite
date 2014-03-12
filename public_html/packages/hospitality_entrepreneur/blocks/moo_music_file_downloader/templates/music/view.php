<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>


<?php 
		
				
				//lets start showing all the detail we need depending on the display type.
				if($displayType == DisplayType::map || $displayType == DisplayType::mapForm)
				{
					
					Loader::packageElement('areas/map',$packageName,array('products'=>$products));
					
					
				}
?>

<?php

				if($displayType == DisplayType::mapForm)
				{

?>

<div class="mapInfoCircle">
<p>IS YOUR <br />AREA FREE
Test
</p>
</div>

<?php

					Loader::packageElement('areas/mapform',$packageName);
				}
				
				if($displayType == DisplayType::form)
				{
					
					Loader::packageElement('areas/form',$packageName);
				
				}	
?>


