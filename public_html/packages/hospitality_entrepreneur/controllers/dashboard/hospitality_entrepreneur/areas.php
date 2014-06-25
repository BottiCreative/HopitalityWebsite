<?php


class DashboardMooMusicAreasController extends Controller {
		
	var $packageHandle = 'moo_music';		
	var $coreCommerceHandle = 'core_commerce';

	public function view()
	{
		$this->set('title','Manage Areas');	
			
		Loader::helper('concrete/interface/menu');
		$adminMenu = new ConcreteInterfaceMenuHelper();
		
		$adminMenu->addPageHeaderMenuItem(0,"Set Areas Coordinates", 0,null,'moo_music');
		$this->set('adminMenu',$adminMenu);
		
		
		
		
	}
	
	public function update_area_coordinates($updateareas = null)
	{
		$this->set('title','Update Area Coordinates');
		
		Loader::model('areas',$this->packageHandle);
		$mooMusicAreas = new MooMusicAreasModel();
		$mooMusicAreas->filterAreasByNoCoordinates();
		
		//add the count of areas that require an update e.g haven't got coordinates set.
		$this->set('noOfAreasToUpdate',$mooMusicAreas->getTotal());
		
		if($updateareas != null && $updateareas ==  'update')
		{
			//lets start the process off for updating maps.
			//get helper.
			Loader::helper('geocode',$this->packageHandle);
			
			$remainingMooMusicAreas = $mooMusicAreas->get($mooMusicAreas->getTotal());
			
			$geolocationHelper = new MooMusicGeocodeHelper();
			
			foreach($remainingMooMusicAreas as $mooMusicArea)
			{
					
				$mooMusicPostcode = trim($mooMusicArea->getAttribute('postcode'));
				$geocodedAreaDetails = $geolocationHelper->getcoordinatesfrompostcode($mooMusicPostcode, 'UK');
				
				$dataToUpdate = array('prName' => $geocodedAreaDetails['results'][0]['formatted_address'],
									'prPrice' => $mooMusicArea->getProductPrice(),
									'prStatus' => $mooMusicArea->getProductStatus(),
									'prQuantity' => $mooMusicArea->getProductQuantity(),
									'prRequiresTax' => $mooMusicArea->productRequiresSalesTax()
									);
				
				$mooMusicArea->setAttribute('latitude', $geocodedAreaDetails['results'][0]['geometry']['location']['lat']);
				$mooMusicArea->setAttribute('longitude', $geocodedAreaDetails['results'][0]['geometry']['location']['lng']);
				$mooMusicArea->update($dataToUpdate);
				
			}
			 
			/*//*foreach($mooMusicAreas->get() as $mooMusicArea)
			{
			
				
			}*/
			
			
		}
		
		
		
		
	}
	
	public function update_area_borders($updateborders = null)
	{
		$this->set('title','Update Area Coordinates');
		
		Loader::helper('form');
		$form = new FormHelper();
		
		$this->set('border_textarea',$form->textarea('border_textarea',array('style'=> 'width: 100%;height: 300px;')));
		if($updateborders != null && $updateborders ==  'update')
		{
			$this->AddAreaBorders($this->post('border_textarea'));
			
			
		}
		
		
		
		
	}

	private function AddAreaBorders($areaList)
	{
		
		//Lets load the set model from core_commerce
		Loader::model('product/set','core_commerce');
		Loader::model('product/list','core_commerce');
		
		
		$set = new CoreCommerceProductSet();
		
		//get the list of sets so we can get the right one.
		$sets = $set->getList();
		
		//start the process of getting the products
		$productList = new CoreCommerceProductList();
		
		$productSetID = -1;
		
		foreach($sets as $productSet)
		{
			if($productSet instanceof CoreCommerceProductSet)
			{
				if($productSet->prsName == 'MooMusic Areas' )
				{
					$productSetID = $productSet->getProductSetID();
					
				}
			}
		}
		
		if($productSetID > 0)
		{
				$line_of_text  = explode("\n",$areaList);
			
				if(count($line_of_text) > 0)
				{
					
					foreach($line_of_text as $line)
					{
						//get the postcode/district by seperating the line by the first comma only
						$districtInformation = explode(',',$line,2);
						
						$district = $districtInformation[0];
						
						$productList = new CoreCommerceProductList();
		
						$productList->filterByAttribute('postcode',$district);
					
						if($productList->getTotal() == 1)
						{
		
							$product = $productList->get(1,0);
							
							//clean up the borders (remove the double quote and any whitespace);
							$cleanedBorderList = str_replace('"','',$districtInformation[1]);
							$arrayBorderList = explode(',',$cleanedBorderList);
							
							
							
							
							$borderList = array();
							
							//now we need to reformat this and make sure we get the list of coordinates based on the multiple of 2.
							for($ndx = 1;$ndx<=count($arrayBorderList);$ndx++)
							{
								if($ndx % 2 == 0)
								{
									//multiple of two, lets add the previous coordinate and this one together.
									$borderList[] = sprintf("%s,%s",trim($arrayBorderList[$ndx - 2]),trim($arrayBorderList[$ndx-1])); 
								}	
									
								
								
								
							}
							
							
							//now set the borders
							$product[0]->setAttribute('borders',implode("\n\r",$borderList));
							
						}
										
							
					
						
						
					}	
						
					
								
					
					
				
					
				
				}
				
			
			
		}
		
	}

	
}


?>