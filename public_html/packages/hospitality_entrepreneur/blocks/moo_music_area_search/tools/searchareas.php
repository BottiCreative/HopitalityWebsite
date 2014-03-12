<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<?php 

Loader::helper('form');
Loader::model('areas','moo_music');
Loader::helper('utilities','moo_music');
$uh = Loader::helper('urls', 'core_commerce');

$ch = Loader::helper('concrete/urls');
$bt = Loader::model('block_types');
$bt = BlockType::getByHandle('moo_music_area_search');


$utilityHelper = new MooMusicUtilitiesHelper();

$form = new FormHelper();

$searchTerm = $form->getRequestValue('search');

$v = View::getInstance();

if(empty($searchTerm))
{
	exit();
	
}

?>
<?php 

//else we have a search term.  Lets do a search.
$searchPostcode = new MooMusicAreasModel();
$searchPostcode->setNameSpace("postcode");
$searchPostcode->filterByStatus(1);
$searchPostcode->filterByAttribute('postcode',strtoupper($searchTerm));

$searchCount = $searchPostcode->getTotal();
$searchObject = $searchPostcode;




if($searchCount < 1)
{
	//no results from just postcode search - lets do a keyword search.	
	$searchKeyword = new MooMusicAreasModel();
	$searchKeyword->setNameSpace("keyword");
	$searchKeyword->filterByKeywords($searchTerm);
	$searchKeyword->filterByStatus(1);
	$searchObject = $searchKeyword;
	$searchCount = $searchObject->getTotal();
}

if( $searchCount > 0)
{
	
?>
<!--<img src="/themes/MooTheme/images/close.png" style="width: 16px;" class="closeButton" onclick="jQuery('#searchresults').hide('slow');" />-->
<div class="clear"></div>
<ul>
<?php


$searchResults = $searchObject->get();

foreach($searchResults as $searchResult)
{
	//sort out the google static map....
	$latitude = $searchResult->getAttribute('latitude');
	$longitude = $searchResult->getAttribute('longitude');
	//$pathCoordinates = $searchResult->getAttribute('borders');
	
	//$paths = explode("\n\r",$pathCoordinates);
	
	//$pipe = urlencode('|');
	
	//BASE_URL .
	//$image =  BASE_URL . '/themes/MooTheme/images/moo-music-logo-small.png';
	//$googleMapUrl = "https://maps.googleapis.com/maps/api/staticmap?size=280x280&center={$latitude},{$longitude}&markers=icon:{$image}{$pipe}{$latitude},{$longitude}&zoom=13&sensor=false&key=AIzaSyDw7irck_KNNx1gYHriiKD6PITWpTnZdp0";
	//$googleMapUrl = "https://maps.googleapis.com/maps/api/staticmap?size=280x280&center={$latitude},{$longitude}&markers={$latitude},{$longitude}&path=color:0x00000000{$pipe}weight:5{$pipe}fillcolor:0xFFFF0033{$pipe}{$outline}&zoom=13&sensor=false&key=AIzaSyDw7irck_KNNx1gYHriiKD6PITWpTnZdp0";
	
?>
<li>
<div class="moomusic-area-infowindow">
<div class="ccm-core-commerce-add-to-cart">

<?php 

	$dateLocked = $utilityHelper->IsAreaLocked($searchResult);

	if(!$searchResult->isSoldOut() && !$dateLocked)
	{
	
?>



<form method="post"  id="ccm-core-commerce-add-to-cart-form-<?php echo $searchResult->getProductID() ?>" action="/cart/update/"> 

<h2>Congratulations... <?php echo $searchResult->getAttribute('postcode') ?> is available!</h2>
<h3><?php echo $searchResult->getProductName(); ?></h3>
<h4><input type="submit" class="buylink"  value="Buy Now for &pound;<?php echo $searchResult->getProductPrice() ?>" /></h4>
<img src="/updates/concrete5.6.1.2_updater/concrete/images/throbber_white_16.gif" width="16" height="16" class="ccm-core-commerce-add-to-cart-loader" style="display: none;" /> 
<script type="text/javascript">
	
	$(function() {
		
		ccm_coreCommerceRegisterAddToCart('ccm-core-commerce-add-to-cart-form-<?php echo $searchResult->getProductID(); ?>','<?php   echo $uh->getToolsURL('cart_dialog')?>');
	
	
	});



	jQuery('form').submit(function() {
		
		jQuery('.cc-cart-links').show();
		
		//now lock the area.
		jQuery.get(
		
		"<?php echo $ch->getBlockTypeToolsURL($bt); ?>/lockarea",
		{ areaid: jQuery('#productID').val() },
		function(data, status,misc) {
			if(status == "success")
			{
				if(typeof console !== undefined)
				{
					console.log('Area Locked');
					
				}
			}
			
		});
		
		
		
	})
	
</script>

<input type="hidden" name="productID" id="productID" value="<?php echo $searchResult->getProductID(); ?>" />

</form>


<?php

}
else 
{
	
?>

<h2>We're sorry... <?php echo $searchResult->getAttribute('postcode') ?> is NOT available at this time!</h2>
<h3><?php echo $searchResult->getProductName(); ?></h3>
<h4 style="font-size: 1.2em;"><?php echo $searchResult->getAttribute('postcode') ?> may be available soon... Register your interest here!</h4>
<!--<h4>Price for this area: &pound;<?php echo $searchResult->getProductPrice() ?></h4>-->
<div class="areaFormHolder" style="width: 290px;">
<script type="text/javascript" src="http://www.moo-music.co.uk/crm/cache/include/javascript/sugar_grp1.js?v=UBUNcexFgPk3kbLZHFwPvQ"></script>
<script type="text/javascript" src="http://www.moo-music.co.uk/crm/cache/include/javascript/calendar.js?v=UBUNcexFgPk3kbLZHFwPvQ"></script>
<form id="WebToLeadForm" action="http://www.moo-music.co.uk/crm/index.php?entryPoint=WebToLeadCapture" method="POST" name="WebToLeadForm">

<table style="width: 100%;">
<tbody>
<tr>
<td align="center"><input id="first_name" type="text" name="first_name" class="watermark smallwatermark" value="First Name*"   /></td>
<td align="center"><input id="last_name" type="text" name="last_name" value="Last Name*" class="watermark smallwatermark"  />
	
	
</td>
</tr>
<tr>
	<td align="center"><input id="phone_home" type="text" name="phone_home" value="Contact Number" class="watermark smallwatermark"  /></td>
	<td align="center"><input id="email1" type="text" name="email1" value="Email Address" onchange="validateEmailAdd();" class="watermark smallwatermark" /></td>
</tr>
<tr align="center">
<td colspan="2">
	<input id="SignUpButton" style="font-size: 1.1em;" class="SignUpButton" onclick="submit_form();" type="button" value="Register Your Interest" /></td>
</tr>
</tbody>
</table>
<input id="department" type="hidden" name="department" value="<?php echo $searchResult->getAttribute('postcode') ?>" />
<input id="redirect_url" type="hidden" name="redirect_url" value="http://www.letsmakemoomusic.co.uk/video" />
<input id="campaign_id" type="hidden" name="campaign_id" value="47b1ec1f-8e52-3d80-0107-52e6f820378e" />
<input id="assigned_user_id" type="hidden" name="assigned_user_id" value="a178c7c6-e995-f3ed-483c-522b827bc1b4" />
<input id="req_id" type="hidden" name="req_id" value="last_name;" />

</form>
<script type="text/javascript">// <![CDATA[
 function submit_form(){
 	if(typeof(validateCaptchaAndSubmit)!='undefined'){
 		validateCaptchaAndSubmit();
 	}else{
 		check_webtolead_fields();
 	}
 }
 function check_webtolead_fields(){
     if(document.getElementById('bool_id') != null){
        var reqs=document.getElementById('bool_id').value;
        bools = reqs.substring(0,reqs.lastIndexOf(';'));
        var bool_fields = new Array();
        var bool_fields = bools.split(';');
        nbr_fields = bool_fields.length;
        for(var i=0;i<nbr_fields;i++){
          if(document.getElementById(bool_fields[i]).value == 'on'){
             document.getElementById(bool_fields[i]).value = 1;
          }
          else{
             document.getElementById(bool_fields[i]).value = 0;
          }
        }
      }
    if(document.getElementById('req_id') != null){
        var reqs=document.getElementById('req_id').value;
        reqs = reqs.substring(0,reqs.lastIndexOf(';'));
        var req_fields = new Array();
        var req_fields = reqs.split(';');
        nbr_fields = req_fields.length;
        var req = true;
        for(var i=0;i<nbr_fields;i++){
          if(document.getElementById(req_fields[i]).value.length <=0 || document.getElementById(req_fields[i]).value==0){
           req = false;
           break;
          }
        }
        if(req){
        	alert('Thanks for your interest... you will now be redirected back to our main page.  We\'ll be in touch!');
            document.WebToLeadForm.submit();
            return true;
        }
        else{
          alert('Please provide all the required fields');
          return false;
         }
        return false
   }
   else{
   	alert('Thanks for your interest... you will now be redirected back to our main page.  We\'ll be in touch!');
    document.WebToLeadForm.submit();
   }
}
function validateEmailAdd(){
	if(document.getElementById('email1') && document.getElementById('email1').value.length >0) {
		if(document.getElementById('email1').value.match(/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/) == null){
		  alert('Not a valid email address');
		}
	}
	if(document.getElementById('email2') && document.getElementById('email2').value.length >0) {
		if(document.getElementById('email2').value.match(/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/) == null){
		  alert('Not a valid email address');
		}
	}
}
// ]]>


	$(document).ready(function(){
		$('.watermark').watermark();
	});
	
</script>

</div>

<?php
if($dateLocked)
{

?>	

<p><?php echo $searchResult->getAttribute('postcode'); ?> is locked untill <strong><?php echo date('g:iA',strtotime($searchResult->getAttribute('date_locked'))); ?>.</strong></p>

<?php

}


}
?>


<p>
<img src="/themes/MooTheme<?php echo $utilityHelper->getrandommoomusicimage() ?>" class="infowindowImage" />

<a class="moomusic-selectlink" href="/cart/update/" onclick="ShowProduct('<?php echo $searchResult->getProductID(); ?>');return false;" >Click here to view the map of this area</a>

<div class="clear"></div>
</p>

<div class="clear"></div>
</div> 
</div>

</li>
<?php } 

?>

</ul>

<div class="clear"></div>

<?php
}
else {


?>
<div class="clear"></div>
<ul>
<li>
<div class="moomusic-area-infowindow">
<h2>Sorry... We couldn't find an area for you.  Please try again.</h2>
<p style="text-align:center;"><img src="/themes/MooTheme<?php echo $utilityHelper->getrandommoomusicimage() ?>"  />
</p>
</div>
</li>
</ul>

<div class="clear"></div>
<?php

}

