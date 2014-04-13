<?php 
	defined('C5_EXECUTE') or die(_("Access Denied."));
	
	/**
	 * Utilities helper class - random functions useful for operation.
	 */
	class HospitalityEntrepreneurUtilitiesHelper {
		
		private $dateLockedWindowMinutes = 15;
		private $packageHandle = 'moo_music';
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
	
	public function get_member_email($username, $password, $loginlink)
	{
		$pkg = Package::getByHandle($this->packageHandle);
		
		$memberemail = $pkg->config('MOO_MUSIC_MEMBER_EMAIL');
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
		
		
		
		//get the membership groups that are allowed to purchase...
		$purchaseGroups = $product->getProductPurchaseGroupIDArray();
		
		$userHasAccess = false;
		
		
		foreach($purchaseGroups as $purchaseGroup)
		{
			$group = Group::getByID($purchaseGroup);
			
			//if the current user is a superuser or has admin access then give them access.
			//$userHasAccess = ($user->isSuperUser() || $user->inGroup(Group::getByName("Administrators"))); 
			
			if(!$userHasAccess)
			{
				
				$userHasAccess = $user->inGroup($group);
				
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
	
	
	}
?>