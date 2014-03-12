<?php defined('C5_EXECUTE') or die('Access Denied');

class MooMusicAreaSearchBlockController extends BlockController {
	
	protected $btTable = 'btMooMusicAreaSearch';
	protected $packageName = 'moo_music';
	
	public function on_page_view()
	{
		if($this->displayType == DisplayType::map || $this->displayType == DisplayType::mapForm)
		{
			
			//add the maps js to activate google maps.
			$html = Loader::helper('html');
			//$this->addHeaderItem('<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true&key=AIzaSyDw7irck_KNNx1gYHriiKD6PITWpTnZdp0"></script>');
			$base_url = BASE_URL;
			$this->addHeaderItem($html->javascript("{$base_url}/packages/{$this->packageName}/js/map.js"));
			//$this->addHeaderItem($html->javascript("{$base_url}/packages/core_commerce/js/ccm.core.commerce.cart.js"));
			
		}
		if($this->displayTypeID == DisplayType::form)
		{
			$html = Loader::helper('html');
			
			//add required js for adding products to shopping cart.
			$this->addHeaderItem(Loader::helper('html')->css('ccm.core.commerce.cart.css', 'core_commerce'));
			$this->addHeaderItem(Loader::helper('html')->javascript('jquery.js'));
			$this->addHeaderItem(Loader::helper('html')->javascript('ccm.core.commerce.cart.js', 'core_commerce'));
			$this->addHeaderItem($html->css('jquery.ui.css'));
   			$this->addHeaderItem($html->css('ccm.dialog.css'));
   			$this->addHeaderItem($html->javascript('jquery.ui.js'));
   			$this->addHeaderItem($html->javascript('ccm.dialog.js'));
			$this->addHeaderItem($html->javascript("https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyDw7irck_KNNx1gYHriiKD6PITWpTnZdp0"));
			$this->addFooterItem(Loader::helper('html')->javascript('jquery.form.js'));
			
			
			
		}
		
		
		Loader::model('product/list', 'core_commerce');
		$this->set('packageName',$this->packageName);
		
		
		
	}
	
	public function getBlockTypeDescription() {
		
		return t('Adds the area search information into your web page');
		
	}
	
	public function getBlockTypeName()
	{
		
		return t('Area Search');
	}
	
	public function view() {
		
		$this->set('displayType',$this->displayTypeID);
		
		
		
		if($this->displayTypeID == DisplayType::map || $this->displayTypeID == DisplayType::mapForm)
		{
			
			
			//Lets load the set model from core_commerce
			Loader::model('product/set','core_commerce');
			
			$set = new CoreCommerceProductSet();
			
			//get the list of sets so we can get the right one.
			$sets = $set->getList();
			
			//start the process of getting the products
			$productList = new CoreCommerceProductList();
			
			foreach($sets as $productSet)
			{
				if($productSet instanceof CoreCommerceProductSet)
				{
					if($productSet->prsName == 'MooMusic Areas' )
					{
						//filter by areas.	
						$productList->filterBySet($productSet);
						
						//filter by active areas only.
						$productList->filterByStatus(1);
						
						$arrayProducts = array();
						
						$products = $productList->get();
						
						$v = View::getInstance();
	   					
						$image = $v->getThemePath() . '/images/moo-music-logo-small.png';
						
						//get randome moo music image for map window.
						Loader::helper('utilities',$this->packageName);
						$uh = Loader::helper('urls', 'core_commerce');
						
						
						$utilityHelper = new MooMusicUtilitiesHelper();
						
						$page = Page::getCurrentPage();
						
																
						
						
						foreach($products as $product)
						{
							
							$cartLink = sprintf("ccm_coreCommerceRegisterAddToCart('ccm-core-commerce-add-to-cart-form-%s','%s');",$product->getProductID(),$uh->getToolsURL('cart_dialog'));
							
							
							
							$arrayProducts[] = new ProductInfo(	$product->getProductName(),
																$product->getAttribute('latitude'),
																$product->getAttribute('longitude'),
																$product->getProductDescription(),
																$product->getProductPrice(),
																$image,
																$utilityHelper->getrandommoomusicimage(),
																$page->getCollectionID(),
																$product->getProductID(),
																$cartLink
																);
							
						}
						
						$this->set('products',$arrayProducts);
						
					}
					
				}
				
			}
			
		}
		
		
		
		
	}
	
	
	public function save($data)
	{
		//var_dump($data);	
		parent::save($data);
		
	}
	
}

 final class DisplayType
{
	 const map = 0;
	const form = 1;
	const mapForm = 2;
	
	
}

class ProductInfo
{
	public $name;	
	public $latitude;
	public $longitude;
	public $description;
	public $price;	
	public $markerImage;
	public $infowindowImage;
	public $cID;
	public $prID;
	public $cartLink;
		
	function __construct($name,$latitude,$longitude,$description,$price,$markerImage,$infowindowImage,$cID,$prID,$cartLink)
	{
		$this->name = $name;	
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->description = $description;
		$this->price = $price;
		$this->markerImage = $markerImage;
		$this->infowindowImage = $infowindowImage;
		$this->cID = $cID;
		$this->prID = $prID;
		$this->cartLink = $cartLink;
	}
	
	
	
	
}
