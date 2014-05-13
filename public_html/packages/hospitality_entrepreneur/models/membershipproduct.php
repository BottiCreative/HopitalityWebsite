<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

//Lets load the set model from core_commerce
Loader::model('product/set','core_commerce');
Loader::model('product/list','core_commerce');
Loader::model('product/model','core_commerce');

		
		
		
class HospitalityEntrepreneurMembershipProductModel extends CoreCommerceProduct {
	
	
	
	/**
	 * Gets the membership level for this product
	 */
	public function getMembershipLevel($productID)
	{
		
		$db = Loader::db();
		$arrmembershipLevel = $db->GetAll("SELECT ak_Membership_Level FROM CoreCommerceProductSearchIndexAttributes WHERE productID = ?",array($productID));
		//$membershipLevel = str_replace(' ','-',trim($arrmembershipLevel[0]['ak_Membership_Level']));
		
		return trim($arrmembershipLevel[0]['ak_Membership_Level']);
		
		
	}
	
	
	
	
	
}
