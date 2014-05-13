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
					HEChangeOrderStatus::SetMembership($order);	
				}
				catch( exception $e)
				{
					Log::addEntry('Error trying to set membership: ' . $e->getMessage());					
					
				}
				
				 
			break;
			case CoreCommerceOrder::STATUS_INCOMPLETE:
				
				/*try{
					HEChangeOrderStatus::SetMembership($order);	
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
		
		$newUserObj = $newUser->getUserObject();
		
		$memberEmail = <<<EMAIL
		 <p>Thanks for joining</p>
		 <ul>
		 <li>Your username is <strong>{$newUserObj->getUserName()}</strong></li>
		 <li>Your password is <strong>{$newUserPassword}</strong></li>
		 </ul>
EMAIL;
				
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
	
	
	
}