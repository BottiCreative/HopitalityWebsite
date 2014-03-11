<?php  
defined('C5_EXECUTE') or die(_("Access Denied.")); 

class DiscussionBadge {

	private $g;
	public $badgeID;
	public $badgeDescription;

	const WIDTH = 35;
	const HEIGHT = 35;
	const CACHE_LIFETIME_TOTAL_POSTS = 180; // 3 minutes

	
	public function getAvailableBadges(){
		$db = Loader::db();
		$badgeObjs=array();
		$gIDs = $db->getCol("SELECT dg.giD FROM DiscussionGroupBadges dg, Groups g WHERE  dg.gID = g.gID ORDER BY g.gName");
		foreach($gIDs as $gID) {
			$badgeObjs[]=new DiscussionBadge($gID);
		}
		return $badgeObjs;
	}
	
	public function getBadges($u) {
		$badges = array();
		$groups = $u->getUserGroups();
		$badgeGroups=DiscussionBadge::getAvailableBadges(); 
		$badgeGroupNames=array();
		foreach($badgeGroups as $badgeGroup)
			$badgeGroupNames[]=$badgeGroup->getBadgeName(); 
		if(is_array($groups) && count($groups)) {
			foreach($groups as $g) {
				if(in_array( $g, $badgeGroupNames)) {
					$badges[] = new DiscussionBadge($g, $u);
				}
			}
		}
		return $badges;
	}
	
	
	public function getBadgesHTML($u,$withManageLink=0) {
		$badgesHTML = "";
		$badges = DiscussionBadge::getBadges($u);
		foreach($badges as $badge) {
			if( !strlen($badge->getBadgeName()) ) continue;
        	$badgesHTML .= $badge->getBadgeIcon(); 
		} 
		
		if( DiscussionBadge::canAdminBadges() && $withManageLink ){
			$manageURL=View::url( Loader::helper('concrete/urls')->getToolsURL('manage_badges', 'discussion') . '?uID=' . $u->getUserID());
			$badgesHTML.='<div style="padding-top:8px; ">'.
						 '<a href="#" onclick="return ccmDiscussionBadges.manage(\''.$manageURL.'\')">'.t('Manage Badges').'</a></div>';
		}
		
		return $badgesHTML;
	}
	
	public function setDateBadgeAwarded($date) {
		$this->dateAwarded = $date;
	}
	
	public function getDateBadgeAwarded() {
		return $this->dateAwarded;
	}

	public function canAdminBadges(){ 
		$u=new User();
		if($u->isSuperUser()) {
			$canAdmin = true;
		} else {
			$g = Group::getByID(3);
			if($u->inGroup($g))	$canAdmin = true;
		}	
		return ($canAdmin)?1:0;
	}
	
	public function __construct($groupIdentifier, $uo = false) {
		$db = Loader::db();
		if(is_numeric($groupIdentifier)) {
			$this->g = Group::getByID($groupIdentifier);
		} else {
			$this->g = Group::getByName($groupIdentifier);
		}
			
		$data = $db->getRow("SELECT badgeID, description FROM DiscussionGroupBadges WHERE gID = ?", array($this->g->getGroupID()));
		if(is_array($data)) {
			$this->badgeID = $data['badgeID'];
			$this->badgeDescription = $data['description'];
			if (is_object($uo)) {
				$ugEntered = $db->GetOne('select ugEntered from UserGroups where uID = ? and gID = ?', array($uo->getUserID(), $this->g->getGroupID()));
				$this->dateAwarded = $ugEntered;
			}
		}
	}
	
	public function getBadgeGroupID() {
		return $this->g->getGroupID();
	}
	
	/* ads any groups that are in the badgeGroups array if they don't exist, saves us running to the admin when we get new ones */
	public function addBadge($gName, $badgeDescription, $img) {
		$db = Loader::db();
		$gID = $db->getOne("SELECT gID FROM Groups WHERE gName = ?",array($gName)); 
		if(!$gID) {
			$g = Group::add($gName,$badgeDescription);
		} else {
			$g = Group::getByID($gID);
		}
		
		$db->query("REPLACE INTO DiscussionGroupBadges (gID, description) VALUES (?,?)", array($g->getGroupID(),$badgeDescription));
		if(DiscussionBadge::processUploadedBadge($img, $g->getGroupID()) ) {
			return true;
		} else {
			return false;
		}
		
	}

	public function editBadge($gID, $badgeDescription, $img) {
		$db = Loader::db();
		if($gID) {
			$g = Group::getByID($gID);
		}
		
		$db->query("REPLACE INTO DiscussionGroupBadges (gID, description) VALUES (?,?)", array($g->getGroupID(),$badgeDescription));
		if(is_uploaded_file($img) ) {
			DiscussionBadge::processUploadedBadge($img, $g->getGroupID());
		}
	}

	public function deleteBadge($gID) {
		$db = Loader::db();
		$db->query("DELETE FROM DiscussionGroupBadges WHERE gID = ?",array($gID));
		@unlink(DIR_FILES_UPLOADED . '/badges' . '/' . $gID . '.png');
	}
	
	public function getBadgePath($extension = NULL) {
		if(!isset($extension)) {
			$extension = ".png";
		}
		return REL_DIR_FILES_UPLOADED."/badges/".$this->g->getGroupID().$extension;
	}
	
	public function getBadgeName() {
		return $this->g->getGroupName();
	}
	
	public function getBadgeDescription() {
		return $this->badgeDescription;
	}
	
	public function getBadgeIcon($alt="", $extra="") {
		if(!strlen($alt)) {
			$alt = $this->getBadgeDescription();
		}
		return '<img src="'.$this->getBadgePath().'" title="'.$alt.'" alt="'.$alt.'" width="'.DiscussionBadge::WIDTH.'" height="'.DiscussionBadge::HEIGHT.'" '.$extra.' />';
	}
	
	function processUploadedBadge($pointer, $gID) {
		if(!is_dir(DIR_FILES_UPLOADED . '/badges')) {
			mkdir(DIR_FILES_UPLOADED . '/badges');
		}
		$np = DIR_FILES_UPLOADED . '/badges/' . $gID . '.png';
		$im = Loader::helper('image');
		$im->create($pointer, $np, DiscussionBadge::WIDTH, DiscussionBadge::HEIGHT);
		return file_exists($np);		
	}	
}