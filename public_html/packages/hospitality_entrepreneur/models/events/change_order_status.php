<?php

Loader::model('events/change_order_status','core_commerce');

class HEChangeOrderStatus extends ChangeOrderStatus   {
   /**
    * This gets fired when an order status changes.
         * @param CoreCommerceOrder $order
         * @param integer           $status
    */
   public function onChange(CoreCommerceOrder $order, $status, $oldStatus) {
			
		
 		
		switch($status)
		{
			case CoreCommerceOrder::STATUS_AUTHORIZED:
			    
				try{
						
						
						
					HEChangeOrderStatus::send_to_infusion($order);	
					HEChangeOrderStatus::SetMembership($order);	
				}
				catch( exception $e)
				{
					Log::addEntry('Error trying to set membership: ' . $e->getMessage());					
					
				}
				
				 
			break;
			case CoreCommerceOrder::STATUS_INCOMPLETE:
				
				/*try{
					HEChangeOrderStatus::send_to_infusion($order);
				}
				catch( exception $e)
				{
					Log::addEntry('Error trying to set membership: ' . $e->getMessage());					
					
				}*/
				
			
			break;
		}
		
		
	}

	/**
	 * Sets the membership if a membership option has been purchased.
	 */
	public static function SetMembership($order)
	{
		//Loader::model('payment/controller', 'core_commerce');	
			
		$membership = HEChangeOrderStatus::get_membership_product($order);
			
		
		
		if($membership instanceof CoreCommerceProduct)
		{
			
			//we've got the membership.
			if (!$order->getOrderUserID())
						{
							
							$newUser = UserInfo::getByEmail($order->getOrderEmail());
							
							if(!is_object($newUser))
							{
								
								//no user assigned!  Lets automatically create the user and assign them to the moo music members group.
								$newUserPassword = rand(1111,9999);
								$newUser = UserInfo::register(array('uName' => $order->getOrderEmail(), 
																'uEmail' => $order->getOrderEmail(), 
																'uPassword' => $newUserPassword,
																'ulsValidated' => 1, 
																'ulsFullRecord' => 1,
																'uPasswordConfirm' => $newUserPassword));
								
								$newUser->setAttribute('billing_address',$order->getAttribute('billing_address'));
								$newUser->setAttribute('billing_first_name',$order->getAttribute('billing_first_name'));
								$newUser->setAttribute('billing_last_name',$order->getAttribute('billing_last_name'));
								$newUser->setAttribute('billing_phone',$order->getAttribute('billing_phone'));	
								
							}
								
								
								
								
								Loader::model('membershipproduct','hospitality_entrepreneur');
								
								$membershipProduct = new  HospitalityEntrepreneurMembershipProductModel();
								$selectedMembershipName = $membershipProduct->getMembershipLevel($membership->getProductID());
								
								//add user to the group if it exists.
								$group = Group::getByName($selectedMembershipName);
								if(is_object($group))
								{
									$newUserObj = $newUser->getUserObject();	
									$newUserObj->enterGroup($group);
									$order->setOrderUserID($newUserObj->getUserID());
									$order->setOrderEmail($newUserObj->getUserName());
									
									HEChangeOrderStatus::sendUserEmail($newUser,$order,$newUserPassword);
									
									
									
										
								}
							}
			
		}
		
		
		
	}
	
	
	
	public static function sendUserEmail($newUser, $order,$newUserPassword)
	{
		$mail = Loader::helper('mail');	
		Loader::helper('utilities','hospitality_entrepreneur');
		$hospitality = new HospitalityEntreprenurUtilitiesHelper();
		
		$loginLink = BASE_URL . '/members';
		
		$newUserObj = $newUser->getUserObject();
		
		$memberEmail = $hospitality->get_member_email($newUserObj->getUserName(), $newUserPassword, $loginLink);
				
		$mail->setSubject("Thanks for joining, {$newUser->getAttribute('billing_first_name')}!");
		$mail->from('noreply@hospitalityentrepreneur.com');
		$mail->to($order->getOrderEmail());
		
		$mail->setBodyHTML($memberEmail);
		$mail->sendMail();
	}
	
	/**
	 * Checks all products of an order to see what membership is defined.
	 * @param $order The order that contains the products.
	 * 
	 * @return The membership product from the order
	 */
	public static function get_membership_product($order)
	{
		Loader::model('product/set','core_commerce');	
		Loader::helper('utilities','hospitality_entrepreneur');
		$utils = new HospitalityEntrepreneurUtilitiesHelper();
			
			
		$productsOrdered = $order->getProducts();
		
		//get the membership product set.
		$membershipProductSet = $utils->get_membership_set();
		
		if($membershipProductSet instanceof CoreCommerceProductSet)
		{
			//search all products
			foreach($productsOrdered as $productOrdered)
			{
				if($productOrdered->inProductSet($membershipProductSet))
				{
					//its a membership product.  Lets get this one.  We get the first one that is in the list of orders.
					return $productOrdered->getProductObject();
				}
			}
			
			
			
		}
		
		return null;
		
		
	}
	
	/**
	 * Send user to infusion.
	 * @param $order the order
	 * 
	 * @return the order id
	 */
	public static function send_to_infusion($order)
	{
		//now load the infusion api
		Loader::model('Groups','infusion');
		
		$groups = new InfusionGroupsModel();
		
		$ContactData = array();
		
		$ContactData["FirstName"]  = $order->getAttribute('billing_first_name');
		$ContactData["LastName"]  = $order->getAttribute('billing_last_name');
		$ContactData["Email"] = $order->getOrderEmail();
		$ContactData["Phone1"] = $order->getAttribute('billing_phone');
		
		//get all the products
		$productTagIDS = array();
		$products = $order->getProducts();
		
		//search all products
		foreach($products as $productOrdered)
		{
			$productObject = $productOrdered->getProductObject();	
				
			$tags = $productObject->getAttribute('infusion_tag_ids');	
			
			//now split by comma
			$tagArray = explode(',',$tags);
			
			
			foreach($tagArray as $tag)
			{
				
				if(is_numeric(trim($tag)) && intval($tag) > 0 && !in_array($tag,$productTagIDS))
				{
					$productTagIDS[] = intval($tag);
				}
			}
			
				
		}
		
		return $groups->updateInfusionContact(0,$order->getOrderEmail(),$ContactData,$productTagIDS);
		
		
	}
	
}