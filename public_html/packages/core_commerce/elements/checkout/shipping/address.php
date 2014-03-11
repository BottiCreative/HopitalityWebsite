<form method="post" action="<?php echo $action?>">
	<div>
		<?php echo $form->checkbox('useBillingAddressForShipping', 1, $useBillingAddressForShipping); ?>
		<?php echo $form->label('useBillingAddressForShipping', t('Use Billing Address'))?>
		<?php //=$form->hidden('useBillingAddressAction', $this->url('/checkout/shipping/address', 'update_shipping_to_billing'))?>
	</div>
	<table border="0" cellspacing="0" cellpadding="0" id="ccm-core-commerce-shipping-address-form" <?php  if ($useBillingAddressForShipping) { ?>style="display: none"<?php  } ?>>
	<tr>
		<td>
			<?php  
			$ak = CoreCommerceOrderAttributeKey::getByHandle('shipping_first_name');
			echo $form_attribute->display($ak, $ak->isOrderAttributeKeyRequired()); 
			?>
		</td>
		<td>
			<?php  
			$ak = CoreCommerceOrderAttributeKey::getByHandle('shipping_last_name');
			echo $form_attribute->display($ak, $ak->isOrderAttributeKeyRequired()); 
			?>
		</td>
		<td>
			<?php  
			$ak = CoreCommerceOrderAttributeKey::getByHandle('shipping_phone');
			echo $form_attribute->display($ak, $ak->isOrderAttributeKeyRequired()); 
			?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<?php  
			$ak = CoreCommerceOrderAttributeKey::getByHandle('shipping_address');
			echo $form_attribute->display($ak, $ak->isOrderAttributeKeyRequired()); 
			?>
		</td>
	</tr>
	</table>
	
	<?php 
	$set = AttributeSet::getByHandle('core_commerce_order_shipping');
	if (is_object($set)) { 
		$keys = $set->getAttributeKeys(); ?>
		
		<table border="0" cellspacing="0" cellpadding="0" id="ccm-core-commerce-shipping-address-form">
		<?php 
		foreach($keys as $ak) {
			if (!in_array($ak->getAttributeKeyHandle(), $akHandles)) { ?>
		
				<tr>
					<td><?php echo $form_attribute->display($ak->getAttributeKeyHandle())?></td>
				</tr>
			
			<?php  }
		} ?>
		</table>
		<?php 
	} ?>
	<?php  
	$u = new User();
	if($u->isRegistered()) { ?>
	<div class="ccm-core-commerce-profile-address-save" <?php  if ($useBillingAddressForShipping) { ?>style="display: none"<?php  } ?>>
		<label><?php echo t('Save Info For Future Purchases')?><?php  echo $form->checkbox('save_profile',1)?></label>
	</div>
	<?php  } ?>
	<div class="ccm-core-commerce-cart-buttons">
	<?php echo $this->controller->getCheckoutNextStepButton()?>
	<?php echo $this->controller->getCheckoutPreviousStepButton()?>
	</div>
	<div class="ccm-spacer"></div>
</form>