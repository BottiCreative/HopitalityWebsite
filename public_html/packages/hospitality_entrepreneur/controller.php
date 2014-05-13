<?php defined('C5_EXECUTE') or die('Access Denied');

class HospitalityEntrepreneurPackage extends Package {
	
	
	protected $pkgHandle = 'hospitality_entrepreneur';
	protected $appVersionRequired = '1.0.0';
	protected $pkgVersion = '1.0.3';
	
	public function on_start()
	{
		Events::extend('core_commerce_change_order_status', 'HEChangeOrderStatus', 'onChange', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/models/events/change_order_status.php');
	}
	
	public function getPackageDescription()
	{
		
		return t("Hospitality Entrepreneur System Integration Package");
		
	}
	
	public function getPackageName()
	{
		return t('Hospitality Entrepreneur');
		
	}
	
	public function getPackageHandle()
	{
		
		return $this->pkgHandle;
	}
	
	public function install() {
			
		$pkg = parent::install();	
		
		$this->AddBlocks();
		
		//$this->AddDiscountType();
		
		//add pages.
		$this->AddDashboardPages();
		
		//add payment methods
		$this->AddPaymentMethods();
		
		
		//now add the theme.
		PageTheme::add('hospitalitytheme', $pkg);
		
		
			
		
	}
	
	public function upgrade()
	{
		
		parent::upgrade();
		$this->AddBlocks();
		$this->AddDashboardPages();
		
		$this->AddPaymentMethods();
		
		
		//$pkg = Package::getByHandle($this->getPackageHandle());
		
		
		
	}
	
	private function AddPaymentMethods()
	{
		
		$pkg = Package::getByHandle($this->getPackageHandle());	
			
		//now add the core_commerce payment option.
		//load the payment handler for this package.  Load the default one
		$coreCommerceHandle = Package::getByHandle('core_commerce');
		Loader::model('payment/method', 'core_commerce');
		
		//attempt to get the payment methods.
		$paymentMethod = CoreCommercePaymentMethod::getByHandle($this->getPackageHandle());
		
		if(!is_object($paymentMethod))
		{
			//now payment method.  Lets add it now.	
			CoreCommercePaymentMethod::add($this->getPackageHandle(), $this->getPackageDescription(), 0,NULL, $pkg);
		}
		
		
		
	}
	
	private function AddDiscountType()
	{
		$db = Loader::db();
		$pkg = Package::getByHandle($this->getPackageHandle());
		
		Loader::model('discount/type', 'core_commerce');
		
		$areaDiscountType = CoreCommerceDiscountType::getByHandle('area',$pkg);
		
		if(!is_object($areaDiscountType) || $areaDiscountType->isError())
		{
				
			$discountType = new CoreCommerceDiscountType();
			$discountType->
			$discountType->add('area','Area Discounts',$pkg);
			
			//$db->Execute('update CoreCommerceDiscountTypes set pkgID = ? where discountTypeHandle = \'?\'', array(10,'area'));
		
			
			
		}
		
		
		
	}
	
	/**
	 * Adds the blocks.
	 * 
	 */
	private function AddBlocks()
	{
		
		/*$pkg = Package::getByHandle($this->getPackageHandle());
		
		Loader::model('block');
		
		$moomusic_area_search = BlockType::getByHandle('moo_music_area_search',$pkg);
		
		if(!is_object($moomusic_area_search))
		{
			//add the area search block.
			BlockType::installBlockTypeFromPackage('moo_music_area_search',$pkg);
			
		}
		
		$moomusic_file_download = BlockType::getByHandle('moo_music_file_downloader',$pkg);
		
		if(!is_object($moomusic_file_download))
		{
			//add the area search block.
			BlockType::installBlockTypeFromPackage('moo_music_file_downloader',$pkg);
			
		}
		
		$moomusic_session_search = BlockType::getByHandle('moo_music_sessions_search',$pkg);
		 
		if(!is_object($moomusic_session_search))
		{
			
			BlockType::installBlockTypeFromPackage('moo_music_sessions_search',$pkg);
			
		}
		*/
		
		
	}
	
	/**
	 * Adds dashboard pages to the system for administrators.
	 */
	private function AddDashboardPages()
	{
		/*Loader::model('package');
		// install single pages
        Loader::model('single_page');
       		
		$pkg = Package::getByHandle($this->getPackageHandle());
			
		
	
		$sp = SinglePage::getByPath('/dashboard/moomusic');
		
		if($sp->isError() && $sp->getError() == COLLECTION_NOT_FOUND)
		{
			$sp = SinglePage::add('/dashboard/moomusic',$pkg);
			$sp->update(array('cName'=>$this->getPackageName(), 'cDescription'=>$this->getPackageDescription()));
        	
		}
		
		$sp = SinglePage::getByPath('/dashboard/moomusic/areas');
		
		if($sp->isError() && $sp->getError() == COLLECTION_NOT_FOUND)
		{
			SinglePage::add('/dashboard/moomusic/areas', $pkg);
        		
		}
		
		$sp = SinglePage::getByPath('/dashboard/moomusic/members');
		
		if($sp->isError() && $sp->getError() == COLLECTION_NOT_FOUND)
		{
				
			SinglePage::add('/dashboard/moomusic/members', $pkg);	
			
		}
		*/
        
	}
	
	
	
	private function AddProduct($district,$band,$price,$productSet)
	{
		Loader::model('product/model','core_commerce');
		Loader::model('product/list','core_commerce');
	
		$productList = new CoreCommerceProductList();
		
		$productList->filterByAttribute('postcode',$district);
		
		if($productList->getTotal() < 1)
		{
				
				
			$prStatus = $price == "0" ? "0" : "1";
		
			$product = new CoreCommerceProduct();
			
			$newProduct = $product->add(
				array(
					'prQuantity' => 1,
					'prStatus' => $prStatus,
					'prRequiresTax' => "1",
					'prName' => $district,
					'prPrice' => $price
				)
			
			);
			
			$newProduct->setAttribute("band", $band);
			$newProduct->setAttribute("postcode", $district);
			
			//lets make sure this area is part of the set.
			$newProduct->setProductSets(array($productSet));
			
			
			
		}
		
		
		
		
		
			
							
		
		
		
		
			
		
	}

}

