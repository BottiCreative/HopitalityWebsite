<?php 
Loader::model('discussion_post', 'discussion');

class DiscussionTrack {
	
	public $c;
	public $sendOnce = false; // set to true if only one notification is sent between views
	public $url = NULL; // set if you want a link other than the collection beeing tracked
	protected $thread_title='';
	
	
	function __construct($c) {
		$this->c = $c;
	}
	
	function addTrack($uID,$hasViewed=1) {
		$db = Loader::db();
		$v = array($this->c->getCollectionID(),$uID,$hasViewed);
		$res = $db->query("REPLACE INTO DiscussionTrack (cID, uID, hasViewed) VALUES (?,?,?)",$v);
		if(!$res) {
			die($res->getDebugInfo());
		} else {
			return true;
		}
	}
	
	function removeTrack($uID) {
		$db = Loader::db();
		$v = array($this->c->getCollectionID(),$uID);
		$res = $db->query("DELETE FROM DiscussionTrack WHERE cID = ? AND uID = ?",$v);
		if(!$res) {
			die($res->getDebugInfo());
		} else {
			return true;
		}
	}
	
	public function removeAllTracks() {
		$db = Loader::db();
		$v = array($this->c->getCollectionID());
		$res = $db->query("DELETE FROM DiscussionTrack WHERE cID = ?",$v);
		if(!$res) {
			die($res->getDebugInfo());
		} else {
			return true;
		}
	}
	
	
	function userIsTracking($uID) {
		$db = Loader::db();
		$v = array($this->c->getCollectionID(),$uID);
		$res = $db->getOne("SELECT tID FROM DiscussionTrack WHERE cID = ? AND uID = ?",$v);
		if(is_numeric($res) && $res > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function userView($uID) {
		$db = Loader::db();
		$v = array($this->c->getCollectionID(),$uID);
		$res = $db->query("UPDATE DiscussionTrack SET hasViewed = 1, notifySent = 0 WHERE cID = ? AND uID = ?",$v);
	}
	
	// omit the submitting user from notification
	function discussionHasChanged($poster_uID, $post_title="", $post_body="", $thread_title="", $newEntry = false) {
		$this->post_title = $post_title;
		$this->post_body = $post_body;
		$this->thread_title = $thread_title;
		
		$db = Loader::db();
		$v = array($this->c->getCollectionID(),$poster_uID);
		$res = $db->query("UPDATE DiscussionTrack SET hasViewed = 0 WHERE cID = ? AND uID != ?",$v);
		
		// optionally move this to a cron job for better preformance
		$tracking_uIDs = $this->getTrackingUserIDsToNotify();
		if(count($tracking_uIDs)) {
			foreach($tracking_uIDs as $uID) {
				if($uID != $poster_uID) {
					$this->notify($uID,$poster_uID, $newEntry);
				}
			}
		}
		return true;
	}
	
	protected function notify($uID, $poster_uID = NULL, $newEntry = false) {
		$db = Loader::db();
		$nh = Loader::helper('navigation');
		Loader::helper('mail');
		
		$u = User::getByUserID($uID);
		$ui = UserInfo::getByID($uID);
		if($poster_uID) {
			$posting_u = User::getByUserID($poster_uID);
			$posting_ui = UserInfo::getByID($poster_uID);
		} else {
			Loader::model('anonymous_user','discussion');
			$posting_u = new AnonymousUser();
			$posting_ui = new AnonymousUserInfo();
		}

		$cp = new Permissions($this->c);

		if ($cp->canRead()){
			$mh = new MailHelper();		
			if(isset($this->url) && strlen($this->url)) {
				$mh->addParameter('link', $this->url);
			} else {
				$mh->addParameter('link', $nh->getCollectionURL($this->c));
			} 
			
			//this is the forum title
			$mh->addParameter('title', $this->c->getCollectionName()); 
			$threadTitle=(strlen($this->thread_title))? $this->thread_title: $this->post_title;
			$mh->addParameter('thread_title', $threadTitle);		
			$mh->addParameter('post_title', $this->post_title);
			$mh->addParameter('post_body', $this->post_body);
			$mh->addParameter('name', $u->getUserName());
			$mh->addParameter('posterName', $posting_u->getUserName());
			$mh->addParameter('posterProfile', BASE_URL . View::url('/profile',$poster_uID));
			
			$mh->to($ui->getUserEmail());
			
			$mh->load('discussion_track', 'discussion');
			Loader::library("mail/importer");
			$mi = MailImporter::getByHandle("discussion_post_reply");
			if (is_object($mi) && is_object($newEntry) && $mi->isMailImporterEnabled()) {
				$data = new stdClass;
				$data->cID = $newEntry->getCollectionID();
				$data->toUID = $ui->getUserID();
				$mh->enableMailResponseProcessing($mi, $data);
			}
			$mh->sendMail();
			
			if($this->sendOnce) { // mark as sent so only one notification is sent
				$v = array($this->c->getCollectionID(),$uID);
				$db->query("UPDATE DiscussionTrack SET notifySent = 1 WHERE cID = ? AND uID = ?",$v);
			}
		} else {
			Log::addEntry('user '.$uID.' was not emailed');
			$this->removeTrack($uID);
		}

	}
	
	
	public static function getTrackedDiscussionCIDs($uID) {
		$db = Loader::db();
		$cIDs = $db->getCol("SELECT cID FROM DiscussionTrack WHERE uID = ?",0,array($uID));
		return $cIDs;
	}
	
	public function setUrl($url) {
		$this->url = $url;
	}
	
	public static function copyTrackedDiscussions($oldPage, $newPage) {
		$db = Loader::db();
		$r = $db->Execute('select * from DiscussionTrack where cID = ?', array($oldPage->getCollectionID()));
		while ($row = $r->FetchRow()) {
			$db->Execute('insert into DiscussionTrack (cID, uID) values (?, ?)', array($newPage->getCollectionID(), $row['uID']));
		}
	}
	
	function getTrackingUserIDsToNotify() {
		$db = Loader::db();
		$uIDs = $db->getCol("SELECT uID FROM DiscussionTrack WHERE notifySent = 0 AND hasViewed = 0 AND cID = ?",array($this->c->getCollectionID()));
		return $uIDs;
	}


} // end class def
?>
