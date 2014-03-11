<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

class CoreCommercePackage extends Package {

	protected $pkgHandle = 'core_commerce';
	protected $appVersionRequired = '5.6';
	protected $pkgVersion = '2.8.10';
	
	/**
	 * @var array all of the single pages that need to exist for ecom
	 */
	protected $singlePages = array(
		'/cart',
		'/checkout',
		'/checkout/discount',
		'/checkout/billing',
		'/checkout/shipping',
		'/checkout/shipping/address',
		'/checkout/shipping/method',
		'/checkout/payment',
		'/checkout/payment/method',
		'/checkout/payment/form',
		'/checkout/finish',
		'/checkout/finish_error',
		'/checkout/complete_order',
		'profile/order_history',
		'/dashboard/core_commerce',
		'/dashboard/core_commerce/products',
		'/dashboard/core_commerce/products/add',
		'/dashboard/core_commerce/products/search',
		'/dashboard/core_commerce/products/sets',
		'/dashboard/core_commerce/products/attributes',
		'/dashboard/core_commerce/products/options',
		'/dashboard/core_commerce/products/images',
		'/dashboard/core_commerce/orders',
		'/dashboard/core_commerce/orders/search',
		'/dashboard/core_commerce/orders/attributes',
		'/dashboard/core_commerce/discounts',
		'/dashboard/core_commerce/shipping',
		'/dashboard/core_commerce/payment',
		'/dashboard/core_commerce/payment/methods',
		'/dashboard/core_commerce/payment/tax',
		'/dashboard/core_commerce/settings',
		'/dashboard/core_commerce/settings/inventory',
		'/dashboard/core_commerce/settings/store_home',
		'/dashboard/core_commerce/settings/currency',
		'/dashboard/core_commerce/settings/email',
		'/dashboard/core_commerce/settings/order',
		'/dashboard/core_commerce/settings/user'
	);
	
	
	
	public function getPackageDescription() {
		return t('Sell products through your website.');
	}
	
	public function getPackageName(){
		return t('eCommerce');
	}
	
	
	/**
	 * verifies or adds all of the single pages in the $this->singlePages array 
	 * @return void
	 */
	public function checkCreatePages() {
		Loader::model('single_page');
		$pkg = Package::getByHandle($this->pkgHandle);
		foreach($this->singlePages as $path) {
			if(Page::getByPath($path)->getCollectionID() <= 0) {
				$page = SinglePage::add($path, $pkg);
            if ($path == '/checkout' || $path == '/cart') {
               $page->setAttribute('exclude_nav', 1);
            }
			}
		}

		$c1 = Page::getByPath('/dashboard/core_commerce');
		$c1->update(array('cName'=>t('eCommerce'), 'cDescription'=>$this->getPackageDescription()));

		$c1 = Page::getByPath('/dashboard/core_commerce/payment');
		$c1->update(array('cName'=>t('Payment & Sales Tax')));

 	}
	
	
	public function on_start() {
		Config::getOrDefine('ECOMMERCE_PRODUCT_THUMBNAIL_WIDTH', 120);
		Config::getOrDefine('ECOMMERCE_PRODUCT_THUMBNAIL_HEIGHT', 90);
		Config::getOrDefine('ECOMMERCE_PRODUCT_MID_WIDTH', 250);
		Config::getOrDefine('ECOMMERCE_PRODUCT_MID_HEIGHT', 250);
		Config::getOrDefine('ECOMMERCE_PRODUCT_FULL_WIDTH', 800);
		Config::getOrDefine('ECOMMERCE_PRODUCT_FULL_HEIGHT', 800);
				
		define('DIRNAME_ECOMMERCE_LOCAL', 'core_commerce');

		define('DIRNAME_ECOMMERCE_SHIPPING', 'shipping');
		define('DIRNAME_ECOMMERCE_SHIPPING_TYPES', 'types');
		define('FILENAME_ECOMMERCE_SHIPPING_DB', 'db.xml');
		define('FILENAME_ECOMMERCE_SHIPPING_CONTROLLER', 'controller.php');

		define('DIRNAME_ECOMMERCE_DISCOUNT', 'discount');
		define('DIRNAME_ECOMMERCE_DISCOUNT_TYPES', 'types');
		define('FILENAME_ECOMMERCE_DISCOUNT_DB', 'db.xml');
		define('FILENAME_ECOMMERCE_DISCOUNT_CONTROLLER', 'controller.php');

		define('DIRNAME_ECOMMERCE_PAYMENT', 'payment');
		define('DIRNAME_ECOMMERCE_PAYMENT_METHODS', 'methods');
		define('FILENAME_ECOMMERCE_PAYMENT_DB', 'db.xml');
		define('FILENAME_ECOMMERCE_PAYMENT_CONTROLLER', 'controller.php');
      Events::extend('core_commerce_change_order_status', 'ChangeOrderStatus', 'onChange', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/models/events/change_order_status.php');
      //Events::extend('core_commerce_add_to_cart', 'AddToCart', 'updateCart', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/models/events/add_to_cart.php');
      Events::extend('on_group_delete', 'ProductEvents', 'userGroupDeleted', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/models/events/product.php');
	}
	
	public function uninstall() {
		parent::uninstall();
		$db = Loader::db();
		$db->Execute('truncate table CoreCommerceShippingTypes');
		$db->Execute('truncate table CoreCommercePaymentMethods');
		$db->Execute('truncate table CoreCommerceDiscountTypes');
		$db->Execute('drop table if exists CoreCommerceOrderSearchIndexAttributes');
		$db->Execute('drop table if exists CoreCommerceProductSearchIndexAttributes');
		
		if (isset($_POST['coreCommerceUninstallContent']) && $_POST['coreCommerceUninstallContent'] == 1) {
			$p1 = Page::getByPath('/love-of-duck');
			if (is_object($p1) && (!$p1->isError())) {
				$p1->delete();
			}
			$p2 = Page::getByPath('/catalog');
			if (is_object($p2) && (!$p2->isError())) {
				$p2->delete();
			}
		}		
	}
	
	public function upgrade() {
		// 1.1
		parent::upgrade();
		Loader::model('single_page');
		Loader::model('attribute/categories/core_commerce_order', 'core_commerce');
		$db = Loader::db();
		
		
		$this->checkCreatePages();
		
		
		$adjustt = AttributeType::getByHandle('order_adjustment');
		
		$salesTaxAttribute = CoreCommerceOrderAttributeKey::getByHandle('sales_tax');
		if (!$salesTaxAttribute) {
			Loader::model('attribute/set');
			$osubset = AttributeSet::getByHandle('subtotal');
			CoreCommerceOrderAttributeKey::add($adjustt, array('akHandle' => 'sales_tax', 'akName' => t('Sales Tax'), 'akIsEditable' => false, 'akIsSearchable' => true))->setAttributeSet($osubset);		
		}
		
		// 1.6.1
		// this should only run for those where prPricePaid is null
		$r = $db->Execute('select orderProductID, CoreCommerceProducts.productID, CoreCommerceProducts.prPrice from CoreCommerceOrderProducts left join CoreCommerceProducts on CoreCommerceOrderProducts.productID = CoreCommerceProducts.productID where CoreCommerceOrderProducts.prPricePaid is null');
		while ($row = $r->fetchRow()) {
			$db->Execute('update CoreCommerceOrderProducts set prPricePaid = ? where orderProductID = ?', array($row['prPrice'], $row['orderProductID']));
		}
		
		// 1.6.4
		$akCategoryIDUser = $db->GetOne('select akCategoryID from AttributeKeyCategories where akCategoryHandle = \'user\'');
		$akCategoryIDOrder = $db->GetOne('select akCategoryID from AttributeKeyCategories where akCategoryHandle = \'core_commerce_order\'');
		if ($akCategoryIDOrder > 0) {
			// we check to see if there is a "billing" and "shipping" set for this. If so we need to update it to have the right handle
			$db->Execute('update AttributeSets set asHandle = \'core_commerce_order_billing\' where asHandle = \'billing\' and akCategoryID = ?', array($akCategoryIDOrder));
			$db->Execute('update AttributeSets set asHandle = \'core_commerce_order_shipping\' where asHandle = \'shipping\' and akCategoryID = ?', array($akCategoryIDOrder));
		}
		if ($akCategoryIDUser > 0) {
			// we check to see if there is a "billing" and "shipping" set for this. If so we need to update it to have the right handle
			$db->Execute('update AttributeSets set asHandle = \'user_billing\' where asHandle = \'billing\' and akCategoryID = ?', array($akCategoryIDUser));
			$db->Execute('update AttributeSets set asHandle = \'user_shipping\' where asHandle = \'shipping\' and akCategoryID = ?', array($akCategoryIDUser));
		}
		
		// 1.6.5
		// this should only run for those where CCPO.prName is null
		$r = $db->Execute('select orderProductID, CoreCommerceProducts.productID, CoreCommerceProducts.prName as ccpName from CoreCommerceOrderProducts left join CoreCommerceProducts on CoreCommerceOrderProducts.productID = CoreCommerceProducts.productID where CoreCommerceOrderProducts.prName is null');
		while ($row = $r->fetchRow()) {
			$db->Execute('update CoreCommerceOrderProducts set prName = ? where orderProductID = ?', array($row['ccpName'], $row['orderProductID']));
		}
		
		// 1.6.6
		// Set the required values on the shipping/billing attribute categories
		$attr = array('billing_first_name', 'billing_last_name', 'billing_address', 'billing_phone', 'shipping_first_name', 'shipping_last_name', 'shipping_address', 'shipping_phone');
		foreach($attr as $at_handle) {
			$ak = CoreCommerceOrderAttributeKey::getByHandle($at_handle);
			if(is_object($ak)) {
				$v = array($ak->getAttributeKeyID(), 1);
				$db->Execute('REPLACE INTO CoreCommerceOrderAttributeKeys (akID, orakIsRequired) VALUES (?, ?)', $v);
			}
		}
		
		// 1.7
		$eakp = AttributeKeyCategory::getByHandle('core_commerce_product_option');
		$pkg = Package::getByHandle('core_commerce');
		$atPpAdjustB = AttributeType::getByHandle('product_price_adjustment_boolean');
		if(!is_object($atPpAdjustB) || $atPpAdjustB->getAttributeTypeID() < 1) {
			$atPpAdjustB = AttributeType::add('product_price_adjustment_boolean', t('Checkbox - Product Price'), $pkg);
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('product_price_adjustment_boolean'));
		}
		$atPpAdjustT = AttributeType::getByHandle('product_price_adjustment_text');
		if(!is_object($atPpAdjustT) || $atPpAdjustT->getAttributeTypeID() < 1) {
			$atPpAdjustT = AttributeType::add('product_price_adjustment_text', t('Text - Product Price'), $pkg);
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('product_price_adjustment_text'));
		}
		$atPpAdjustS = AttributeType::getByHandle('product_price_adjustment_select');
		if(!is_object($atPpAdjustS) || $atPpAdjustS->getAttributeTypeID() < 1) {
			$atPpAdjustS = AttributeType::add('product_price_adjustment_select', t('Select - Product Price'), $pkg);
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('product_price_adjustment_select'));	
		}
		
		// 1.8.4
		if(!strlen($pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_PASS_ADDRESS'))) {
			$pkg->saveConfig('PAYMENT_METHOD_PAYPAL_STANDARD_PASS_ADDRESS','shipping'); // keep default behavior
		}
	
		// 2.0 changes
		// set order numbers to match old order IDs
		$res = $db->getOne("SELECT COUNT(orderID) as rowCount FROM CoreCommerceOrderInvoiceNumbers");
		if($res == 0) {
			$db->query("REPLACE INTO CoreCommerceOrderInvoiceNumbers (orderID, orderInvoiceNumber) SELECT orderID, orderID FROM CoreCommerceOrders ORDER BY orderID ASC");
		}
	
		if(!$pkg->config('PROFILE_MY_ORDERS_ENABLED')) {
			$pkg->saveConfig('PROFILE_MY_ORDERS_ENABLED',0);
		}
	
		if(!$pkg->config('STORE_ROOT')) {
			$pkg->saveConfig('STORE_ROOT',1);
		}
	
		if(!$pkg->config('ONE_PAGE_CHECKOUT')) {
			$pkg->saveConfig('ONE_PAGE_CHECKOUT',0);
		}

		Loader::model('discount/type', 'core_commerce');
		$cdt = CoreCommerceDiscountType::getByHandle('product');
		if (!is_object($cdt) || (!$cdt->getDiscountTypeID())) {
			CoreCommerceDiscountType::add('product', t('Product-Specific Discount'));
		}
		
		$coak = CoreCommerceOrderAttributeKey::getByHandle('discount_product_adjustment');

		$osubset = AttributeSet::getByHandle('subtotal');
		if (!is_object($coak)) {
			CoreCommerceOrderAttributeKey::add($adjustt, array('akHandle' => 'discount_product_adjustment', 'akName' => t('Product Discount'), 'akIsEditable' => false, 'akIsSearchable' => true))->setAttributeSet($osubset);
		}
		
		// 2.8 - allow negative inventory
		$db->Execute("ALTER TABLE `CoreCommerceProducts` CHANGE `prQuantity` `prQuantity` INT(10)  NOT NULL  DEFAULT '0'");


      //2.8.4  - Unsearch the adjustment stuff.  Just breaks to search in orders.  What are you going to look up anyhow.
		$attribute = CoreCommerceOrderAttributeKey::getByHandle('discount_basic_adjustment');
      if (is_object($attribute)) {
         $attribute->update(array('akHandle' => 'discount_basic_adjustment', 'akName' => t('Basic Discount'), 'akIsEditable' => false, 'akIsSearchable' => false));
         $attribute->setAttributeSet($osubset);		
      }
		$attribute = CoreCommerceOrderAttributeKey::getByHandle('discount_product_adjustment');
      if (is_object($attribute)) {
         $attribute->update(array('akHandle' => 'discount_product_adjustment', 'akName' => t('Product Discount'), 'akIsEditable' => false, 'akIsSearchable' => false));
         $attribute->setAttributeSet($osubset);		
      }
		$attribute = CoreCommerceOrderAttributeKey::getByHandle('total_shipping');		
      if (is_object($attribute)) {
         $attribute->update(array('akHandle' => 'total_shipping', 'akName' => t('Shipping & Handling'), 'akIsEditable' => false, 'akIsSearchable' => false));
         $attribute->setAttributeSet($osubset);		
      }
		$attribute = CoreCommerceOrderAttributeKey::getByHandle('sales_tax');		
      if (is_object($attribute)) {
         $attribute->update(array('akHandle' => 'sales_tax', 'akName' => t('Sales Tax'), 'akIsEditable' => false, 'akIsSearchable' => false));
         $attribute->setAttributeSet($osubset);		
      }
	//2.8.4  
	  // update existing incomplete orders with new incomplete code (9000)
      $db->Execute("UPDATE `CoreCommerceOrders` SET `oStatus` = 9000 WHERE `oStatus` = -5");
      //add new page attribute for searchability
      Loader::model('attribute/categories/collection');
      $attribute = CollectionAttributeKey::getByHandle('product_description_auto');
      if (!is_object($attribute)) {
         $texta = AttributeType::getByHandle('textarea');
         CollectionAttributeKey::add($texta, array('akHandle' => 'product_description_auto', 'akName' => t('Product Search Data'), 'akIsSearchableIndexed'=>true, 'akIsSearchable' => true), $pkg);
      }
		
	}
	
	public function install($options = 'yes') {
        Loader::model('collection_types');
		$full = CollectionType::getByHandle('full');	
		if (!is_array($options) || $options['coreCommerceInstallContent'] == 'yes') { 
			if (!is_object($full)) {
				throw new Exception(t('Installing the eCommerce sample content requires a "Full" page type. Please create a page type with the handle "full" in order to proceed.'));
			}
		}
		
		$pkg = parent::install();

		Loader::model('single_page');

		// install block		
		BlockType::installBlockTypeFromPackage('cart_links', $pkg);	
		BlockType::installBlockTypeFromPackage('product', $pkg);	
		BlockType::installBlockTypeFromPackage('product_list', $pkg);	
		
		$this->on_start();
		
        // install page types
        $pdt = CollectionType::getByHandle('product_detail');
        if( !$pdt || !intval($pdt->getCollectionTypeID()) ){
            $data['ctHandle'] = 'product_detail';
            $data['ctName'] = t('Product Detail');
            $pdt = CollectionType::add($data, $pkg);
        }

        // install pages
        $this->checkCreatePages();

		// exclude cart and checkout from nav
		Page::getByPath('/checkout')->setAttribute('exclude_nav', 1);
		Page::getByPath('/cart')->setAttribute('exclude_nav', 1);
		
		
		// install attribute categories
		$adjustt = AttributeType::add('order_adjustment', t('Order Adjustment'), $pkg);
		
		$atPpAdjustB = AttributeType::add('product_price_adjustment_boolean', t('Checkbox - Product Price'), $pkg);
		$atPpAdjustT = AttributeType::add('product_price_adjustment_text', t('Text - Product Price'), $pkg);
		$atPpAdjustS = AttributeType::add('product_price_adjustment_select', t('Select - Product Price'), $pkg);
		
		Loader::model('attribute/categories/core_commerce_order', 'core_commerce');
		Loader::model('attribute/categories/core_commerce_product_option', 'core_commerce');

		$eakc = AttributeKeyCategory::getByHandle('core_commerce_product');
		$eakp = AttributeKeyCategory::getByHandle('core_commerce_product_option');
		$eako = AttributeKeyCategory::getByHandle('core_commerce_order');
		$eaku = AttributeKeyCategory::getByHandle('user');
		$eaku->setAllowAttributeSets(AttributeKeyCategory::ASET_ALLOW_SINGLE);
		
		if (!is_object($eakc)) {
			$eakc = AttributeKeyCategory::add('core_commerce_product', 0, $pkg);
			$eakc->associateAttributeKeyType(AttributeType::getByHandle('text'));
			$eakc->associateAttributeKeyType(AttributeType::getByHandle('textarea'));
			$eakc->associateAttributeKeyType(AttributeType::getByHandle('number'));
			$eakc->associateAttributeKeyType(AttributeType::getByHandle('boolean'));
			$eakc->associateAttributeKeyType(AttributeType::getByHandle('rating'));
			$eakc->associateAttributeKeyType(AttributeType::getByHandle('select'));
			$eakc->associateAttributeKeyType(AttributeType::getByHandle('image_file'));
			$eakc->associateAttributeKeyType(AttributeType::getByHandle('date_time'));
		}
		if (!is_object($eako)) {
			$eako = AttributeKeyCategory::add('core_commerce_order', AttributeKeyCategory::ASET_ALLOW_SINGLE, $pkg);
			$eako->associateAttributeKeyType(AttributeType::getByHandle('text'));
			$eako->associateAttributeKeyType(AttributeType::getByHandle('textarea'));
			$eako->associateAttributeKeyType(AttributeType::getByHandle('number'));
			$eako->associateAttributeKeyType(AttributeType::getByHandle('address'));
			$eako->associateAttributeKeyType(AttributeType::getByHandle('boolean'));
			$eako->associateAttributeKeyType(AttributeType::getByHandle('date_time'));
			$eako->associateAttributeKeyType($adjustt);

			$obset = $eako->addSet('core_commerce_order_billing', t('Billing'), $pkg);
			$osset = $eako->addSet('core_commerce_order_shipping', t('Shipping'), $pkg);			
			$osubset = $eako->addSet('subtotal', t('Subtotal Modifiers'), $pkg);			
		}
		
		$ubset = $eaku->addSet('user_billing', t('Billing'), $pkg);
		$usset = $eaku->addSet('user_shipping', t('Shipping'), $pkg);
		
		if (!is_object($eakp)) {
			$eakp = AttributeKeyCategory::add('core_commerce_product_option', 0, $pkg);
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('text'));
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('textarea'));
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('select'));
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('boolean'));
			
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('product_price_adjustment_boolean'));
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('product_price_adjustment_text'));
			$eakp->associateAttributeKeyType(AttributeType::getByHandle('product_price_adjustment_select'));	
		}
		
		$addresst = AttributeType::getByHandle('address');
		$textt = AttributeType::getByHandle('text');
      $texta = AttributeType::getByHandle('textarea');
		$numt = AttributeType::getByHandle('number');
		
		Loader::model('attribute/categories/user');
      Loader::model('attribute/categories/collection');
		Loader::model('shipping/type', 'core_commerce');
		Loader::model('payment/method', 'core_commerce');
		Loader::model('discount/type', 'core_commerce');

		
		CoreCommerceShippingType::add('flat', t('Flat Shipping'), 1);
		CoreCommerceDiscountType::add('free_shipping', t('Free Shipping'));
		CoreCommerceDiscountType::add('basic', t('Basic Discount'));
		CoreCommerceDiscountType::add('product', t('Product-Specific Discount'));
		CoreCommercePaymentMethod::add('default', t('Default Gateway'), 1, NULL, $pkg);
		CoreCommercePaymentMethod::add('paypal_website_payments_standard', t('Paypal Website Payments Standard'), 0, NULL, $pkg);
		CoreCommercePaymentMethod::add('authorize_net_sim', t('Authorize.Net - Server Integration Method'), 0, NULL, $pkg);
		CoreCommercePaymentMethod::add('authorize_net_aim', t('Authorize.Net - Advanced Integration Method'), 0, NULL, $pkg);
		
      CollectionAttributeKey::add($texta, array('akHandle' => 'product_description_auto', 'akName' => t('Product Search Data'), 'akIsSearchableIndexed'=>true,'akIsSearchable' => true), $pkg);

		UserAttributeKey::add($textt, array('akHandle' => 'billing_first_name', 'akName' => t('First Name'), 'akIsSearchable' => true), $pkg)->setAttributeSet($ubset);
		UserAttributeKey::add($textt, array('akHandle' => 'billing_last_name', 'akName' => t('Last Name'), 'akIsSearchable' => true), $pkg)->setAttributeSet($ubset);
		UserAttributeKey::add($addresst, array('akHandle' => 'billing_address', 'akName' => t('Address'), 'akIsSearchable' => true), $pkg)->setAttributeSet($ubset);
		UserAttributeKey::add($textt, array('akHandle' => 'billing_phone', 'akName' => t('Phone'), 'akIsSearchable' => true), $pkg)->setAttributeSet($ubset);

		UserAttributeKey::add($textt, array('akHandle' => 'shipping_first_name', 'akName' => t('First Name'), 'akIsSearchable' => true), $pkg)->setAttributeSet($usset);
		UserAttributeKey::add($textt, array('akHandle' => 'shipping_last_name', 'akName' => t('Last Name'), 'akIsSearchable' => true), $pkg)->setAttributeSet($usset);
		UserAttributeKey::add($addresst, array('akHandle' => 'shipping_address', 'akName' => t('Address'), 'akIsSearchable' => true), $pkg)->setAttributeSet($usset);
		UserAttributeKey::add($textt, array('akHandle' => 'shipping_phone', 'akName' => t('Phone'), 'akIsSearchable' => true), $pkg)->setAttributeSet($usset);
		
		CoreCommerceOrderAttributeKey::add($adjustt, array('akHandle' => 'discount_basic_adjustment', 'akName' => t('Basic Discount'), 'akIsEditable' => false, 'akIsSearchable' => false))->setAttributeSet($osubset);
		CoreCommerceOrderAttributeKey::add($adjustt, array('akHandle' => 'discount_product_adjustment', 'akName' => t('Product Discount'), 'akIsEditable' => false, 'akIsSearchable' => false))->setAttributeSet($osubset);
		CoreCommerceOrderAttributeKey::add($adjustt, array('akHandle' => 'total_shipping', 'akName' => t('Shipping & Handling'), 'akIsEditable' => false, 'akIsSearchable' => false))->setAttributeSet($osubset);		
		CoreCommerceOrderAttributeKey::add($adjustt, array('akHandle' => 'sales_tax', 'akName' => t('Sales Tax'), 'akIsEditable' => false, 'akIsSearchable' => false))->setAttributeSet($osubset);		
		CoreCommerceOrderAttributeKey::add($textt, array('akHandle' => 'discount_code', 'akName' => t('Discount Code'), 'akIsSearchable' => true));		
	
		CoreCommerceOrderAttributeKey::add($textt, array('akHandle' => 'billing_first_name', 'akName' => t('First Name'), 'akIsSearchable' => true, 'orakIsRequired'=>true))->setAttributeSet($obset);
		CoreCommerceOrderAttributeKey::add($textt, array('akHandle' => 'billing_last_name', 'akName' => t('Last Name'), 'akIsSearchable' => true, 'orakIsRequired'=>true))->setAttributeSet($obset);
		CoreCommerceOrderAttributeKey::add($addresst, array('akHandle' => 'billing_address', 'akName' => t('Address'), 'akIsSearchable' => true, 'orakIsRequired'=>true))->setAttributeSet($obset);
		CoreCommerceOrderAttributeKey::add($textt, array('akHandle' => 'billing_phone', 'akName' => t('Phone'), 'akIsSearchable' => true, 'orakIsRequired'=>false))->setAttributeSet($obset);

		CoreCommerceOrderAttributeKey::add($textt, array('akHandle' => 'shipping_first_name', 'akName' => t('First Name'), 'akIsSearchable' => true, 'orakIsRequired'=>true))->setAttributeSet($osset);
		CoreCommerceOrderAttributeKey::add($textt, array('akHandle' => 'shipping_last_name', 'akName' => t('Last Name'), 'akIsSearchable' => true, 'orakIsRequired'=>true))->setAttributeSet($osset);
		CoreCommerceOrderAttributeKey::add($addresst, array('akHandle' => 'shipping_address', 'akName' => t('Address'), 'akIsSearchable' => true, 'orakIsRequired'=>true))->setAttributeSet($osset);
		CoreCommerceOrderAttributeKey::add($textt, array('akHandle' => 'shipping_phone', 'akName' => t('Phone'), 'akIsSearchable' => true, 'orakIsRequired'=>false))->setAttributeSet($osset);	

		$pdt = CollectionType::getByHandle('product_detail');
		$productDetailTemplate = $pdt->getMasterTemplate();
		$productBlockBT = BlockType::getByHandle('product');
		$pdata['inheritProductIDFromCurrentPage'] = 1;
		$pdata['displayQuantity'] = 1;
		$pdata['displayAddToCart'] = 1;
		$pdata['displayName'] = array('P');
		$pdata['displayDescription'] = array('P');
		$pdata['displayPrice'] = array('P');
		$pdata['displayDiscount'] = array('P');
		$pdata['displayDimensions'] = array('P');
		$pdata['displayImage'] = 1;
		$pdata['imagePosition'] = 'L';
		$pdata['useOverlays'] = array('L');
		
		$productDetailTemplate->addBlock($productBlockBT, "Product", $pdata);

		
		// config values
		$pkg->saveConfig('PROFILE_MY_ORDERS_ENABLED',1);  // enable order profiles
		$pkg->saveConfig('STORE_ROOT',1);                 // Set store root to root page.
		$pkg->saveConfig('ONE_PAGE_CHECKOUT',0);          // one page checkout
		
		// wishilists & gift registries disabled by default
		$pkg->saveConfig('WISHLISTS_ENABLED',0);
		$pkg->saveConfig('GIFT_REGISTRIES_ENABLED',0);

		$pkg->saveConfig('USE_ZEND_CURRENCY',1);

		if (!is_array($options) || $options['coreCommerceInstallContent'] == 'yes') { 
			$pkg->installSampleData();
		}	
	}

	private function installSampleData() {
		Loader::model('collection_types');
		Loader::model('product/model', 'core_commerce');
		Loader::model("attribute/categories/core_commerce_product", 'core_commerce');
		Loader::model('attribute/categories/core_commerce_product_option', 'core_commerce');
		
		$pr_is_duck = CoreCommerceProductAttributeKey::add('BOOLEAN', array('akHandle' => 'is_duck', 'akName' => t('This is a Duck'), 'akIsSearchable' => true,'akIsSearchableIndexed'=>true,'akCheckedByDefault'=>1));
		$pr_gender = CoreCommerceProductAttributeKey::add('SELECT', array('akHandle' => 'gender', 'akName' => t('Gender'), 'akIsSearchable' => true,'akIsSearchableIndexed'=>true,'akSelectAllowMultipleValues'=>true));
		$opt = new SelectAttributeTypeOption(0, 'Male', 1);
		$opt = $opt->saveOrCreate($pr_gender);
		$opt = new SelectAttributeTypeOption(0, 'Female', 2);
		$opt = $opt->saveOrCreate($pr_gender);
		$pr_cuteness = CoreCommerceProductAttributeKey::add('RATING', array('akHandle' => 'cute', 'akName' => t('How Cute?'), 'akIsSearchable' => true,'akIsSearchableIndexed'=>true));
		
		$pr_is_duck = CoreCommerceProductAttributeKey::getByHandle('is_duck');
		$pr_gender = CoreCommerceProductAttributeKey::getByHandle('gender');
		$pr_cuteness = CoreCommerceProductAttributeKey::getByHandle('cute');
		
		$home = Page::getByID(1, "RECENT");
		$full = CollectionType::getByHandle('full');	
		
		
		$data = array();
		$data['name'] = t('Catalog');
		$catalog = $home->add($full, $data);
		
		//add products
		$data = array(
			'prName' => 'Marvin Mandarin',
			'prDescription' => "<p>He's every bit as nice as his friend Martin, but he's just not quite as good.</p>
			<p>I wouldn't lie to ya. He's not.</p>
			<p>He won't bite. Just...</p>",
			'prRequiresShipping' => 1,
			'prRequiresTax' => 1,
			'prPhysicalGood' => 1,
			'prQuantity' => 500,
			'prQuantityUnlimited' => 0,
			'prStatus' => 1,
			'prPrice' => 25,
			'prSpecialPrice' => 13,
			'prWeight' => 1,
			'prWeightUnits' => 'lb',
			'prDimL' => 6,
			'prDimW' => 4,
			'prDimH' => 3,
			'prDimUnits' => "in",
			'parentCID' => $catalog->getCollectionID()
		);
		$product = CoreCommerceProduct::add($data);
		$pr_is_duck->setAttribute($product,1);
		$pr_gender->setAttribute($product,array('Male'));
		$pr_cuteness->setAttribute($product,60);
		$prods[] = $product;
		
		$data = array(
			'prName' => 'Ruddy Duck',
			'prDescription' => '<p>Such a <em><span style="text-decoration: underline;">cute</span></em> little guy.</p>',
			'prRequiresShipping' => 1,
			'prRequiresTax' => 1,
			'prPhysicalGood' => 1,
			'prQuantity' => 500,
			'prQuantityUnlimited' => 0,
			'prStatus' => 1,
			'prPrice' => 25,
			'prSpecialPrice' => 23.95,
			'prWeight' => 1,
			'prWeightUnits' => 'lb',
			'prDimL' => 12,
			'prDimW' => 8,
			'prDimH' => 4,
			'prDimUnits' => "in",
			'parentCID' => $catalog->getCollectionID()
		);
		$this->saveConfig('STORE_ROOT',$catalog->getCollectionID());
		$product = CoreCommerceProduct::add($data);
		$productRuddyDuck = $product;
		$pr_is_duck->setAttribute($product,1);
		$pr_gender->setAttribute($product,array('Male'));
		$pr_cuteness->setAttribute($product,100);
		
		$args = array('akHandle' => $product->getProductID() . '_include_hat', 'akName' => t('Ducky Hat?'), 'akIsSearchable' => false,'akIsSearchableIndexed'=>false,'poakIsRequired'=>true);
		$ak = CoreCommerceProductOptionAttributeKey::add('SELECT', $product, $args);
		$opt = new SelectAttributeTypeOption(0, 'Yes', 1);
		$opt = $opt->saveOrCreate($ak);
		$opt = new SelectAttributeTypeOption(0, 'No', 2);
		$opt = $opt->saveOrCreate($ak);
		
		$prods[] = $product;
		
		$data = array(
			'prName' => 'Molly Mallard',
			'prDescription' => '<p>She\'s a Mallard. Give her a break. She likes cornmeal as much as <em>any</em> other duck. Give Molly a chance.</p>
			<p>Seriously, we have like hundreds of these guys. We call them all Molly.</p>',
			'prRequiresShipping' => 1,
			'prRequiresTax' => 1,
			'prPhysicalGood' => 1,
			'prQuantity' => 255,
			'prQuantityUnlimited' => 0,
			'prStatus' => 1,
			'prPrice' => 5,
			'prSpecialPrice' => 2.95,
			'prWeight' => 1,
			'prWeightUnits' => 'lb',
			'prDimL' => 10,
			'prDimW' => 5,
			'prDimH' => 5,
			'prDimUnits' => "in",
			'parentCID' => $catalog->getCollectionID()
		);
		$product = CoreCommerceProduct::add($data);
		$productMollyMallard = $product;
		$pr_is_duck->setAttribute($product,1);
		$pr_gender->setAttribute($product,array('Male','Female'));
		$pr_cuteness->setAttribute($product,10);
		
		$args = array('akHandle' => $product->getProductID() . '_gender', 'akName' => t('Gender'), 'akIsSearchable' => false,'akIsSearchableIndexed'=>false,'poakIsRequired'=>true);
		$ak = CoreCommerceProductOptionAttributeKey::add('SELECT', $product, $args);
		$opt = new SelectAttributeTypeOption(0, 'All Female', 1);
		$opt = $opt->saveOrCreate($ak);
		$opt = new SelectAttributeTypeOption(0, 'A Mix...', 2);
		$opt = $opt->saveOrCreate($ak);
		$opt = new SelectAttributeTypeOption(0, 'All Male', 3);
		$opt = $opt->saveOrCreate($ak);
		
		$prods[] = $product;
		
		$data = array(
			'prName' => 'Martin Mandarin',
			'prDescription' => '<p>Just awesome - you\'ll be "stuck at the pond" all afternoon when this guy is flapping around.</p>',
			'prRequiresShipping' => 1,
			'prRequiresTax' => 1,
			'prPhysicalGood' => 1,
			'prQuantity' => 500,
			'prQuantityUnlimited' => 0,
			'prStatus' => 1,
			'prPrice' => 25,
			'prSpecialPrice' => 13,
			'prWeight' => 1,
			'prWeightUnits' => 'lb',
			'prDimL' => 8,
			'prDimW' => 4,
			'prDimH' => 6,
			'prDimUnits' => "in",
			'parentCID' => $catalog->getCollectionID()
		);
		$product = CoreCommerceProduct::add($data);
		$pr_is_duck->setAttribute($product,1);
		$pr_gender->setAttribute($product,array('Male'));
		$pr_cuteness->setAttribute($product,80);
		$prods[] = $product;
		
		$data = array(
			'prName' => 'Rick Ruddy',
			'prDescription' => "<p>Quite the looker - this guy is gonna impress the neighbors.</p>",
			'prRequiresShipping' => 1,
			'prRequiresTax' => 1,
			'prPhysicalGood' => 1,
			'prQuantity' => 500,
			'prQuantityUnlimited' => 0,
			'prStatus' => 1,
			'prPrice' => 18,
			'prSpecialPrice' => 0,
			'prWeight' => 1,
			'prWeightUnits' => 'lb',
			'prDimL' => 11,
			'prDimW' => 4,
			'prDimH' => 7,
			'prDimUnits' => "in",
			'parentCID' => $catalog->getCollectionID()
		);
		$product = CoreCommerceProduct::add($data);
		$productRickRuddy = $product;
		$pr_is_duck->setAttribute($product,1);
		$pr_gender->setAttribute($product,array());
		$pr_cuteness->setAttribute($product,100);
		$prods[] = $product;
		
		$data = array(
			'prName' => 'His & Hers Mandarins',
			'prDescription' => "<p>Start your own family of Ducks.</p>
			<p>You can get started with this young couple. They're feeling randy and they're gonna be shipped in a box together to YOUR DOOR!</p>
			<p>&nbsp;</p>
		",
			'prRequiresShipping' => 1,
			'prRequiresTax' => 1,
			'prPhysicalGood' => 1,
			'prQuantity' => 500,
			'prQuantityUnlimited' => 0,
			'prStatus' => 1,
			'prPrice' => 155,
			'prSpecialPrice' => 13,
			'prWeight' => 3,
			'prWeightUnits' => 'lb',
			'prDimL' => 8,
			'prDimW' => 4,
			'prDimH' => 6,
			'prDimUnits' => "in",
			'parentCID' => $catalog->getCollectionID()
		);
		$product = CoreCommerceProduct::add($data);
		$pr_is_duck->setAttribute($product,1);
		$pr_gender->setAttribute($product,array('Male','Female'));
		$pr_cuteness->setAttribute($product,100);
		$prods[] = $product;
		
		$data = array(
			'prName' => 'Duck of the Month Club',
			'prDescription' => "<p>We'll send you a new duck every month for FIFTY FIVE YEARS!</p>
			<p>Can you handle it?</p>",
			'prRequiresShipping' => 1,
			'prRequiresTax' => 1,
			'prPhysicalGood' => 0,
			'prQuantity' => 0,
			'prQuantityUnlimited' => 1,
			'prStatus' => 1,
			'prPrice' => 15000,
			'prWeight' => 3,
			'prWeightUnits' => 'lb',
			'prDimL' => 8,
			'prDimW' => 4,
			'prDimH' => 6,
			'prDimUnits' => "in",
			'parentCID' => $catalog->getCollectionID()
		);
		$product = CoreCommerceProduct::add($data);
		$dotmc = $product;
		$prods[] = $product;
		
		
		//add images
		$images_folder = dirname(__FILE__)."/images/ducks";
		
		$images = array();
		$images[] = array('mandarin-tb.jpg','','mandarin5.jpg');
		$images[] = array('ruddy02-mid.jpg','ruddy02-zoom.jpg','ruddy02-big.jpg','mandarin1.jpg');
		$images[] = array('mallard-tb1.jpg','mallard-tb2.jpg','mallard1.jpg','mallard1.jpg','mallard2.jpg','mallard6.jpg','mallard5.jpg','mallard3.jpg','mallard4.jpg');
		$images[] = array('mandarin-tb2.jpg','','mandarin2.jpg','mandarin3.jpg','mandarin-tb2.jpg');
		$images[] = array('ruddy01-mid.jpg','ruddy01-zoom.jpg','ruddy01-big.jpg',);
		$images[] = array('mandarin1.jpg','','');
		$images[] = array('','','','');
		
		Loader::library("file/importer");
		$fi = new FileImporter();
		
		for ($i=0;$i<count($prods);$i++) {
			if (is_array($images[$i])) {
				$j=0;
				$primages = array();
				foreach ($images[$i] as $image) {			
					if ($image != "") {
						$im = $fi->import($images_folder."/".$image);
						$primages[] = $im->getFileID();
					}
					else {
						$primages[] = 0;
					}
					$j++;			
				}
				$prods[$i]->updateCoreProductImages(array(
					'prThumbnailImageFID'=>$primages[0],
					'prAltThumbnailImageFID'=>$primages[1],
					'prFullImageFID'=>$primages[2]));
				$more_images = array();
				for ($k=3;$k<count($primages);$k++) {
					$more_images[] = $primages[$k];
				}
				$prods[$i]->setAdditionalProductImages($more_images);
			}
		}
		
		// add products to catalog
		$blocks = $catalog->getBlocks("Header");
		if (is_object($blocks[0])) {
			$blocks[0]->deleteBlock();
		}
		
		$btCartLinks = BlockType::getByHandle('cart_links');
		$data = array();
		$data['showCartLink'] = 1;
		$data['showItemQuantity'] = 1;
		$data['showCheckoutLink'] = 1;
		$data['cartLinkText'] = t('View Cart');
		$data['checkoutLinkText'] = t('Checkout');
		$catalog->addBlock($btCartLinks, 'Header', $data);
		
		$btProductList = BlockType::getByHandle('product_list');
		$data = array();
		$data['data_source'] = 'directly_under_this_page';
		$data['baseSearchPath'] = 'THIS';
		$data['displayField']['Name'][] = 'P';
		$data['displayField']['Name'][] = 'C';
		$data['displayField']['Name'][] = 'L';
		$data['displayField']['Description'][] = 'C';
		$data['displayField']['Price'][] = 'P';
		$data['displayField']['Price'][] = 'C';
		$data['displayField']['Discount'][] = 'P';
		$data['displayField']['Discount'][] = 'C';
		$data['displayField']['Dimensions'][] = 'C';
		
		if (is_object($pr_gender)) {
			$data['displayField'][$pr_gender->getAttributeKeyID()][] = 'C';
		}
		if (is_object($pr_cuteness)) {
			$data['displayField'][$pr_cuteness->getAttributeKeyID()][] = 'C';
		}
		
		$data['displayLinkToFullPage'] = 1;
		$data['displayAddToCart'] = 1;
		$data['addToCartText'] = t('Buy!');
		$data['displayImage'] = 1;
		$data['imageMaxWidth'] = 264;
		$data['imageMaxHeight'] = 264;
		$data['imagePosition'] = 'T';
		$data['displayHoverImage'] = 1;
		$data['useOverlays'][] = "C";
		$data['useOverlays'][] = "L";
		
		$data['options']['show_products'] = 1;
		$data['default_order_by'] = 'prPrice';
		$data['default_sort_by'] = 'asc';
		
		$data['layout']['records_per_row'] = 3;
		$data['layout']['table_border_width'] = 0;
		$data['layout']['table_border_style'] = 'solid';
		$data['layout']['cell_vertical_align'] = 'top';
		$data['layout']['cell_horizontal_align'] = 'center';
		$data['layout']['padding'] = '1';
		$data['layout']['spacing'] = '0';
		
		$data['numResults'] = '6';
		
		$data['paging']['show_bottom'] = '1';
		
		// @TODO Change options for new product list options
		$catalog->addBlock($btProductList, 'Main', $data);

		$home = Page::getByID(1);
		$data = array();
		$data['uID'] = USER_SUPER_ID;
		$data['name'] = t('Love of Duck');
		$rst = CollectionType::getByHandle('right_sidebar');
		if (is_object($rst)) {
			$loveOfDuckPage = $home->add($rst, $data);
			if (is_object($loveOfDuckPage) && (!$loveOfDuckPage->isError())) {
				$blocks = $loveOfDuckPage->getBlocks("Header");
				if (is_object($blocks[0])) {
					$blocks[0]->deleteBlock();
				}
				$data = array();
				$data['showCartLink'] = 1;
				$data['showItemQuantity'] = 1;
				$data['showCheckoutLink'] = 1;
				$data['cartLinkText'] = t('View Cart');
				$data['checkoutLinkText'] = t('Checkout');
				$loveOfDuckPage->addBlock($btCartLinks, 'Header', $data);
				
				$data = array();
				$data['content'] = t('<h1>Ducks?</h1><h2><em>Yes!</em></h2><p><strong>Why?</strong><br />I just like \'em. Ya\' know what, maybe I love \'em. I\'ve never looked at a duck and thought "<strong>jerk.</strong>" Ducks are cool and I\'ve always had a good time with them. I remember Ducky from Pretty in Pink fondly, same for Daffy Duck and his ducky dame Daisy. Ducks just always rubbed me the right way, so when it came time to sell a pretend something - Ducks it was.*<span style="font-size: x-small;"><br />*Monkeys did place a very close second. </span></p><p>Now I have ducks up the wazzoooo! Mallards are a dime a dozen around here. Actually, not quite that cheap - check them out. Don\'t forget to click the image to see more pics from around the pond!</p>');
				$btContent = BlockType::getByHandle('content');
				$loveOfDuckPage->addBlock($btContent, 'Main', $data);
		
				$data = array();
				$data['productID'] = $productMollyMallard->getProductID();
				$data['inheritProductIDFromCurrentPage'] = 0;
				$data['displayName'] = array('C', 'L');
				$data['displayDescription'] = array('C');
				$data['displayPrice'] = array('P', 'L');
				$data['displayDiscount'] = array('P');
				$data['displayDimensions'] = array('C');
				$data['displayAddToCart'] = 1;
				$data['displayQuantity'] = 1;
				$data['addToCartText'] = t('Catch em!');
				$data['displayImage'] = 1;
				$data['imageMaxWidth'] = 530;
				$data['imageMaxHeight'] = 530;
				$data['imagePosition'] = 'B';
				$data['displayHoverImage'] = 1;
				$data['useOverlays'] = array('C', 'L');
				
				$btProduct = BlockType::getByHandle('product');
				$loveOfDuckPage->addBlock($btProduct, 'Main', $data);
		
				
				// search page
				$fw = CollectionType::getByHandle('full');
				if (is_object($fw)) {
					$data = array();
					$data['uID'] = USER_SUPER_ID;
					$data['name'] = t('Search Products');
					$searchPage = $loveOfDuckPage->add($fw, $data);
					if (is_object($searchPage) && (!$searchPage->isError())) {
						
						$blocks = $loveOfDuckPage->getBlocks("Sidebar");
						if (is_object($blocks[0])) {
							$blocks[0]->deleteBlock();
						}
						
						// search block
						$data = array();
						$data['data_source'] = 'directly_under_this_page';
						$data['options']['show_search_form'] = 1;
						$data['options']['search_mode'] = 'simple';
						$data['baseSearchPath'] = 'OTHER';
						$data['searchUnderCID'] = $searchPage->getCollectionID();
						$data['displayField']['Name'][] = 'P';
						$data['displayField']['Price'][] = 'P';
						$data['displayField']['Discount'][] = 'P';
						
						$data['displayLinkToFullPage'] = 1;				
						$loveOfDuckPage->addBlock($btProductList, 'Sidebar', $data);
		
						$data = array();
						$data['content'] = t('<h2>More Hot Ducks!</h2>');
						$loveOfDuckPage->addBlock($btContent, 'Sidebar', $data);
					
						// rick ruddy
						$data = array();
						$data['productID'] = $productRickRuddy->getProductID();
						$data['inheritProductIDFromCurrentPage'] = 0;
						$data['displayName'] = array('P');
						$data['displayDescription'] = array('C');
						$data['displayPrice'] = array('C');
						$data['displayDiscount'] = array('C');
						$data['displayDimensions'] = array('C');
						$data['displayAKID'][$pr_cuteness->getAttributeKeyID()] = array('P', 'C');
						$data['displayAKID'][$pr_is_duck->getAttributeKeyID()] = array('C');
						$data['displayLinkToFullPage'] = 1;
						$data['displayImage'] = 1;
						$data['imageMaxWidth'] = 180;
						$data['imageMaxHeight'] = 180;
						$data['imagePosition'] = 'B';
						$data['displayHoverImage'] = 1;
						$data['useOverlays'] = array('C', 'L');
						
						$loveOfDuckPage->addBlock($btProduct, 'Sidebar', $data);				
						
						// html
						$btHTML = BlockType::getByHandle("html");
						if (is_object($btHTML)) {
							$data = array();
							$data['content'] = t('<br/>');
							$loveOfDuckPage->addBlock($btHTML, 'Sidebar', $data);
						}					
						
						// ruddy duck
						$data = array();
						$data['productID'] = $productRuddyDuck->getProductID();
						$data['inheritProductIDFromCurrentPage'] = 0;
						$data['displayName'] = array('P');
						$data['displayDescription'] = array('C');
						$data['displayPrice'] = array('C');
						$data['displayDiscount'] = array('C');
						$data['displayDimensions'] = array('C');
						$data['displayAKID'][$pr_cuteness->getAttributeKeyID()] = array('P', 'C');
						$data['displayAKID'][$pr_is_duck->getAttributeKeyID()] = array('C');
						$data['displayLinkToFullPage'] = 1;
						$data['displayImage'] = 1;
						$data['imageMaxWidth'] = 180;
						$data['imageMaxHeight'] = 180;
						$data['imagePosition'] = 'B';
						$data['displayHoverImage'] = 1;
						$data['useOverlays'] = array('C', 'L');
						
						$loveOfDuckPage->addBlock($btProduct, 'Sidebar', $data);				
						
						// html
						if (is_object($btHTML)) {
							$data = array();
							$data['content'] = t('<br/>');
							$loveOfDuckPage->addBlock($btHTML, 'Sidebar', $data);
						}
						
						// duck of the month club
						$data = array();
						$data['productID'] = $dotmc->getProductID();
						$data['inheritProductIDFromCurrentPage'] = 0;
						$data['displayName'] = array('P');
						$data['displayDescription'] = array('P');
						$data['displayPrice'] = array('P');
						$data['displayAddToCart'] = 1;
						$data['addToCartText'] = t('Signup!');
						
						$loveOfDuckPage->addBlock($btProduct, 'Sidebar', $data);				
						
						// search page
						$data = array();
						$data['data_source'] = 'stored_search_query';
						$data['options']['show_search_form'] = 1;
						$data['options']['search_mode'] = 'advanced';
						$data['baseSearchPath'] = 'THIS';
						$data['displayField']['Name'][] = 'P';
						$data['displayField']['Name'][] = 'C';
						$data['displayField']['Description'][] = 'C';
						$data['displayField']['Price'][] = 'P';
						$data['displayField']['Price'][] = 'C';
						$data['displayField']['Discount'][] = 'P';
						$data['displayField']['Discount'][] = 'C';
						$data['displayField']['Dimensions'][] = 'C';
						
						if (is_object($pr_gender)) {
							$data['displayField'][$pr_gender->getAttributeKeyID()][] = 'C';
						}
						if (is_object($pr_cuteness)) {
							$data['displayField'][$pr_cuteness->getAttributeKeyID()][] = 'C';
						}
						
						$data['displayLinkToFullPage'] = 1;
						$data['displayAddToCart'] = 1;
						$data['addToCartText'] = t('Buy');
						$data['displayQuantity'] = 1;
						$data['displayImage'] = 1;
						$data['imageMaxWidth'] = 200;
						$data['imageMaxHeight'] = 200;
						$data['imagePosition'] = 'L';
						$data['displayHoverImage'] = 1;
						$data['useOverlays'][] = "C";
						$data['useOverlays'][] = "L";
						
						$data['options']['show_products'] = 1;
						$data['default_order_by'] = 'prName';
						$data['default_sort_by'] = 'asc';
						
						$data['layout']['records_per_row'] = 1;
						$data['layout']['table_border_width'] = 0;
						$data['layout']['table_border_style'] = 'solid';
						$data['layout']['cell_vertical_align'] = 'top';
						$data['layout']['cell_horizontal_align'] = 'left';
						$data['layout']['padding'] = '0';
						$data['layout']['spacing'] = '10';
						
						$data['numResults'] = '10';
						
						$data['paging']['show_top'] = '1';
						$data['paging']['sort_by'] = array('prName', 'prPrice');
						$searchPage->addBlock($btProductList, 'Main', $data);
						
						
					}
				}
			}	
		}
	}
}
