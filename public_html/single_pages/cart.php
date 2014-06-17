<?php  if (isset($error) && $error->has()) {
	$error->output();
} 
else
{
	header('Location: /checkout/billing');		
		
}
?>

<div id="ccm-core-commerce-checkout-cart">

<?php echo Loader::packageElement('cart_item_list', 'core_commerce', array('edit' => true, 'ajax' => false, 'cart'=>$cart))?>

</div>

