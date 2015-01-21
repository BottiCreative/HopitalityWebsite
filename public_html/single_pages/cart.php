<?php  if (isset($error) && $error->has()) {
	$error->output();
} 
else
{
		
	Loader::model('product/model', 'core_commerce');
	Loader::model('cart', 'core_commerce');
	$pkg = Package::getByHandle('core_commerce');
	
	if (!isset($cart)) {
	$cart = CoreCommerceCart::get();
	}

	Loader::library('price', 'core_commerce');
	
	$items = $cart->getProducts(); 	
	
	if(count($items) > 0)
	{
		header('Location: /checkout/billing');	
	}	
			
		
}
?>

<div id="ccm-core-commerce-checkout-cart">

<?php echo Loader::packageElement('cart_item_list', 'core_commerce', array('edit' => true, 'ajax' => false, 'cart'=>$cart))?>

</div>

