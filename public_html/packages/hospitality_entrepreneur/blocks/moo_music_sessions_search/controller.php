<?php defined('C5_EXECUTE') or die('Access Denied');

class MooMusicSessionsSearchBlockController extends BlockController {
	
	protected $btTable = 'btMooMusicSessionsSearch';
	protected $packageName = 'moo_music';
	
	public function on_page_view()
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
			
			Loader::model('product/list', 'core_commerce');
			Loader::model('order/list', 'core_commerce');
			
			$this->set('packageName',$this->packageName);
			
		
		
	}
	
	public function getBlockTypeDescription() {
		
		return t('Shows the moo music sessions based on a postcode or area');
		
	}
	
	public function getBlockTypeName()
	{
		
		return t('Moo Music Session Search');
	}
	
	public function view() {
		
			//Lets load the set model from core_commerce
			Loader::model('product/set','core_commerce');
			Loader::model('areas',$this->packageName);
			
			$set = new CoreCommerceProductSet();
			
			$this->set('ResultMessage',$this->ResultMessage);
			$this->set('NoResultMessage',$this->NoResultMessage);
			
			if(isset($_REQUEST['search']))
			{
			
				//get the list of sets so we can get the right one.
				$sets = $set->getList();
				
				//start the process of getting the products
				$productList = new MooMusicAreasModel();
				
				foreach($sets as $productSet)
				{
					if($productSet instanceof CoreCommerceProductSet)
					{
						if($productSet->prsName == 'MooMusic Areas' )
						{
							//filter by areas.	
							$productList->filterBySet($productSet);
							
							//filter by active areas only.
							$productList->filterByAreasSold();
							
							var_dump($productList);
							exit();
							
							$arrayProducts = array();
							
							$products = $productList->get();
							
							$v = View::getInstance();
		   					
							$image = $v->getThemePath() . '/images/moo-music-logo-small.png';
							
							//get randome moo music image for map window.
							Loader::helper('utilities',$this->packageName);
							$uh = Loader::helper('urls', 'core_commerce');
							
							
							$utilityHelper = new MooMusicUtilitiesHelper();
							
							$page = Page::getCurrentPage();
							
							$this->set('products',$products);
							
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