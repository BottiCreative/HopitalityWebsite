<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<?php 

Loader::helper('form');
Loader::model('sessions','moo_music');
Loader::helper('utilities','moo_music');
Loader::model('areas','moo_music');
Loader::model('product/set','core_commerce');
$uh = Loader::helper('concrete/urls');
$bt = Loader::model('block_types');
$bt = BlockType::getByHandle('moo_music_sessions_search');

$utilityHelper = new MooMusicUtilitiesHelper();

$form = new FormHelper();

$searchTerm = $form->getRequestValue('search');
$ResultMessage = html_entity_decode($form->getRequestValue('resultMessage'));
$NoResultMessage = html_entity_decode($form->getRequestValue('noResultMessage'));
//var_dump($ResultMessage);

$v = View::getInstance();

if(empty($searchTerm))
{
	exit();
	
}

?>
<?php 

//else we have a search term.  Lets do a search.
//get the list of sets so we can get the right one.
$set = new CoreCommerceProductSet();
$sets = $set->getList();

$sessions = array();

//start the process of getting the products
$productList = new MooMusicAreasModel();

foreach($sets as $productSet)
{
	if($productSet instanceof CoreCommerceProductSet)
	{
		if($productSet->prsName == 'MooMusic Areas' )
		{
			//filter by active areas only.
			$sessions = $productList->filterByActiveSessions($searchTerm,15);
			
			
		}
	}
}

$searchCount = count($sessions);


if( $searchCount > 0)
{
	
?>
<!--<img src="/themes/MooTheme/images/close.png" style="width: 16px;" class="closeButton" onclick="jQuery('#searchresults').hide('slow');" />-->
<div class="clear"></div>
<ul>
<?php


foreach($sessions as $session)
{
	$product = $session['product'];
	$farmerID = $product->getAttribute('farmerid');
	
	$farmer = UserInfo::getByID($farmerID);
		
	
	
?>
<li>
<div class="moomusic-area-infowindow">
<div class="ccm-core-commerce-add-to-cart">
<form method="post"> 
<div><?php  echo html_entity_decode(str_replace('[areaname]',$product->getProductName(),$ResultMessage)); ?></div>
<h3>Contact Session Organiser</h3>
<table cellpadding="5">
	
	<tr>
		<td valign="top">
<label for="txtName">Your Name: </label>
		</td>
		<td><input type="text" id="txtName<?php echo $product->getProductID(); ?>" name="txtName<?php echo $product->getProductID(); ?>" />
		</td>
	</tr>
	<tr>
		<td valign="top">
<label for="txtEmail">Your Email: </label>
		</td>
		<td><input type="text" id="txtEmail<?php echo $product->getProductID(); ?>" name="txtEmail<?php echo $product->getProductID(); ?>" />
		</td>
	</tr>
	<tr>
		<td valign="top">
<label for="txtSubject">Subject: </label>
		</td>
		<td><input type="text" id="txtSubject<?php echo $product->getProductID(); ?>" name="txtSubject<?php echo $product->getProductID(); ?>" />
		</td>
	</tr>
	<tr>
		<td valign="top">
<label for="txtMessage">Message: </label>
		</td>
		<td>
			<textarea id="txtMessage<?php echo $product->getProductID(); ?>" cols="30" rows="8" name="txtMessage<?php echo $product->getProductID(); ?>"></textarea>
		</td>
	</tr>
<tr>
<td colspan="2">
	<input type="hidden" id="hdUserID<?php echo $product->getProductID(); ?>" name="hdUserID<?php echo $product->getProductID(); ?>" value="<?php echo $farmerID; ?>" />
<input type="hidden" id="hdProductID<?php echo $product->getProductID(); ?>" name="hdProductID<?php echo $product->getProductID(); ?>" value="<?php echo $product->getProductID(); ?>"  />
<input type="button" id="btnSubmitEmail<?php echo $product->getProductID(); ?>" onclick="EmailMember('<?php echo $product->getProductID(); ?>',this);" name="btnSubmitEmail<?php echo $product->getProductID(); ?>" value="Email Session Organiser" />
</td>
</tr>
</table>

 <p>
<img src="/themes/MooTheme<?php echo $utilityHelper->getrandommoomusicimage() ?>" class="infowindowImage" />
<div class="clear"></div>
</p>

</form>
<div class="clear"></div>
</div> 
</div>
</li>
<?php
}


}
else 
{
//no sessions	

?>
<li>
<?php echo html_entity_decode(str_replace('[search]',$searchTerm,$NoResultMessage)); ?>
<p>
<img src="/themes/MooTheme<?php echo $utilityHelper->getrandommoomusicimage() ?>" class="infowindowImage" />
<div class="clear"></div>
</p>

<div class="clear"></div>
</div> 
</div>
</li>
<?php
}
?>
</ul>
<script type="text/javascript">
	
	function EmailMember(productID,button)
	{
		var name = jQuery('#txtName' + productID).val();
		var email = jQuery('#txtEmail' + productID).val();
		var subject = jQuery('#txtSubject' + productID).val();
		var message = jQuery('#txtMessage' + productID).val();
		var userID = jQuery('#hdUserID' + productID).val();
		jQuery.get(
		
		"<?php echo $uh->getBlockTypeToolsURL($bt); ?>/sessionfunctions",
		{ uID: userID,Message: message, Subject: subject,Name: name,Email: email  },
		function(data, status,misc) {
			
			if(status == "success")
			{
				if($.trim(data) == '')
				{
					alert('Thankyou - your mail has been sent to this Moo Music Session Organisor.');
					jQuery(button).attr('disabled','true');
					jQuery(button).val('Your email has been sent.');
					return;		
				
					
				}
				
				alert(data);
				return;	
					
			}
			
			
				
			
		}
	
	
	);
	
}


	
	
</script>
<div class="clear"></div>
