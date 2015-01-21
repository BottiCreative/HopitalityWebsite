<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));  

$c = Page::getCurrentPage();

$uh = Loader::helper('urls', 'core_commerce');




?>

<!-- product info -->
		
		<div class="content-membership-overlay-fadeout"></div>
			<div class="content-membership-overlay">
				<div class="content-membership-overlay-ribbon">
					<!--Need to submit the membership here -->
					<div class="row">


					<h3 class="centered">Subscribe to read the rest of this report...</h3>
					
					
					<div class="membersOverlay">
						<div class="grid-12 columns">
					    <div class="TrialRegistration">
					   <h4> Try it free for one month</h4>
						<p>Register to try out HE completely for free for 30 days.</p>
					    
					    
					    <form method="post" name="trialSignup" id="ccm-core-commerce-add-to-cart-form-<?php   echo $freemembershipproduct->getProductID(); ?>" action="<?php   echo $controller->url('/membership/free-trial')?>">
					    <!--<input class="watermark" value="Your Name" name="trialName" type="text" placeholder="Your Name" />
					    <input class="watermark" value="Your Email" type="email" name="trialEmail" placeholder="Your Email" />
					    <input class="watermark" value="Password" type="password"  placeholder="Your Password" />-->
					    <input type="hidden" name="productID" id="productID" value="<?php echo $freemembershipproduct->getProductID(); ?>" />
					    <input class="NonmemberTrailLink" type="submit" value="Start Your Free Trial" class="btn ccm-input-submit" />
					    
					    </form>
					    </div>
					    
					    </div>
						
<!--<input type="hidden" name="rcID" value="<?php   echo $c->getCollectionID(); ?>" />-->
						
                        
                        
                        
                        
                        <div class="grid-12 columns">
					    
					    <?php 
					    //check that the membership product exists
					    if($membershipproduct instanceof CoreCommerceProduct)
						{
						?>	
						
					    <form method="post" name="subscribe" id="ccm-core-commerce-add-to-cart-form-<?php   echo $membershipproduct->getProductID(); ?>" action="<?php   echo $controller->url('/cart', 'update')?>">
					<?php
					    $attribs = $membershipproduct->getProductConfigurableAttributes();
									
			foreach($attribs as $at) { ?>
			<div class="ccm-core-commerce-add-to-cart-product-attributes">
				<div class="ccm-core-commerce-add-to-cart-product-option-attributes-label"><?php   echo $at->render("label")?><?php    if ($at->isProductOptionAttributeKeyRequired()) { ?> <span class="ccm-required">*</span><?php    } ?></div>
				<div class="ccm-core-commerce-add-to-cart-product-option-attributes-value"><?php   echo $at->render('form');?></div>
			</div>
			<?php }  ?>		    
					    <input type="submit" value="Sign Up For <?php echo $membershipproduct->getProductName() ?> Membership" class="btn ccm-input-submit" />
					   <input type="hidden" name="productID" id="productID" value="<?php echo $membershipproduct->getProductID(); ?>" />
					   </form>
				
				<?php } ?>
				
				
				<form method="post" id="ccm-core-commerce-add-to-cart-form-<?php echo $producttobuy->getProductID();?>" action="<?php echo $this->url('/cart', 'update')?>">
<input type="hidden" name="rcID" value="<?php echo $c->getCollectionID()?>" />
	   				
	   				
	   				<input type="hidden" name="productID" id="productID" value="<?php echo $producttobuy->getProductID(); ?>" />
	   				<input type="submit" value="Buy This Product Now" class="btn ccm-input-submit" />
	   				
	   			</form>
				
					   
					   
					</div>
					
					</div>

				</div>
				
				
				
			</div>
			</div>
		
		

</form>
<script type="text/javascript">
	$(function() {

	ccm_coreCommerceRegisterAddToCart('ccm-core-commerce-add-to-cart-form-<?php echo $membershipproduct->getProductID(); ?>', '<?php echo $uh->getToolsURL('cart_dialog')?>');
	
	});
	
</script>