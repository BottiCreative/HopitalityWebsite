<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

//Lets load the set model from core_commerce
Loader::library('iSDK/isdk','infusion');
		
		
class InfusionGroupsModel 	
{
	
	 private $packageName = 'infusion'; 
	 
	/**
	 * Checks the infusion connection.
	 * @return true if the connection to infusion is valid, false if not connected.
	 */	
	private function IsConnected()
	{
		$isConnected = false;	
		
		$pkg = Package::getByHandle($this->packageName);
		
		$app = new iSDK;
		
		//check infusion connection.
		if($app->cfgCon($pkg->config('INFUSION_CONNECTIONNAME'))){
		
			$isConnected = true;
		}	
		
		
		
		
		return $isConnected;
		
		
	}
	
	public function addTag($infusionContactID,$tagID)
	{
		
	}
	
	/*
	 * N.Gabbidon
	 * 
	 * updates an infusion contact record
	 * 
	 * int Contactid: the id of the member in infusion 
	 * string Email: email address of person
	 * array Updatedfields: the fields to update
	 * 
	 * returns int
	 */
	public function updateInfusionContact($ContactID=0,$Email = null,$UpdatedFields,$tagIDS = null)
	{
		$pkg = Package::getByHandle($this->packageName);
		
		$app = new iSDK;
		
		//check infusion connection.
		if($app->cfgCon($pkg->config('INFUSION_CONNECTIONNAME'))){
				
			
			$ExistingContact = array();
			
			//find a contact by email if it's not already present.
			if(intval($ContactID) <  1)
			{
					
				$ExistingContact = $app->findByEmail($Email,array("Id"));
				
					
			}
			else 
			{
					$app->updateCon(intval($ContactID), $UpdatedFields);
					
							
			}	
			
			//if existing contact found, update it.
			if(count($ExistingContact) > 0)
			{
					
					$ContactID = $ExistingContact[0]['Id'];
					$app->updateCon($ContactID, $UpdatedFields);
					
						
			}
			else {
					//no contact found, create a new one with the new fields added and return the contact id 
					$ContactID =  $app->addCon($UpdatedFields);
			}	
					
			//see if contact id is valid, and if there are tags.
			if(intval($ContactID) > 0 && is_array($tagIDS))
			{
				//now add any tag ids.
				foreach($tagIDS as $tagID)
				{
					$app->grpAssign($ContactID, $tagID);	
				
				}
				
					
			}
				
						
		}
			
						
		
				
		//return false to indicate that no records have been updated
		return $ContactID;
		
		
	}
	
	
	
}
