<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

//Lets load the set model from core_commerce
Loader::model('product/set','core_commerce');
Loader::model('product/list','core_commerce');
Loader::model('order/product','core_commerce');
Loader::model('order/list','core_commerce');
Loader::model('order/model','core_commerce');
Loader::model('session','moo_music');
		
class MooMusicSessionsModel extends CoreCommerceOrderList {
	
	public $sessions = array();
	
	public function __construct()
	{
		
	}
	
	/**
	 * @return array of areas that match the search. 
	 */
	public function getNearestSessions($search)
	{
		//filter by completed orders
		$this->filterByOrderStatus(CoreCommerceOrder::STATUS_COMPLETE);
		
		$set = new CoreCommerceProductSet();
		
		//get the list of sets so we can get the right one.
		$sets = $set->getList();
		
		foreach($sets as $productSet)
		{
			if($productSet instanceof CoreCommerceProductSet && $productSet->prsName == 'MooMusic Areas' )
			{
				$this->filterBySet($productSet);		
				
			}
			
		}
		
		
		$orderIDs = array();
		
		//lets loop through every order that contains a product.
		foreach($this->get() as $order)
		{
			$orderID = $order->getOrderID();
			if(!in_array($orderID, $orderIDs))
			{
				$session = new MooMusicSessionModel($orderID);
			
			
				if($session->isAreaInVicinity($search,50))
				{
					$this->sessions[] = $session;
						
				}
				$orderIDs[] = $orderID;	
			}	
			
			
			
		}
		
		
	}
	
		
	
	
}
