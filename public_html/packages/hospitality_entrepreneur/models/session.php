<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

//Lets load the set model from core_commerce
Loader::model('product/set','core_commerce');
Loader::model('product/list','core_commerce');
Loader::model('product/model','core_commerce');
Loader::model('order/product','core_commerce');
Loader::model('order/list','core_commerce');
Loader::model('order/model','core_commerce');
Loader::helper('geocode','moo_music');
		
class MooMusicSessionModel extends CoreCommerceOrder {
	
	/**
	 * The areas that have been selected based on the vicinity.
	 */ 
	protected $areas = array();
	protected $distanceMiles = array();

	public function __construct($orderID)
	{
		$this->load($orderID);
		
	}
	
	
	public function getAreas($index = null)
	{
		if($index <= 0) 
		{
			$index = 1;		
		}
		
		if(isset($index))
		{
			return array('distance_miles' => $this->distanceMiles[$index - 1],'area' => $this->areas[$index - 1]);
		}	
		return array('distance_miles' => $this->distanceMiles, 'area' => $this->areas);
		
	}
	
	/**
	 * @param searchTerm the area search for the session
	 * @param radiusMiles the radius with which to search for the session within the vicinity
	 * @return boolean true=located session, false = not in vicinity.
	 */
	public function isAreaInVicinity($searchTerm,$radiusMiles)
	{
		$products = $this->getProducts();
		foreach($products as $orderProduct)
		{
			$product = CoreCommerceProduct::getByID($orderProduct->getOrderID());
			
			if($product instanceof CoreCommerceProduct )
			{
				
			
				
				$destination = $product->getAttribute('latitude') . ',' . $product->getAttribute('longitude');
				
				
				$geocode = new MooMusicGeocodeHelper();
				$distance = $geocode->getDistanceBetweenPoints($searchTerm, $destination);
				
				
				//we've got the distance in meters - convert to miles.
				$distanceInMiles = $distance['value'] * 0.00062137;
				
				if($distanceInMiles <= $radiusMiles && is_numeric($distance['value']))
				{
						
					$this->areas[] = $product;
					$this->distanceMiles[] = $distance['text'];
					
				}
				
			}
			
			
		}
		
		return (count($this->areas) > 0);
		
	}
	

}
