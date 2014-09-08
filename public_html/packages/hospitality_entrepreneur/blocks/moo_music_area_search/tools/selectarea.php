<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>



<?php 



Loader::helper('form');

Loader::model('product/model','core_commerce');

 Loader::model('order/current','core_commerce');

Loader::helper('utilities','moo_music');

$uh = Loader::helper('urls', 'core_commerce');





$utilityHelper = new MooMusicUtilitiesHelper();



$form = new FormHelper();



$productID = $form->getRequestValue('productID');



$v = View::getInstance();







if(empty($productID))

{

	exit();

	

}



?>

<?php 



//else we have a search term.  Lets do a search.

$searchProduct = new CoreCommerceProduct();

$product = $searchProduct->getByID(intval($productID));



	

?>

<!--<img src="/themes/MooTheme/images/close.png" style="width: 16px;" class="closeButton" onclick="jQuery('#searchresults').hide('slow');" />-->

<?php





	//sort out the google static map....

	$latitude = $product->getAttribute('latitude');

	$longitude = $product->getAttribute('longitude');

	$pathCoordinates = $product->getAttribute('borders');

	

	$paths = explode("\n\r",$pathCoordinates);

	

	//$pipe = urlencode('|');

	

	//BASE_URL .

	$image =  BASE_URL . '/themes/MooTheme/images/moo-music-logo-small.png';

	//$googleMapUrl = "https://maps.googleapis.com/maps/api/staticmap?size=280x280&center={$latitude},{$longitude}&markers=icon:{$image}{$pipe}{$latitude},{$longitude}&zoom=13&sensor=false&key=AIzaSyDw7irck_KNNx1gYHriiKD6PITWpTnZdp0";

	//$googleMapUrl = "https://maps.googleapis.com/maps/api/staticmap?size=280x280&center={$latitude},{$longitude}&markers={$latitude},{$longitude}&path=color:0x00000000{$pipe}weight:5{$pipe}fillcolor:0xFFFF0033{$pipe}{$outline}&zoom=13&sensor=false&key=AIzaSyDw7irck_KNNx1gYHriiKD6PITWpTnZdp0";

	

?>

<div class="moomusic-area-infowindow">

<div class="ccm-core-commerce-add-to-cart">

<form method="post"  id="ccm-core-commerce-add-to-cart-form-<?php echo $product->getProductID() ?>" action="/cart/update/">



<!--<img src="/themes/MooTheme<?php echo $utilityHelper->getrandommoomusicimage() ?>" class="infowindowImage" />-->



<h2><span>You've Selected</span> <?php echo $product->getProductName() ?></h2>

<h3>&pound;<?php echo $product->getProductPrice() ?></h3>

<?php 



$dateLocked = $utilityHelper->IsAreaLocked($product);







if(!$product->isSoldOut() && !$dateLocked)

{



//lets lock the area

$utilityHelper->LockArea($product);



	

?>

<p><input type="submit" class="buylink"  value="Add this area to your shopping cart" /></p>



<script type="text/javascript">

	

	jQuery('form').submit(function() {

		

		jQuery('.cc-cart-links').show();

		

	})

	

</script>



<?php

}

else 

{




?>

<p><input type="button" class="buylink" value="This area is not available at this time" /></p>

<?php

if($dateLocked)

{



?>	



<p><?php echo $product->getAttribute('postcode'); ?> is locked untill <strong><?php echo date('g:iA',strtotime($product->getAttribute('date_locked'))); ?>.</strong></p>



<?php



}



?>



<!--Put the register interest form here.  -->

<?php

}

?>

<img src="/updates/concrete5.6.1.2_updater/concrete/images/throbber_white_16.gif" width="16" height="16" class="ccm-core-commerce-add-to-cart-loader" style="display: none;" /> 



<div class="clear"></div>



<script type="text/javascript">

	

	$(function() {

		

		ccm_coreCommerceRegisterAddToCart('ccm-core-commerce-add-to-cart-form-<?php echo $product->getProductID(); ?>','<?php   echo $uh->getToolsURL('cart_dialog')?>');

	

	

	});

	

	

</script>



<input type="hidden" name="productID" id="productID" value="<?php echo $product->getProductID(); ?>" />



</form>

<div class="clear"></div>

</div> 

<div id="moomusic-areamap" class="moomusic-map-image" style="width: 800px;height: 600px; background: #000;">

</div>

</div>

<script type="text/javascript">

	

	var polyGon = [

		<?php 

		for($ndx = 0;$ndx < count($paths);$ndx++)

		{

			$path = trim($paths[$ndx]);

			if(!empty($path))

			{

						

				if($ndx == count($paths) - 1)

				{

					

					echo "new google.maps.LatLng({$path})";	

				}

				else 

				{

					echo "new google.maps.LatLng({$path}),";

				}	

				

			}

			

		}

		?>

	];

	

	

	

	var latLngCenter = new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>);

	

	var createdMap = mooMusicAreaInitialize('moomusic-areamap',polyGon,latLngCenter);	

	

	googleMarker = new google.maps.Marker({

		      position: latLngCenter,

		      map: createdMap,

		      title:'<?php echo $product->getProductName(); ?>',

		      icon: '<?php echo $image; ?>'

		   });

		  

	google.maps.event.trigger(createdMap, 'resize');

	

	

	

		

	

				

</script>





<div class="clear"></div>