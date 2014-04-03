<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<form method="post" action="<?php echo $action?>">


<div class="grid-3 columns nopadLeft">

<label for="oEmail"><?php echo t('Email Address')?> <span class="ccm-required">*</span></label><?php echo $form->text('oEmail', $o->getOrderEmail())?>

</div><!--grid-->

<div class="grid-3 columns ">
			<?php 
			$ak = CoreCommerceOrderAttributeKey::getByHandle('billing_first_name');
			echo $form_attribute->display($ak, $ak->isOrderAttributeKeyRequired());
			?>
</div><!--grid-->
<div class="grid-3 columns">
			<?php 
			$ak = CoreCommerceOrderAttributeKey::getByHandle('billing_last_name');
			echo $form_attribute->display($ak, $ak->isOrderAttributeKeyRequired());
			?>
</div>
<div class="grid-3 columns nopadRight">
			<?php 
			$ak = CoreCommerceOrderAttributeKey::getByHandle('billing_phone');
			echo $form_attribute->display($ak, $ak->isOrderAttributeKeyRequired());
			?>

</div>

<div class="grid-12 column nopad">

			<?php 
			$ak = CoreCommerceOrderAttributeKey::getByHandle('billing_address');
			echo $form_attribute->display($ak, $ak->isOrderAttributeKeyRequired());
			?>

</div>

<div class="clearfix"></div>



	<?php 
	$set = AttributeSet::getByHandle('core_commerce_order_billing');
	if (is_object($set)) { 
		$keys = $set->getAttributeKeys();
		foreach($keys as $ak) {
			if (!in_array($ak->getAttributeKeyHandle(), $akHandles)) { ?>	
				<?php echo $form_attribute->display($ak->getAttributeKeyHandle(), $ak->isOrderAttributeKeyRequired())?>
			<?php  }
		}
	} ?>

	<?php  
	$u = new User();
	if($u->isRegistered()) { ?>
	<div class="ccm-core-commerce-profile-address-save">
		<label><?php echo t('Save Info For Future Purchases')?><?php  echo $form->checkbox('save_profile',1)?></label>
	</div>
	<?php  } ?>
	<div class="ccm-core-commerce-cart-buttons">
	<?php echo $this->controller->getCheckoutNextStepButton()?>
	<?php echo $this->controller->getCheckoutPreviousStepButton()?>
	</div>
	<div class="ccm-spacer"></div>
</form>
