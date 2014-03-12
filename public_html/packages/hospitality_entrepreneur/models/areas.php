<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

//Lets load the set model from core_commerce
Loader::model('product/set','core_commerce');
Loader::model('product/list','core_commerce');
Loader::helper('geocode','moo_music');
		
		
		
class MooMusicAreasModel extends CoreCommerceProductList {
	
	public function __construct()
	{
		$this->filterAreas();
		
	}
	
	
	/** 
	 * Filters areas where no coordinates are present e.g where longitude and latitude is 0
	 * 
	 */
	public function filterAreasByNoCoordinates() {
		
			
		$this->filterAreas();
		$this->filterByAttribute('latitude','0');
		$this->filterByAttribute('longitude','0');
		
		
	}	
	
	public function filterByAreaSearch($searchTerm)
	{
		$l = new Log('special_application', true);
		
		//ok, lets get the base query
		$baseQuery = $this->executeBase();
		
		$this->filterAreas();
		$db = Loader::db();
		$this->filter(false,"case when TRIM(ak_postcode) = " . $db->quote($searchTerm) . " THEN (TRIM(ak_postcode) = " . $db->quote($searchTerm) . ")
							ELSE (pr.prName like " . $db->quote('%' . $searchTerm . '%') . 
							" or pr.prDescription like " . $db->quote('%' . $searchTerm . '%') .") " . 
							"END"  
							);
		
		$l->write($this->executeBase());
		//$this->filterByAttribute('postcode',$searchTerm);
		
		
	$l->close();	
	
		
		
	}
	
	
	
	/**
	 * Gets areas for the google map representation of moo music.
	 * Currently only gets active areas.
	 */
	/*public function getAreasForMap() 
	{
		$this->setQuery('SELECT distinct pr.productID, ' . $prspDisplayOrder . ', ' . $prCurrentPrice . ' from CoreCommerceProducts pr left join Pages on Pages.cID = pr.cID');	
		$this->filterAreas();
		$this->filterByStatus(1)
		$this->filter
	}*/
	
	public function filterByAreasSold()
	{
			
		//$this->filterByQuantity(0);
		
		$this->filter(false,'(pr.prQuantity < 1 and pr.prQuantityAllowNegative < 1 and pr.prQuantityUnlimited < 1 and pr.prStatus = 1)');
		
	}
	
	/**
	 * Gets products that are sold and available to visitors
	 * 
	 * @param	$searchTerm	The search that the visitor inserted
	 * 
	 * @return	an array of active sessions
	 * 
	 */
	public function filterByActiveSessions($searchTerm,$radiusMiles)
	{
			
		$this->filter(false,'(pr.prQuantity < 1 and pr.prQuantityAllowNegative < 1 and pr.prQuantityUnlimited < 1 and pr.prStatus = 1)');
		
		$sessions = array();
		
		foreach($this->get() as $session)
		{
				
				
				
				$destination = $session->getAttribute('latitude') . ',' . $session->getAttribute('longitude');
				
				
				$geocode = new MooMusicGeocodeHelper();
				$distance = $geocode->getDistanceBetweenPoints($searchTerm, $destination);
				
				//we've got the distance in meters - convert to miles.
				$distanceInMiles = $distance['value'] * 0.00062137;
				
				if($distanceInMiles <= $radiusMiles && is_numeric($distance['value']))
				{
						
					$sessions[] = array('product' => $session,'distanceMiles' => $distance['text']);	
					
				}
		
		}
		
		return $sessions;
		
	}
	
	
	
	/**
	 * Filters by all moo music areas.
	 */
	private function filterAreas()
	{
		
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
		
		
	}
	
	
	
}
