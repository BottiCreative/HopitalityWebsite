<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('product/list', 'core_commerce');
Loader::model('product/model', 'core_commerce');

class ProductListBlockController extends BlockController {

	protected $btTable = 'btProductList';
	protected $btInterfaceWidth = "500";
	protected $btInterfaceHeight = "400";
	protected $pageSize=20;
	public $propertyOrder = array();
		
	public $block_args = array();
	
	public function on_page_view() {
		$this->addHeaderItem(Loader::helper('html')->javascript('jquery.js'));
		$this->addHeaderItem(Loader::helper('html')->css('ccm.core.commerce.cart.css', 'core_commerce'));
		$this->addHeaderItem(Loader::helper('html')->javascript('ccm.core.commerce.cart.js', 'core_commerce'));
		$this->addFooterItem(Loader::helper('html')->javascript('jquery.form.js'));
		$this->addHeaderItem(Loader::helper('html')->javascript('jquery.ui.js'));
		$this->addHeaderItem(Loader::helper('html')->css('jquery.ui.css'));
		$this->loadDisplayProperties('useOverlays');

		if ($this->block_args['useOverlaysL'] || $this->useOverlaysL) {
			$bt = BlockType::getByHandle('product');
			$h = Loader::helper('concrete/urls');
			if (is_object($bt)) {
				$this->set('lightboxURL', $h->getBlockTypeAssetsURL($bt, 'lightbox/'));
				$this->addHeaderItem(Loader::helper('html')->css($h->getBlockTypeAssetsURL($bt, 'lightbox/jquery.lightbox.css')));
				$this->addHeaderItem(Loader::helper('html')->javascript($h->getBlockTypeAssetsURL($bt, 'lightbox/jquery.lightbox.js')));
			}
		}
		if ($this->block_args['useOverlaysC'] || $this->useOverlaysC) {
			$this->addHeaderItem(Loader::helper('html')->javascript('jquery.corner.js', 'core_commerce'));
		}
		
		$pkg = Package::getByHandle('core_commerce');
		if($pkg->config('WISHLISTS_ENABLED')) {
			$this->addHeaderItem(Loader::helper('html')->javascript('ccm.core.commerce.wishlist.js', 'core_commerce'));
			$this->addHeaderItem(Loader::helper('html')->css('ccm.core.commerce.wishlist.css', 'core_commerce'));
		}
		$c = $this->getCollectionObject();
		if($c instanceof Page) {
			$_SESSION['coreCommerceLastProdutPagecID'] = $c->getCollectionID();
		}
	}
		
	/** 
	 * Used for localization. If we want to localize the name/description we have to include this
	 */
	public function getBlockTypeDescription() {
		return t("Displays a list of products");
	}
	
	public function getBlockTypeName() {
		return t("Product List");
	}
	
	public function getJavaScriptStrings() {
		return array();
	}
	
	public function getProductFields() {
		$fields = array();
		$fields['Name'] = t('Name');
		$fields['Description'] = t('Description');
		//$fields['prImageFID'] = t('Thumbnail');
		$fields['Price'] = t('Price');
		$fields['Discount'] = t('Discount');
		$fields['Dimensions'] = t('Dimensions');
		$fields['QuantityInStock'] = t('Quantity in Stock');
		Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
		Loader::model('attribute/categories/core_commerce_product_option', 'core_commerce');
		//$searchFieldAttributes = CoreCommerceProductAttributeKey::getSearchableList();
		$searchFieldAttributes = CoreCommerceProductAttributeKey::getList();
		foreach($searchFieldAttributes as $ak) {
			$fields[$ak->getAttributeKeyID()] = $ak->getAttributeKeyName();
		}
		return $fields;
	}
	
	public function getProductsSortableFields() {
		$fields = array();
		$fields['prName'] = t('Name');
		//$fields['prDescription'] = t('Description');
		//$fields['prImageFID'] = t('Thumbnail');
		$fields['prCurrentPrice'] = t('Current Price');
		$fields['prDateAdded'] = t('Date Added');
		$fields['prspDisplayOrder'] = t('Set Order');
		$fields['cDisplayOrder'] = t('Sitemap Order');
		Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
		$searchFieldAttributes = CoreCommerceProductAttributeKey::getList();
		foreach($searchFieldAttributes as $ak) {
			$type = $ak->getAttributeKeyType()->getAttributeTypeHandle();
			if (!in_array($type,array("image"))) {
				$fields[ 'ak_' . $ak->getAttributeKeyHandle()] = $ak->getAttributeKeyName();
			}
		}
		return $fields;	
	}
	
	public function edit() {
		$this->loadPropertyDisplayOrder();
		if ($this->block_args['primaryImage'] == '') {
			$this->block_args['primaryImage'] = 'prThumbnailImage';
		}
		if ($this->block_args['primaryHoverImage'] == '' && $this->block_args['displayHoverImage']) { // legacy support
			$this->block_args['primaryHoverImage'] = 'prAltThumbnailImage';
		}
		// legacy support
		$this->loadDisplayProperties('useOverlays');
		if ($this->useOverlaysC) {
			$this->block_args['useOverlaysC'] = 'C';
			if ($this->block_args['overlayCalloutImage'] == '') {
				$this->block_args['overlayCalloutImage'] = 'prFullImage';
			}
		}
		if ($this->useOverlaysL) {
			$this->block_args['useOverlaysL'] = 'L';
		}
		
	}
	
	public function add() {
		$this->block_args['primaryImage'] = 'prThumbnailImage';
		$this->block_args['primaryHoverImage'] = 'prAltThumbnailImage';
	}
	
	public function getProductFieldsInOrder() {
		$attrColsArray = $this->block_args['show_columns'];
		
		if( !is_array($attrColsArray) ) $attrColsArray=array(); 
		$cleanCols = array();
		
		$allFields = $this->getProductFields();
		//this code will make sure the columns mathc the order specified by the user
		foreach ($attrColsArray as $field => $values) {
			if (isset($allFields[$field])) {
				$cleanCols[$field] = $allFields[$field];
			}
		}
		foreach ($allFields as $field=>$val) {
			if (!isset($cleanCols[$field])) $cleanCols[$field] = $allFields[$field];
		}
	
		return $cleanCols;
	}
	
	function shouldDisplay($field,$type) {
		if (is_array($this->block_args['displayField']) && is_array($this->block_args['displayField'][$field])) {
			return in_array($type,$this->block_args['displayField'][$field]);
		}
		else return false;
	}
	
	public function __construct($obj = null) {		
		parent::__construct($obj);
		//Loader::model('contact_directory_contact','contact_directory');
		//$this->baseobj = new ContactDirectoryContact();
		$html = Loader::helper('html');
		$form = Loader::helper('form');
		$uh = Loader::helper('concrete/urls');
		$this->set('form', $form);
		if (isset($this->block_args) && !is_array($this->block_args)) {
			$args = @unserialize($this->block_args);		
			if (!is_array($args)) $args = array();
			$this->block_args = $args;
			$this->set('block_args',$this->block_args);
		}
		if ($this->bID==0) {
			$this->setDefaults();
		}
	}
	


	
	public static $fontFamilies = array( 
		'inherit'=>'inherit', 
		'Arial'=>"Arial, Helvetica, sans-serif",
		'Times New Roman'=>"'Times New Roman', Times, serif",
		'Courier'=>"'Courier New', Courier, monospace",
		'Georgia'=>"Georgia, 'Times New Roman', Times, serif",
		'Verdana'=>"Verdana, Arial, Helvetica, sans-serif"		
	);
	
	public function save($args) { 
		$db = Loader::db();
		//$args['displayPropertyOrder'] = serialize($args['displayPropertyOrder']);

		//this is a hacky way of saving the block, but search criteria can be really anything, so the variable names are unpredictable
		unset($args["blockToolsDir"]);
		unset($args["currentCID"]);
		unset($args["_add"]);
		unset($args["submit"]);
		unset($args["processBlock"]);
		unset($args["uID"]);
		unset($args["update"]);
		unset($args["task"]);
		if (!is_array($args['selectedSearchField'])) $args['selectedSearchField'] = array();
		if (is_array($args['akID'])) {
			foreach ($args['akID'] as $key => $vals) {
				if (!in_array($key,$args['selectedSearchField'])) unset($args['akID'][$key]);
			}
		}
		$settings = array();
		$settings['block_args'] = serialize($args);
		parent::save($settings);		
	} 	
			
	public function view() {
		$this->loadPropertyDisplayOrder();

		// legacy image support
		if ($this->block_args['primaryHoverImage'] == '' && $this->block_args['displayHoverImage']) { // legacy support
			$this->block_args['primaryHoverImage'] = 'prAltThumbnailImage';
		}
		
		foreach ($this->block_args as $arg => $val) {
			$this->set($arg,$val);
		}
		if (!is_array($this->block_args['displayField'])) $this->block_args['displayField']['prName'] = 'P';
		$show_columns = array();
		$sort_columns = array();
		$valid_fields = $this->getProductFields();
		/*
		foreach ($this->block_args['showColumns'] as $col => $val) {
			if ($val>0) {
				$show_columns[] = $col;
			}
			if ($val>1) {
				$sort_columns[$col] = $valid_fields[$col];
			}
		}
		*/
		
		$this->loadDisplayProperties('displayField', 'displayName');
		$this->loadDisplayProperties('displayField', 'displayDescription');
		$this->loadDisplayProperties('displayField', 'displayDiscount');
		$this->loadDisplayProperties('displayField', 'displayDimensions');
		$this->loadDisplayProperties('displayField', 'displayPrice');
		$this->loadDisplayProperties('displayField', 'displayQuantityInStock');
		$this->loadDisplayProperties('useOverlays');

		$valid_sort_fields = $this->getProductsSortableFields();
		if (!is_array($this->block_args['paging']['sort_by'])) $this->block_args['paging']['sort_by'] = array();
		foreach ($this->block_args['paging']['sort_by'] as $col) {
			$sort_columns[$col] = $valid_sort_fields[$col];
		}
		$this->set('attributesP', $this->getAttributes('P'));
		$this->set('attributesC', $this->getAttributes('C'));
		$this->set('attributesL', $this->getAttributes('L'));
		$this->setDisplayFieldsForTemplate();
		$this->set('sort_columns',$sort_columns);
	}
	
	
	private function setDefaults() {
		$defaults = array();
		$defaults['displayAddToCart'] = 1;
		$defaults['displayQuantity'] = 0;
		$defaults['displayLinkToFullPage'] = 1;
		$defaults['displayImage'] = 1;
		$defaults['imageMaxWidth'] = 200;
		$defaults['imageMaxHeight'] = 200;
		$defaults['imagePosition'] = "T";
		$defaults['paging']['show_top'] = 1;
		$defaults['displayField']['Name'] = array('P');
		$defaults['displayField']['Price'] = array('P');
		$defaults['displayField']['Discount'] = array('P');
		$defaults['options']['show_products'] = 1;
		
		
		$defaults['overlayCalloutImageMaxHeight'] 	= 200;
		$defaults['overlayCalloutImageMaxWidth'] 	= 200;
		$defaults['overlayLightboxImageMaxHeight'] 	= 600;
		$defaults['overlayLightboxImageMaxWidth'] 	= 600;
		
		foreach ($defaults as $default=>$val) {
			$this->block_args[$default] = $val;
		}
	}
	
	private function setDisplayFieldsForTemplate() {
		$vars = array();
		if (is_array($this->block_args['displayField'])) {
			foreach ($this->block_args['displayField'] as $field => $val) {
				if (!is_numeric($field) && is_array($val)) {
					foreach ($val as $v) {
						$varname = 'display'.$field.strtoupper($v);
						$this->set($varname,true);
					}
				}
			}
		}
	}
	
	public function getAttributes($mode, $fullKeys = true) {
		$attribs = array();
		Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
		if (is_array($this->block_args['displayField'])) {
			foreach($this->block_args['displayField'] as $key => $val) {
				if (is_int($key) && $key > 0) {
					if (is_array($val) && in_array($mode, $val)) {
						if ($fullKeys) {
							$ak = CoreCommerceProductAttributeKey::getByID($key);
							if (is_object($ak)) {
								$attribs[] = $ak;
							}
						} else {
							$attribs[] = $key;
						}
					}
				}
			}
		}
		
		return $attribs;
	}

	protected function loadDisplayProperties($field, $subfield = false) {
		if ($subfield && is_array($this->block_args[$field][$subfield])) {
			$f = $this->block_args[$field][$subfield];
			foreach($f as $i) {
				$this->set($subfield . $i, true);
				$var = $subfield . $i;
				$this->$var = true;
			}
		} else if (is_array($this->block_args[$field])) {
			$f = $this->block_args[$field];
			foreach($f as $i) {
				$this->set($field . $i, true);
				$var = $field . $i;
				$this->$var = true;
			}
		}
	}

	/*
		$data_sources['directly_under_this_page'] = t('Directly under this page');
		$data_sources['anywhere_under_this_page'] = t('Anywhere under this page');
		$data_sources['stored_search_query'] = t('A stored search query');
		$data_sources['top_purchased_products'] = t('Top purchased products');
		$data_sources['top_visited_products'] = t('Top visited products');
		$data_sources['user_visited_products'] = t('Breadcrum of products seen');
	*/
	public function getRequestedSearchResults() {
		$productList = new CoreCommerceProductList();
		$productList->setNameSpace('b' . $this->getBlockObject()->getBlockID());
		$productList->sortBy('prDateAdded', 'desc');
		
		//show only active products
		$productList->filter('pr.prStatus', 1);
		
		//apply built in filter
		$block_args = $this->block_args;
		
		if ($block_args['numResults']) {
			$productList->setItemsPerPage($block_args['numResults']);
		}
		
		if(Loader::helper('multilingual','core_commerce')->isEnabled()) {
			
			$language = $block_args['language'];
			if(!strlen($language)) {
				Loader::model('section',Loader::helper('multilingual','core_commerce')->getHandle());
				$se = MultilingualSection::getCurrentSection();
				if(is_object($se)) {
					$language = $se->getLanguage();
				}
				
			}
			
			if(strlen($language)) {
				$productList->filterByLanguage($language);
			}
		}
		switch ($block_args['data_source']) {
			case 'under_parent_page':
			case 'directly_under_this_page':
				/*
					ok, we'll do a small trick here...
					We don't want to recreate all the page list variables and at the same time we want our list to return products
					so we'll do 2 queries. One to get the pages and one to get the products
				*/
				
				/* page list approach
				Loader::model('page_list');
				$pl = new PageList();
				$pl->filterByParentID($this->getCollectionObject()->getCollectionID());
				$pages = $pl->get();
				$page_list = array();
				foreach ($pages as $p) {
					$page_list[] = $p->getCollectionId();
				}
				*/
				// direct query
				$db = Loader::db();
            $c = Page::getCurrentPage();
            if ($block_args['data_source'] == 'directly_under_this_page') {
	            $cID = $c->getCollectionID();
	        } else {
            	$cID = $c->getCollectionParentID();
	        }
				$query = "SELECT cID FROM Pages WHERE cParentID = ?";
				$page_list = $db->getCol($query, array($cID));
            $i = 0;
            foreach($page_list as $cID) {
               $page = Page::getByID($cID);
               $pp = new Permissions($page);
               if(!($pp->canRead())){
                  unset($page_list[$i]);
               }
               $i++;
            }
            $page_list = array_values($page_list);
				
				if (count($page_list)==0) {
					//don't show anything
					$productList->filter('','0');
				} else {
					$productList->filter('pr.cID',$page_list);
				}
			break;
			case 'all_products':
			break;
			case 'stored_search_query':
				if ($block_args['keywords']) {
					$productList->filterByKeywords($block_args['keywords']);
				}
				$priceFrom = $block_args['price_from'];
				$priceTo = $block_args['price_to'];
				if ($priceFrom != '') {
					$productList->filterByCurrentPrice($priceFrom, '>=');
				}
				if ($priceTo != '') {
					$productList->filterByCurrentPrice($priceTo, '<=');
				}
				if (is_array($block_args['prsID'])) {
					Loader::model('product/set', 'core_commerce');
					foreach($block_args['prsID'] as $prsID) {
						$prs = CoreCommerceProductSet::getByID($prsID);
						$productList->filterBySet($prs);
					}
				}
				//Note, attributes expect everything to be in the request, so we'll trick this part
				$tmp_req = $_REQUEST;
				$_REQUEST = $block_args;
				if (is_array($_REQUEST['selectedSearchField'])) {
					foreach($_REQUEST['selectedSearchField'] as $i => $item) { // due to the way the form is setup, index will always be one more than the arrays
						if ($item != '') {
							switch($item) {
								case "date_added":
									$dateFrom = $_REQUEST['date_from'];
									$dateTo = $_REQUEST['date_to'];
									if ($dateFrom != '') {
										$dateFrom = date('Y-m-d', strtotime($dateFrom));
										$productList->filterByDateAdded($dateFrom, '>=');
										$dateFrom .= ' 00:00:00';
									}
									if ($dateTo != '') {
										$dateTo = date('Y-m-d', strtotime($dateTo));
										$dateTo .= ' 23:59:59';
										
										$productList->filterByDateAdded($dateTo, '<=');
									}
									break;
		
								default:
									$akID = $item;
									$fak = CoreCommerceProductAttributeKey::getByID($akID);
									if ($fak instanceof CoreCommerceProductAttributeKey && $fak->getAttributeKeyID() > 0) {
										$type = $fak->getAttributeType();
										$cnt = $type->getController();
										$cnt->setAttributeKey($fak);
										$cnt->searchForm($productList);
									}
									break;
							}
						}
					}
				}
				$_REQUEST = $tmp_req;
			break;
			case 'top_purchased_products':
				$productList->addToQuery("left join CoreCommerceProductStats ps on pr.productID = ps.productID");
				$productList->sortBy("ps.totalPurchases", "desc");
				$sorted= true;
			break;
			case 'products_on_sale':
				$productList->filter(false, '(prSpecialPrice <> prPrice and prSpecialPrice > 0)');
				break;
			case 'top_visited_products':
				$productList->addToQuery("left join CoreCommerceProductStats ps on pr.productID = ps.productID");
				$productList->sortBy("ps.totalViews", "desc");
				$sorted= true;
			break;
			case 'user_visited_products':
				$visited = CoreCommerceProduct::getUserViewedProducts();
				if (count($visited)>0) {
					$productList->filter('pr.ProductID',$visited);
				}
				else {
					//don't show anything
					$productList->filter('','0');
				}
			break;
		}
		//$productList->debug(true);
		
		
		if (is_array($this->block_args['options'])
	 //this change was made so that a "destination" list block can not have a search options field if desired. Maybe this isn't desired.
			&& ($this->block_args['options']['show_search_form'] || $this->block_args['options']['show_products'])
		) {

	   if (strlen(trim($_GET['keywords']))){
			$productList->filterByKeywords($_GET['keywords']);
		}	

		$priceFrom = $_GET['price_from'];
		$priceTo = $_GET['price_to'];
		if ($priceFrom != '') {
			$productList->filterByCurrentPrice($priceFrom, '>=');
		}
		if ($priceTo != '') {
			$productList->filterByCurrentPrice($priceTo, '<=');
		}
	
		
		if ($_REQUEST['numResults']) {
			$productList->setItemsPerPage($_REQUEST['numResults']);
		}
		
		if (is_array($_REQUEST['selectedSearchField'])) {
			foreach($_REQUEST['selectedSearchField'] as $i => $item) {
				// due to the way the form is setup, index will always be one more than the arrays
				if ($item != '') {
					switch($item) {
						case "date_added":
							$dateFrom = $_REQUEST['date_from'];
							$dateTo = $_REQUEST['date_to'];
							if ($dateFrom != '') {
								$dateFrom = date('Y-m-d', strtotime($dateFrom));
								$productList->filterByDateAdded($dateFrom, '>=');
								$dateFrom .= ' 00:00:00';
							}
							if ($dateTo != '') {
								$dateTo = date('Y-m-d', strtotime($dateTo));
								$dateTo .= ' 23:59:59';
								
								$productList->filterByDateAdded($dateTo, '<=');
							}
							break;

						default:
							$akID = $item;
							$fak = CoreCommerceProductAttributeKey::getByID($akID);
							if ($fak instanceof CoreCommerceProductAttributeKey && $fak->getAttributeKeyID() > 0) {
								$type = $fak->getAttributeType();
								$cnt = $type->getController();
								$cnt->setAttributeKey($fak);
								$cnt->searchForm($productList);
							}
							break;
					}
				}
			}
		}
		
		}
		
		if (!$sorted && !isset($_REQUEST['ccm_order_by']) && !empty($block_args['default_order_by'])) {
			if (substr($block_args['default_order_by'], 0, 3) == 'ak_') {
				$sortKey = CoreCommerceProductAttributeKey::getByHandle(substr($block_args['default_order_by'], 3));
				if ($sortKey instanceof CoreCommerceProductAttributeKey) {
					$productList->sortBy($block_args['default_order_by'], $block_args['default_sort_order']);
				}
			} else {
				$productList->sortBy($block_args['default_order_by'], $block_args['default_sort_order']);
			}
		}
		
		return $productList;
	}

	protected function loadPropertyDisplayOrder() {
		//if ($this->block_args['displayPropertyOrder'] != '') {
			//$propertyOrder = @unserialize($this->block_args['displayPropertyOrder']);
			//if (is_array($propertyOrder)) {
				//$this->propertyOrder = $propertyOrder;
            //var_dump($propertyOrder);
				//$this->set('propertyOrder', $propertyOrder);
			//}
		//}					
      ///this appears to have been over-serializing the property order array or something
      //taking all the serialization crap out has fixed it.
      //it was writing the serialization string recursively or something for each property.
      //Not totally sure what was going on
      $propertyOrder = $this->block_args['displayPropertyOrder'];
      //var_dump($propertyOrder);
      $this->propertyOrder = $propertyOrder;
      $this->set('propertyOrder', $propertyOrder);
	}

	/* returns the available imaages for the different image display options */
	public function getAvailableImageOptions() {
		
		$values = array( 
			'prFullImage' => t('Full Image'),
			'prThumbnailImage' => t('Thumbnail Image'),
			'prAltThumbnailImage' => t('Alternate Thumbnail')
		);
		
		// add additional product images if available
		/*
		if(is_object($this->product)) {
			$images = $this->product->getAdditionalProductImages();
			if(is_array($images) && count($images)) {
				foreach($images as $fi) {
					$values['fID_'.$fi->getFileID()] = $fi->getFileName();					
				}
			}
		}
		*/
		Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
		$attributes = CoreCommerceProductAttributeKey::getList();
		
		foreach($attributes as $ak) {			
			if($ak->getAttributeKeyType()->getAttributeTypeHandle() == 'image_file') {
				$values['akID_'.$ak->getAttributeKeyID()] = $ak->getAttributeKeyName();
			}
		}
		return $values;
	}
	
	
	
}

?>
