<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));  

$c = Page::getCurrentPage();

$uh = Loader::helper('urls', 'core_commerce');


$product = $productArray[0];


?>

<!-- product info -->
		
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
						
<!--<input type="hidden" name="rcID" value="<?php   echo $c->getCollectionID(); ?>" />-->
						<div class="grid-5 columns">
					    <form method="post" id="ccm-core-commerce-add-to-cart-form-<?php   echo $product->getProductID(); ?>" action="<?php   echo $controller->url('/cart', 'update')?>">
					    <p>...or subscribe today</p>
						<p>&pound;10/month</p>
					    <p>&pound;100/year</p>
					    <input type="submit" value="Submit" />
					   <input type="hidden" name="productID" id="productID" value="<?php echo $product->getProductID(); ?>" />
					   </form>
					   
					   <div class="ccm-core-commerce-add-to-cart-product-button-box">
				<?php    if ($product->isProductEnabled()) { ?>
					<span class="ccm-core-commerce-add-to-cart-submit">
						<input type="submit" value="BUY NOW" class="btn ccm-input-submit" />
						
					</span>
					<img src="<?php   echo ASSETS_URL_IMAGES?>/throbber_white_16.gif" width="16" height="16" class="ccm-core-commerce-add-to-cart-loader" />

				<?php    } else { ?>
					<strong><?php   echo t('This product is unavailable.')?></strong>
				<?php    } ?>
			</div>
					   
					   
					</div>
					
					</div>

				</div>
				
				
				
			</div>
			</div>
		
		

</form>
<script type="text/javascript">
	/*$(function() {

	ccm_coreCommerceRegisterAddToCart('ccm-core-commerce-add-to-cart-form-<?php echo $product->getProductID(); ?>', '<?php echo $uh->getToolsURL('cart_dialog')?>');
	
	});*/
	
</script>