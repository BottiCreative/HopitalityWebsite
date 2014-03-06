<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php  
if (isset($product) && is_object($product)) { 
   $args = array();
   foreach($this->controller->getSets() as $key => $value) {
      $args[$key] = $value;
   }
   $args['id'] = $b->getBlockID();
   if ($controller->hideSoldOut && $product->isSoldOut()) {
      // show nothing
   } else {
      $args['propertyOrder'] = $controller->propertyOrder;
      Loader::element('product/display_simple', $args);
   }
}