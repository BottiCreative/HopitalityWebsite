<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<div class="ccm-core-commerce-product-property-list">

<?php  
$tmp = array();
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
		if ($linkToProductPage) {
			$linksTo = Page::getByID($product->getProductCollectionID());
			$link_before = '<a href="' . Loader::helper('navigation')->getLinkToCollection($linksTo) . '">';
			$link_after = '</a>';
		}		
	?>		
	
		<h2><?php echo $link_before.$product->getProductName().$link_after?></h2>
	
	<?php  } ?>
	
	<?php  if ($property->handle == 'displayPrice' && (!$hasBothPrices)) { ?>		
		<div><?php echo Loader::packageElement('product/price', 'core_commerce', array('product' => $product, 'displayDiscount' => false, 'userHasAccess' => $userHasAccess)); ?></div>
	
	<?php  } ?>
	
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
				
				$textHelper = new TextHelper();
				
				//ok, limit the text to 25% of the whole article.
				$limitedText = $textHelper->sanitize($product->getProductDescription(),round(strlen($product->getProductDescription()) * 0.25),'<p><br>'); //substr($product->getProductDescription(),0,round(strlen($product->getProductDescription() * 0.10)));
				
				echo $limitedText;
			?>	
			<div class="content-membership-overlay">
				<div class="content-membership-overlay-ribbon">
					<!--Need to submit the membership here -->
					<h2>INSERT MEMBERSHIP DETAIL HERE - WE'LL MAKE THIS RETURN THE MEMBERSHIP PRODUCT BLOCK</h2>
				</div>
				
				
				
			</div>
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
	
	<div class="ccm-spacer">&nbsp;</div>

<?php  } ?>
</div>