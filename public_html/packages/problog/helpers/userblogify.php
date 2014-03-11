<?php    
defined('C5_EXECUTE') or die("Access Denied.");
class UserblogifyHelper {

	public function __construct() {

	}

	function getBlogSettings(){
		$db=Loader::db();
		
		$pp=$db->QUERY("SELECT * FROM btProBlogSettings LIMIT 1");
		
		while($row=$pp->FetchRow()){
			$blogSettings=$row;
		}
		return $blogSettings;
	}
	
	function getPosterAvatar($uID){
		$db=Loader::db();
		if($uID){
			$ui=UserInfo::getByID($uID);
			$ih=Loader::helper('image');
			$av=Loader::helper('concrete/avatar');

			if($ui->hasAvatar()){
				$avatarImgPath=$av->getImagePath($ui,false);
				$mw=($maxWidth)?$maxWidth:'60';
				$mh=($maxHeight)?$maxHeight:'80';
				if(substr($avatarImgPath,0,strlen(DIR_REL))==DIR_REL)$avatarImgPath=substr($avatarImgPath,strlen(DIR_REL));
					$thumb=$ih->getThumbnail(DIR_BASE.$avatarImgPath,$mw,$mh);
					if($thumb->src){
					ob_start();
					$ih->outputThumbnail(DIR_BASE.$avatarImgPath,$mw,$mh);
					$avatarHTML=ob_get_contents();
					ob_end_clean();
						}else{
				$avatarHTML='<img src="'.$avatarImgPath.'"/>';
					}
			}
		}
		return $avatarHTML;
	}
	
	
	public function getCommentCount($cParentID){
		$db=Loader::db();
		$r=$db->Execute("SELECT COUNT(cID) from btGuestbookEntries WHERE cID=$cParentID");
		while($row=$r->fetchrow()){
		return $row['COUNT(cID)'];
		}
	}
	
	public function getReviewsCommentCount($cParentID){
		$db=Loader::db();
		$r=$db->Execute("SELECT COUNT(cID) from btReviewsPlusEntries WHERE cID=$cParentID");
		while($row=$r->fetchrow()){
		return $row['COUNT(cID)'];
		}
	}
	
	public function getBlogCats(){
		
			$co = new Config;
			$pkg = Package::getByHandle('user_blogs');
			$co->setPackageObject($pkg);
			$share_attribute = $co->get("USER_BLOG_SHARE_ATTRIBUTE");
			$db = Loader::db();
			$akID = $db->query("SELECT akID FROM AttributeKeys WHERE akHandle = '{$share_attribute}'");
			while($row=$akID->fetchrow()){
				$akIDc = $row['akID'];
			}
			$akv = $db->execute("SELECT value FROM atSelectOptions WHERE akID = $akIDc");
			while($row=$akv->fetchrow()){
				$values[]=$row;
			}
			if (empty($values)){
				$values = array();
			}
			return $values;
		}

}