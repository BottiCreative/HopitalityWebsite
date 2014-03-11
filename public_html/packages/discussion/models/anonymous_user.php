<?php 
/**
 * Classes to spoof the discussion display to honor anonymous users
 * @author rtyler
 */
class AnonymousUserInfo extends UserInfo {
		
	public function getUserID() {
		return 0;
	}
	
	public function getUserName() {
		return t("Anonymous");
	}
	
	public function getUserDateAdded() {
		$dh = Loader::helper('date');
		$pkg = Package::getByHandle('discussion');
		return $pkg->getPackageDateInstalled('user');
	}
	
	public function getUserObject() {
		return new AnonymousUser();
	} 
}

class AnonymousUser extends User {
	
	public function getUserName() {
		return AnonymousUserInfo::getUserName();
	}

	public function getUserID() {
		return AnonymousUserInfo::getUserID();
	}

}