<?php 
$o = CoreCommerceCurrentOrder::get();
$form_attribute->setAttributeObject($o);
?>
<div id="ccm-core-commerce-checkout-cart">
	<?php  Loader::packageElement('cart_item_list', 'core_commerce', array('edit' => false))?>
</div>

<?php  if (isset($error) && $error->has()) {
	$error->output();
} ?>

<div id="ccm-core-commerce-checkout-form-shipping" class="ccm-core-commerce-checkout-form">
	<h1><?php echo t('Shipping Information')?></h1>
	<?php  Loader::packageElement('checkout/shipping/address', 'core_commerce', array('action' => $action, 'o'=>$o,'form'=>$form,'form_attribute'=>$form_attribute, 'akHandles'=>$akHandles,'useBillingAddressForShipping'=>$useBillingAddressForShipping))?>
</div>