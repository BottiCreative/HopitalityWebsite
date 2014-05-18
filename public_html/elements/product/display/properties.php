<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<div class="ccm-core-commerce-product-property-list">

<?php  
$tmp = array();

Loader::model('product/set','core_commerce');
Loader::model('product/list','core_commerce');

//add the membership name here.  Shoudl ideally be added into a helper or somewhere reusable.  Not a major issue just now
//might bite me in the arse later though :-|
$membershipName = 'Membership';

foreach($properties as $property) {
	$tmp[] = $property->handle;	
}
$hasBothPrices = false;
if (in_array('displayDiscount', $tmp) && in_array('displayPrice', $tmp)) {
	$hasBothPrices = true;
}

foreach($properties as $property) { 

	?>
	
	<?php  if ($property->handle == 'displayName') {
		
	  	if ($displayImage && $imagePosition == 'T') { ?>
		<div class="ccm-core-commerce-add-to-cart-image"><?php echo $img?></div>
		<?php }
		
		
		if ($displayImage && $imagePosition == 'L') { ?>
		<div class="ccm-core-commerce-add-to-cart-image image-left"><?php echo $img?></div>
	  
	  <?php } 		
			
		if ($linkToProductPage) {
			$linksTo = Page::getByID($product->getProductCollectionID());
			$link_before = '<a href="' . Loader::helper('navigation')->getLinkToCollection($linksTo) . '">';
			$link_after = '</a>';
		}		
	?>		
	
		<h2><?php echo $link_before.$product->getProductName().$link_after?></h2>
	
	<?php  } ?>
	
	<!--?php  if ($property->handle == 'displayPrice' && (!$hasBothPrices)) { ?>		
		<div><?php echo Loader::packageElement('product/price', 'core_commerce', array('product' => $product, 'displayDiscount' => false, 'userHasAccess' => $userHasAccess)); ?></div>
	
	<php  } -->
	
	<?php  if ($property->handle == 'displayDiscount') { ?>		

		<div><?php echo Loader::packageElement('product/price', 'core_commerce', array('product' => $product, 'displayDiscount' => true, 'userHasAccess' => $userHasAccess)); ?></div>
	
	<?php  } ?>
	
	<?php  if ($property->handle == 'displayDescription') { 
		
		if($userHasAccess)
		{
		?>		
		
		<div>
		<?php echo $product->getProductDescription()?>
		</div>
	
	<?php 
		}
		else
			{
					
				//Let's use the c5 text object to sanitize input.
				Loader::helper('text');
				
				//configure the percentage of words to limit here....
				$limitCharsPercentage = 0.10;
				
				$numbChars =  round(strlen($product->getProductDescription()) * $limitCharsPercentage);
				
				if($numbChars > 1000)
				{
					//ok, there's more than 1000 chars to limit by - lets change it to 2.5%
					$limitCharsPercentage = 0.025;
					
				}
				
				//if number of chars percentage is less than 50 then increase the percentage
				if($numbChars < 50)
				{
					//lets go for 30%	
					$limitCharsPercentage = 0.30;
					
				} 
				
				$numbChars =  round(strlen($product->getProductDescription()) * $limitCharsPercentage);
				
				
				$textHelper = new TextHelper();	
				$limitedText = $textHelper->sanitize($product->getProductDescription(),$numbChars,'<p><br>'); //substr($product->getProductDescription(),0,round(strlen($product->getProductDescription() * 0.10)));
				
				echo $limitedText;
			?>	
			
			<!-- Lets show the membership here -->
					<?php
					
					//load the custom membership product class.  Use to get the membership name
					Loader::model('membershipproduct','hospitality_entrepreneur');
					Loader::model('membershipproducts','hospitality_entrepreneur');
					
					$membershipProducts = new HospitalityEntrepreneurMembershipProductModel();
					$selectedMembershipLevel = $membershipProducts->getMembershipLevel($product->getProductID());
					
					
					
					$membershipProducts = new HospitalityEntrepreneurMembershipProductsModel();
					$membershipProducts->filterByMembershipName('Free');
					
					
					if(count($membershipProducts) < 1)
					{
						throw new Exception('FREE Membership Signup option cannot be found.');
						
					}
					
					//get the first product  - it should be the FREE
					$freeMembershipProduct = $membershipProducts->get(0);
					
					//now, reset the search, and lets try and if this product has a membership level then we get the membership that needs to be added. 
					$membershipProducts = new HospitalityEntrepreneurMembershipProductsModel();
					//$membershipNameProduct->filterByMembershipName($selectedMembershipLevel);
					$membershipProducts->filterByMembershipName($selectedMembershipLevel);
					
					$selectedMembershipProduct = null;
					
					if($membershipProducts->getTotal() > 0)
					{
						$arrSelectedMembershipProduct = $membershipProducts->get(0);
						$selectedMembershipProduct = $arrSelectedMembershipProduct[0];
					}
					
					
					
					
					//now lets show the form.
					echo Loader::packageElement('membershipsignup/view', 'hospitality_entrepreneur', 
												array('membershipproduct' => $selectedMembershipProduct
													,'controller' => $this,
													'producttobuy' => $product,
													'freemembershipproduct' => $freeMembershipProduct[0]));
					
					
					
					?>
					
						<?php	
			}
	 } ?>
	
	<?php  if ($property->handle == 'displayDimensions') { ?>		
	
		<div>
		<strong><?php echo t('Dimensions')?></strong><br/>
		<div>
			<?php echo $product->getProductDimensionLength()?>x<?php echo $product->getProductDimensionWidth()?>x<?php echo $product->getProductDimensionHeight()?> <?php echo $product->getProductDimensionUnits()?>
		</div>
		</div>
	
	<?php  } ?>
	
	<?php  if ($property->handle == 'displayQuantityInStock') { ?>		
		<div>			
		<strong>
		<?php echo t('# In Stock')?>
		</strong><br/>
		<?php echo $product->getProductQuantity()?>
		</div>
	
	<?php  } ?>
	
	<?php  if ($property->type == 'attribute') { 
		$dak = CoreCommerceProductAttributeKey::getByID($property->akID);
		$av = $product->getAttributeValueObject($dak);
		if (is_object($av)) { ?>
		
		<strong><?php echo $dak->getAttributeKeyName()?></strong><br/>
		<?php echo $av->getValue('display')?>
			
	
		<?php  }
		
	} ?>
	
	
	

<?php  } ?>
</div>