<?php 
	defined('C5_EXECUTE') or die(_("Access Denied."));
	
	/**
	 * Geocode helper class - uses google maps
	 */
	class MooMusicGeocodeHelper {
	
		/**
		 * Gets coordinates from a postcode.
		 * @param postcode the postcode to use to return information on.
		 * @return Details of area as an object.  Returned as google geolocation object
		 */
		public function getcoordinatesfrompostcode($postcode,$country) {
			
			$googleMapsUrl = sprintf("https://maps.googleapis.com/maps/api/geocode/json?address=%s,%s&sensor=false&",$postcode,$country);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $googleMapsUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$geoloc = json_decode(curl_exec($ch), true);
			
						
				
			return $geoloc;
		}
		
		
			/**
		 * Gets coordinates from a postcode.  Uses google distance matrix rest api
		 * @param origin the area searched for
		 * @param destination the destination to search from.	
		 * @return Details of area as an object.  Returned as google distance matrix object - returns text (in miles) and value in meters
		 */
		public function getDistanceBetweenPoints($origin,$destination) {
			
			$googleMapsUrl = sprintf("https://maps.googleapis.com/maps/api/distancematrix/json?origins=%s+United+Kingdom&destinations=%s&sensor=false&units=imperial",str_replace(' ','',$origin),str_replace(' ','',$destination));
			//Log::addEntry($googleMapsUrl,'Geocode: DistanceBetweenPoints');
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $googleMapsUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$distanceMatrix = json_decode(curl_exec($ch), true);
			Log::addEntry(var_export($distanceMatrix,true),'Geocode: DistanceBetweenPoints');
			
		
				
			return $distanceMatrix['rows'][0]['elements'][0]['distance'];
		}
			
	
	}
?>