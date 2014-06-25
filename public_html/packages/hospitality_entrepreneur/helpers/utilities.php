<?php 
	defined('C5_EXECUTE') or die(_("Access Denied."));
	
	/**
	 * Utilities helper class - random functions useful for operation.
	 */
	class HospitalityEntrepreneurUtilitiesHelper {
		
		private $dateLockedWindowMinutes = 15;
		private $packageHandle = 'hospitality_entrepreneur';
		private $membershipSetName = 'Membership';
		 
		 
		 /**
		 * Chooses from trademark moo music images and returns a random one.
		 * @return random moo music image path.
		 */
		public function getrandommoomusicimage() {
			
			$images = array("croo-doris.png","croo-henry.png","croo-maggie.png","croo-ollie.png");
			
			$randomImageIndex = rand(0, count($images) - 1);
			$v = View::getInstance();
			$themePath = $v->getThemePath();
			
			$fullImagePath = $themePath . '/images/' . $images[$randomImageIndex];
			
						
				
			return $fullImagePath;
		}
		
		/**
		 *	Locks the area for a specified amount of time 
		 */
		public function LockArea($area)
		{
			$area->setAttribute('date_locked',Date('Y-m-d H:i:s',strtotime("+{$this->dateLockedWindowMinutes} minutes")));
			
			$area->setAttribute('identifier',$_COOKIE['CONCRETE5']);
			
			
		}
		
		public function IsAreaLocked($area)
		{
			$today = date("Y-m-d H:i:s");
			
			$areaLockedDate = date('Y-m-d H:i:s',strtotime($area->getAttribute('date_locked')));
			$sessionData = $area->getAttribute('identifier');
			
			
			
			return (($areaLockedDate > $today) && ($sessionData != $_COOKIE['CONCRETE5']));
			//return ($today > $areaLockedDate);
			//return false;
		}
		
		public function get_license($name,$address,$orderday,$ordermonth,$orderyear,$areas)
	{
		$pkg = Package::getByHandle($this->packageHandle);
		
		
		$license = $pkg->config('MOO_MUSIC_LICENSE');
		$license = str_replace('[name]',$name,$license);
		$license = str_replace('[address]',$address,$license);
		$license = str_replace('[orderday]',$orderday,$license);
		$license = str_replace('[ordermonth]',$ordermonth,$license);
		$license = str_replace('[orderyear]',$orderyear,$license);
		$license = str_replace('[areas]',$areas,$license);
		
		return $license;
		
		
		
	}
	
	/**
	 * Gets the saved member email, replacing certain links if necessary.
	 * @param username username of member
	 * @param password password of member
	 * @param loginlink the link to the site.
	 * 
	 * @return the member email text.
	 */
	public function get_member_email($username, $password, $loginlink)
	{
		$pkg = Package::getByHandle($this->packageHandle);
		
		$memberemail = $pkg->config('HOSPITALITY_ENTREPRENEUR_MEMBER_EMAIL');
		$memberemail = str_replace('[username]',$username,$memberemail);
		$memberemail = str_replace('[password]',$password,$memberemail);
		$memberemail = str_replace('[loginlink]',$loginlink,$memberemail);
		
		return $memberemail;
		
	}
	
	/**
	 * Determine if user has access to the current product.
	 */ 
	public function user_has_access($product, $user = null)
	{
		
		//get the current user;
		if(!isset($user))
		{
				
			$user = new User();
		}
		
		
		//if the current user is a superuser or has admin access then give them access.
		$userHasAccess = ($user->isSuperUser() || $user->inGroup(Group::getByName("Administrators"))); 
		
		if($userHasAccess)
		{
			return $userHasAccess;
		}
		
		
		$db = Loader::db();
		$arrPurchaseGroups = $db->GetAll("SELECT ak_authorized_members FROM CoreCommerceProductSearchIndexAttributes WHERE productID = ?",array($product->getProductID()));
		
		
		//get purchase groups by splitting by newline characters.
		$purchaseGroups = explode("\n",$arrPurchaseGroups[0]['ak_authorized_members']);
		
		
		
		foreach($purchaseGroups as $purchaseGroup)
		{
			//sometime empty value can be returned.  Lets skip them.	
			if(empty($purchaseGroup))
				continue;
				
			$group = Group::getByName($purchaseGroup);
			
			
			if(!$userHasAccess)
			{
				
				$userHasAccess = $user->inGroup($group);
				
			}
			else {
				//has access.  Lets return
				return $userHasAccess;
			}
			
			
			
			
				
			
		}
		
		return $userHasAccess;
		
	}
	
	/**
	 * Attempt resize using imagemagick
	 * @param $width width of image
	 * @param $height height of image
	 * @param image full path of image.
	 */
	public function imageMagickResizeImage($width=0,$height=0,$fullImagePath)
	{
		
		
		
	}
	
	public function get_membership_set()
	{
			
			
		$productSets = CoreCommerceProductSet::getList();

		//get the product set we want to select for EXCLUSION from the list.
		$selectedProductSet = null;
		
		foreach($productSets as $productSet)
		{
			if($productSet->getProductSetName() == $this->membershipSetName)
			{
				$selectedProductSet = $productSet;
				
				//found it, now return.
				return $selectedProductSet;
			}
			
				
			
		}	
	
			return $selectedProductSet;
	}
	
	
	/**
	 * Attempt
	 * 
	 */
	public function AddNewBuyerAsMember($order,$groupName)
	{
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
								
								
								$newUserObj = $newUser->getUserObject();
								
								//add user to the group if it exists.
								$group = Group::getByName($groupName);
								if(is_object($group))
								{
									$newUserObj->enterGroup($group);
									$order->setOrderUserID($newUserObj->getUserID());
									$order->setOrderEmail($newUserObj->getUserName());
									
									
									//$this->sendUserEmail($newUserObj,$order,$newUserPassword);
									
									
										
								}
							}
							
						
						
	}
	
	
	}
?>