<?php 
Loader::model('anonymous_user','discussion');
Loader::model('page_list');
class DiscussionModel extends Page {

	const ATTRIBUTE_DISCUSSION_IS_POST_PINNED = "discussion_post_is_pinned";
	const ATTRIBUTE_DISCUSSION_ALLOWS_RATING = "discussion_post_allows_rating";
	const ATTRIBUTE_DISCUSSION_POST_RATING = "discussion_post_rating";


	public function load($obj) {
		if ($obj instanceof Page) {
			$dm = DiscussionModel::getByID($obj->getCollectionID(), $obj->getVersionID());
			if ($dm->getError() != COLLECTION_NOT_FOUND) {
				return $dm;
			}
		}
	}


	public static function getByID($cID, $cvID = 'ACTIVE') {
		$where = "where Pages.cID = ?";
		$c = new DiscussionModel;
		$c->populatePage($cID, $where, $cvID);
		$c->setSummaryData();
		return $c;
	}


	public function setSummaryData() {
		$db = Loader::db();
		$row = $db->GetRow("select totalViews, lastPostCID, totalTopics, totalPosts, lastPostCID from DiscussionSummary where cID = ?", array($this->getCollectionID()));

		$this->setTotalViews($row['totalViews']);
		$this->setTotalTopics($row['totalTopics']);
		$this->setTotalPosts($row['totalPosts']);
		$this->setLastPostCollectionID($row['lastPostCID']);
	}

	/*
	 // not used any longer since we added the discussion topics block but i'm keeping it around for a little while

 	public function getTopics($startDate, $endDate, $sortBy) {
 		Loader::model('discussion_topic_list', 'discussion');
 		$dtp = new DiscussionTopicList();
 		$dtp->filterByParentID($this->getCollectionID());
 		if ($startDate != false) {
 			$dtp->filter('cvDatePublic', $startDate . ' 00:00:00', '>=');
 		}
 		if ($endDate != false) {
 			$dtp->filter('cvDatePublic', $endDate . ' 23:59:59', '<=');
 		}
 		switch($sortBy) {
 			case 'most_recent_topic':
 				$dtp->sortBy('cvDatePublic', 'desc');
 				break;
 			case 'unanswered':
 				$dtp->sortByMultiple('totalPosts asc', 'cvDatePublic asc');
 				break;
 			default: // most recent post
 				$dtp->sortBy('cvDatePublicLastPost', 'desc');
 				break;
 		}
 		return $dtp;
 	}

	*/

	/**
	 * Adds a post to the system. Since this is a top level post it's the main "discussion" in a thread
	 * @todo - probably add the ability to specify the user ID, etc...
	 */
	public function addPost($subject, $message, $attachments = array(), $doTrack = false) {
		Loader::model('discussion_post', 'discussion');
		Loader::model('collection_types');
		$n1 = Loader::helper("text");
		$postType = CollectionType::getByHandle('discussion_post');

		$messageDescription = $n1->shortText($message);
		$data = array('cName' => $subject, 'cDescription' => $messageDescription);

		$n = $this->add($postType, $data);
		// also add message to main content area
		$b1 = BlockType::getByHandle('bbcode');
		$n->addBlock($b1, "Main", array('content' => $message));
		// add attachments if they're there
		foreach($attachments as $nb) {
			$data = array();
			$data['fileLinkText'] = $nb->getFilename();
			$data['fID'] = $nb->getFileID();
			$b2 = BlockType::getByHandle('file');
			$n->addBlock($b2, 'Attachments', $data);
		}

		$dpm = DiscussionPostModel::getByID($n->getCollectionID(), 'ACTIVE');
		$moderated = $dpm->setModeration();

		Loader::model('discussion_track', 'discussion');
		$u = new User();
		if($u->getUserID() <=0) {
			$u = new AnonymousUser();
		}
		if(!$moderated) {
			// discussion tracking
			$dTrack = new DiscussionTrack($this);
			$dTrack->setUrl(Loader::helper('navigation')->getCollectionURL($dpm));
			$dTrack->discussionHasChanged($u->getUserID(), $subject, $dpm->getPlainTextBody(), $dpm->getCollectionName(), $dpm);
		}

		$newTrack = new DiscussionTrack($dpm);
		if ($doTrack) {
			$newTrack->addTrack($u->getUserID());
		} else {
			$newTrack->removeTrack($u->getUserID());
		}

		return $dpm;
	}

	/**
	 * Records the discussion as having been views
	 */
	public function recordView() {
		$db = Loader::db();
		$db->Replace('DiscussionSummary', array('cID' => $this->getCollectionID(), 'totalViews' => 'totalViews + 1'), 'cID', false);
	}

	public function incrementTotalPosts($num = 1) {
		$db = Loader::db();
		$db->Replace('DiscussionSummary', array('cID' => $this->getCollectionID(), 'totalPosts' => 'totalPosts + ' . $num), 'cID', false);
	}

	public function incrementTotalTopics($num = 1) {
		$db = Loader::db();
		$db->Replace('DiscussionSummary', array('cID' => $this->getCollectionID(), 'totalTopics' => 'totalTopics + ' . $num), 'cID', false);
	}

	public function decrementTotalPosts($num = 1) {
		$db = Loader::db();
		$db->Replace('DiscussionSummary', array('cID' => $this->getCollectionID(), 'totalPosts' => 'totalPosts - ' . $num), 'cID', false);
	}

	public function decrementTotalTopics($num = 1) {
		$db = Loader::db();
		$db->Replace('DiscussionSummary', array('cID' => $this->getCollectionID(), 'totalTopics' => 'totalTopics - '  . $num), 'cID', false);
	}

	public function updateLastPost($dpm) {
		if(!$dpm->getAttribute('discussion_post_not_displayed')) {
			$db = Loader::db();
			$db->Replace('DiscussionSummary', array('cID' => $this->getCollectionID(), 'lastPostCID' => $dpm->getCollectionID()), 'cID', false);
		}
	}

	protected function setTotalViews($totalViews) {$this->totalViews = $totalViews;}
	protected function setTotalTopics($totalTopics) {$this->totalTopics = $totalTopics;}
	protected function setTotalPosts($totalPosts) {$this->totalPosts = $totalPosts;}
	protected function setLastPostCollectionID($lastPostCID) {$this->lastPostCID = $lastPostCID;}

	public function getTotalViews() {return $this->totalViews;}
	public function getTotalTopics() {return $this->totalTopics;}
	public function getTotalPosts() {return $this->totalPosts;}
	public function getLastPost() {
		if ($this->lastPostCID == 0) {
			return false;
		}

		$dpm = DiscussionPostModel::getByID($this->lastPostCID);

		if (!$dpm->isError()) {
			return $dpm;
		}
	}

	public function getNewSummaryData($cID = NULL, $data = NULL) {
		$db = Loader::db();

		if(!isset($cID)) {
			$cID = $this->getCollectionID();
			$top = true;
			$postType =  'discussion';
		} else {
			$top = false;
			$postType = 'discussion_post';
		}
		if(!isset($data)) {
			$data = array('totalTopics'=>0,'totalPosts'=>0,'lastPostCID'=>0, 'lastPostTime'=>0);
		}

		$query = "SELECT Pages.cID, cDateAdded
			FROM Pages
			INNER JOIN Collections c on c.cID = Pages.cID
			INNER JOIN CollectionVersions cv ON (Pages.cID = cv.cID and cv.cvIsApproved = 1)
			INNER JOIN PageTypes on Pages.ctID = PageTypes.ctID
			WHERE PageTypes.ctHandle = ? AND Pages.cParentID = ? ORDER BY cDateAdded";
		if (version_compare(APP_VERSION, '5.5.2.2','gt')) {
			// Rewrite the entire query rather than a simple substitution to allow further muting if needed.
			$query = "SELECT Pages.cID, cDateAdded
				FROM Pages
				INNER JOIN Collections c on c.cID = Pages.cID
				INNER JOIN CollectionVersions cv ON (Pages.cID = cv.cID and cv.cvIsApproved = 1)
				INNER JOIN PageTypes on CollectionVersions.ctID = PageTypes.ctID
				WHERE PageTypes.ctHandle = ? AND Pages.cParentID = ? ORDER BY cDateAdded";
		}
		// get
		$children = $db->getAll($query, array($postType, $cID));

		if($top) {
			$data['totalTopics'] = count($children);
		}


		if(is_array($children) && count($children)) {

			foreach($children as $post) {
				$data['totalPosts']++;

				if(strtotime($post['cDateAdded']) > strtotime($data['lastPostTime'])) {
					$data['lastPostTime'] = $post['cDateAdded'];
					$data['lastPostCID'] = $post['cID'];
				}
				$data = $this->getNewSummaryData($post['cID'], $data);
			}
		}
		return $data;
	}
}
