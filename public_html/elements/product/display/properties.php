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
				
				//configure the percentage of words to limit here....
				$limitCharsPercentage = 0.05;
				
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
					$limitCharsPercentage = 0.035;
					
				} 
				
				$numbChars =  round(strlen($product->getProductDescription()) * $limitCharsPercentage);
				
				
				$textHelper = new TextHelper();	
				$limitedText = $textHelper->sanitize($product->getProductDescription(),$numbChars,'<p><br>'); //substr($product->getProductDescription(),0,round(strlen($product->getProductDescription() * 0.10)));
				
				echo $limitedText;
			?>	
			<div class="content-membership-overlay-fadeout"></div>
			<div class="content-membership-overlay">
				<div class="content-membership-overlay-ribbon">
					<!--Need to submit the membership here -->
					<div class="row">


					<h3 class="centered">Subscribe to read the rest of this report...</h3>
					
					
					<div class="membersOverlay">
						<div class="grid-7 columns">
					    <div class="TrialRegistration">
					   <h4> Try it free for one week</h4>
						<p>Register to try out HE completely for free for 30 days.</p>
					    
					    <form>
					    <input class="watermark" value="Your Name" placeholder="Your Name" />
					    <input class="watermark" value="Your Email" placeholder="Your Email" />
					    <input class="watermark" value="Password" placeholder="Your Name" />
					    <input type="submit" value="Start Your Free Trial" />
					    
					    </form>
					    </div>
					    
					    </div>
						<div class="grid-5 columns">
					    <p>...or subscribe today</p>
						<p>&pound;10/month</p>
					    <p>&pound;100/year</p>
					    <a href="#" class="membButt4">Subscribe Now</a>
					    
					    </div>
					</div>
					
					</div>

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