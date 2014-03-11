<?php      
defined('C5_EXECUTE') or die("Access Denied.");
class ProblogConcreteInterfaceMenuItemController extends ConcreteInterfaceMenuItemController {
	
	public function displayItem() {
		//$pk = Cache::flush();
		$u = new User();
		if($u->isLoggedIn()){
			//Cache::flush();
			$tp = PermissionKey::getByHandle('problog_post');
			if ($u->isSuperUser() || $tp->can()){
				return true;
			}
		}
		return false;
	}

}