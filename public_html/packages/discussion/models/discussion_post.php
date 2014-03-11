<?php 
Loader::model('discussion_badge', 'discussion');
Loader::model('anonymous_user','discussion');

class DiscussionPostModel extends Page {

	protected $body = false;
	protected $userinfo = false;
	protected $replies = array();
	protected $postID = NULL;
	protected $discussionID = NULL;
	protected $itemsPerPage = 20;
	protected $deleteFor = 10;

	/**
	 * @param Page $obj
	 * @return DiscussionPostModel
	 */
	public function load($obj) {
		if ($obj instanceof Page) {
			$dpm = DiscussionPostModel::getByID($obj->getCollectionID(), $obj->getVersionID());
			if ($dpm->getError() != COLLECTION_NOT_FOUND) {
				return $dpm;
			}
		}
	}

	public function canDelete() {
		$p = new Permissions($this);
		if ($p->canAdminPage()) {
			return true;
		}

		$u = new User();
		$canDelete = false;
		Loader::library('datetime_compat', 'discussion');

		if($u->isRegistered() && $u->getUserID() == $this->getCollectionUserID()) {
			$dt_added = new DateTime($this->getCollectionDateAdded());
			$dt_now = new DateTime();
			$diff = $dt_now->format('U') - $dt_added->format('U');
			if(floor($diff/60) <= $this->deleteFor) {
				$canDelete = true;
			}
		}

		return $canDelete;
	}

	public function canEdit() {
		$p = new Permissions($this);
		if ($p->canWrite()) {
			return true;
		}
		$u = new User();
		$post_ui = $this->getUserObject();
		if($u->isRegistered() && $u->getUserID() == $post_ui->getUserID()) {
			return true;
		} else {
			return false;
		}
	}

	public function getContentBlockTypeHandle() {return 'bbcode';}

	public function getTotalPages() {
		return floor($this->getTotalReplies() / $this->itemsPerPage) + 1;
	}

	public function edit( $subject, $message, $attachments = array(), $retainAttachmentBIDs=array(), $doTrack = false) {
		$n1 = Loader::helper('text');
		$pendingCollectionData['cName'] = $subject;
		$pendingCollectionData['cDescription'] = $n1->shortText($message);
		$this->update($pendingCollectionData);
		//delete previous content blocks
		$a = new Area('Main');
		$ab = $a->getAreaBlocksArray($this);
		foreach($ab as $b){
			if( $b->getBlockTypeHandle()!=$this->getContentBlockTypeHandle() ) continue;
			$b->deleteBlock();
		}
		//add the new content block
		$bt = BlockType::getByHandle( $this->getContentBlockTypeHandle() );
		$data = array();
		$data['content'] = 	$message;
		$nb = $this->addBlock( $bt, 'Main', $data);

		//delete attachment blocks that have been marked for removal
		if(!is_array($retainAttachmentBIDs)) $retainAttachmentBIDs=array();
		if( !in_array('ALL',$retainAttachmentBIDs) ){
			$a = new Area('Attachments');
			$ab = $a->getAreaBlocksArray($this);
			foreach($ab as $b){
				if($b->getBlockTypeHandle()!='file' || in_array($b->getBlockID(),$retainAttachmentBIDs)) continue;
				$b->deleteBlock();
			}
		}
		// add new attachments if they're there
		foreach($attachments as $nb) {
			$data = array();
			$data['fileLinkText'] = $nb->getFilename();
			$data['fID'] = $nb->getFileID();
			$b2 = BlockType::getByHandle('file');
			$this->addBlock($b2, 'Attachments', $data);
		}

		Loader::model('discussion_track', 'discussion');
		$post = $this->getPost();
		$newTrack = new DiscussionTrack($post);
		$u = new User();



		if ($doTrack) {
			$newTrack->addTrack($u->getUserID());
		} else {
			$newTrack->removeTrack($u->getUserID());
		}

		$this->vObj->approve();
		return $this;
	}

	public function getTotalReplies() {
		return $this->totalReplies;
	}

	public function getSubject() { return $this->getCollectionName(); }

	public function getShortBody() {
		$content = $this->getCollectionDescription();
		Loader::library('3rdparty/bbcode');
		$bb = new Simple_BB_Code();
		return BbcodeBlockController::addEmoticons( $bb->parse($content) );
	}

	public function getBody() {
		$content = "";
		$a = new Area("Main");
		$areaBlocks = $a->getAreaBlocksArray($this);
		if(is_array($areaBlocks) && count($areaBlocks)) {
			foreach($areaBlocks as $b) {
				if($b->getBlockTypeHandle() == $this->getContentBlockTypeHandle()) {
					$bi = $b->getInstance();
					$content .= $bi->getHTMLContent();
				}
			}
		}
		return $content;
	}

	public function getPlainTextBody() {
		$body = $this->getBody();
		return strip_tags($body);
	}

	public function getHTMLBody() {
		$content = "";
		$a = new Area("Main");
		$areaBlocks = $a->getAreaBlocksArray($this);
		if(is_array($areaBlocks) && count($areaBlocks)) {
			foreach($areaBlocks as $b) {
				if($b->getBlockTypeHandle() == $this->getContentBlockTypeHandle()) {
					$bi = $b->getInstance();
					$content .= $bi->getHTMLContent();
				} else {
					$bi = $b->getInstance();
					$content .= $bi->getContent();
				}
			}
		}
		return $content;
	}

	public function getLatestReply() {
		$db = Loader::db();
		$lastPostCID = $db->GetOne('select lastPostCID from DiscussionSummary where cID = ?', $this->cID);
		if ($lastPostCID == 0) {
			return false;
		}
		$dpm = DiscussionPostModel::getByID($lastPostCID);
		if (!$dpm->isError()) {
			return $dpm;
		}
	}


	public function getReplyLevel() {return $this->replyLevel;}
	public function isPostPinned() { return $this->getAttribute(DiscussionModel::ATTRIBUTE_DISCUSSION_IS_POST_PINNED); }
	/*
	public function isDiscussionRated() { return $this->getAttribute(DiscussionModel::ATTRIBUTE_DISCUSSION_ALLOWS_RATING); }
	public function isDiscussionPostRated() { return $this->getAttribute(DiscussionModel::ATTRIBUTE_DISCUSSION_POST_RATING); }
	*/

	public static function compareReplies($a, $b) {
		$ta = strtotime($a->getCollectionDatePublic());
		$tb = strtotime($b->getCollectionDatePublic());
		if ($ta == $tb) {
			return 0;
		} else if ($ta > $tb) {
			return 1;
		} else {
			return -1;
		}
	}

	public function getThreadedReplies() {
		if (count($this->replies) == 0) {
			$this->populateThreadedReplies();
		}
		return $this->replies;
	}

	/**
	 * Returns a flat list of posts. This includes the topic as the first post in the list
	 */
	public function getFlatList($page, $perPage = false) {
		if (count($this->replies) == 0) {
			$this->populateThreadedReplies();
		}

		array_unshift($this->replies, $this);
		usort($this->replies, array('DiscussionPostModel', 'compareReplies'));
		/*
		foreach($this->replies as $p) {
			print $p->getCollectionDateAdded() . ':' . $p->getSubject() . '<br>';
		}
		*/

		$il = new ItemList();
		if ($perPage == false) {
			$perPage = $this->itemsPerPage;
		}
		$il->setItemsPerPage($perPage);
		$il->setItems($this->replies);
		return $il;
	}

	// replies are always of the type DiscussionPostModel::CTHANDLE
	public function addPostReply($subject, $message, $attachments = array(), $doTrack = false, $user = false) {
		if ($user == false) {
			$user = new User();
		}
		if ($this->canBePostedToBy($user)) {
			Loader::model('discussion_post', 'discussion');
			Loader::model('collection_types');
			$n1 = Loader::helper('text');

			$postType = CollectionType::getByHandle('discussion_post'); // replies are always discussion posts

			$messageDescription = $n1->shortText($message);

			$data = array('cName' => $subject, 'cDescription' => $messageDescription, 'uID' => $user->getUserID());
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
			$post = $dpm->getPost();
			$newTrack = new DiscussionTrack($post);
			// tracks replies to this actual reply
			//$newTrack = new DiscussionTrack($dpm);
			if ($doTrack) {
				$newTrack->addTrack($user->getUserID());
			} else {
				$newTrack->removeTrack($user->getUserID());
			}



			$nh = Loader::helper('navigation');
			$postLink = $nh->getCollectionURL($post)."#".$dpm->getCollectionID();
			// do the tracks both the forum and the post
			$posted_title = $dpm->getSubject();
			$posted_body = $dpm->getPlainTextBody();
			$d = $dpm->getDiscussion();

			if( !$moderated/*!$dpm->getAttribute('discussion_post_not_displayed')*/) { //for some reason the post can come back moderated = true but the attribute is still null.
				//$dTrack = new DiscussionTrack($this);
				$dTrack = new DiscussionTrack($post);
				$dTrack->setUrl($postLink);
				$dTrack->discussionHasChanged($user->getUserID(), $posted_title, $posted_body, $post->getCollectionName(), $dpm);

				// track the post for the top level forum, if it's not in edit mode.
				if (is_object($d)) {
					$topdTrack = new DiscussionTrack($d);
					$topdTrack->setUrl($postLink);
					$topdTrack->discussionHasChanged($user->getUserID(), $posted_title, $posted_body, $post->getCollectionName(), $dpm);
				}
			}

			return $dpm;
		}
	}

	protected function canBePostedToBy($u) {
		if (!$u->isRegistered()) {

			$d = $this->getDiscussion();
         $dc = Loader::helper('discussion_config','discussion');
         $anonReplies = $dc->anonPostRepliesEnabled($d);

			if(!$anonReplies) {
				return false;
			}
		}
		return true;
	}

	public function getUserName() {
		if (is_object($this->userinfo)) {
			return  $this->userinfo->getUserName();
		} else {
			return AnonymousUser::getUserName();
		}
	}
	public function getUserObject() {
		if (is_object($this->userinfo)) {
			return  $this->userinfo;
		} else {
			return new AnonymousUserInfo();
		}
	}

	protected function setUser($uID) {
		$this->userinfo = UserInfo::getByID($uID);
	}

	public function getTotalViews() {return $this->totalViews;}
	public function setTotalViews($num) {$this->totalViews = $num;}

	/**
	 * Returns all replies to a given topic
	 * @todo: paging?
	 */
	public function populateThreadedReplies($level = 0, $cID = 0) {
		if ($this->getNumChildren() == 0) {
			return;
		}
		if ($cID == 0) {
			$cID = $this->getCollectionID();
		}
		$db = Loader::db();

		$v = array($cID, 'discussion_post');
		$query = "SELECT Pages.cID FROM
			Pages INNER JOIN Collections ON Pages.cID = Collections.cID
			INNER JOIN CollectionVersions ON CollectionVersions.cID = Pages.cID
			INNER JOIN PageTypes ON Pages.ctID = PageTypes.ctID
			WHERE CollectionVersions.cvIsApproved = 1
			AND cParentID = ? AND ctHandle = ? ORDER BY cDateAdded asc";
		if (version_compare(APP_VERSION, '5.5.2.2','gt')) {
			// Rewrite the entire query rather than a simple substitution to allow further muting if needed.
			$query = "SELECT Pages.cID FROM
				Pages INNER JOIN Collections ON Pages.cID = Collections.cID
				INNER JOIN CollectionVersions ON CollectionVersions.cID = Pages.cID
				INNER JOIN PageTypes ON CollectionVersions.ctID = PageTypes.ctID
				WHERE CollectionVersions.cvIsApproved = 1
				AND cParentID = ? AND ctHandle = ? ORDER BY cDateAdded asc";
		}

		$r = $db->Execute($query, $v);
		while ($row = $r->fetchRow()) {
			$dpm = DiscussionPostModel::getByID($row['cID']);
			$cp = new Permissions($dpm);
			if($cp->canRead()) {
				$dpm->setReplyLevel($level);
				$this->replies[] = $dpm;
				$this->populateThreadedReplies($level + 1, $row['cID']);
			} else {
				$this->totalReplies--;
			}
		}
	}

	/**
	 * @param int $cID
	 * @param mixed 'ACTIVE'|'RECENT'|$cvID
	 * @return DiscussionPostModel
	 */
	public static function getByID($cID, $cvID = 'ACTIVE') {
		$where = "where Pages.cID = ?";
		$c = new DiscussionPostModel;
		$c->populatePage($cID, $where, $cvID);
		$c->setUser($c->getCollectionUserID());

		$db = Loader::db();
		$row = $db->GetRow("select totalViews, totalPosts from DiscussionSummary where cID = ?", array($cID));
		$c->setTotalReplies($row['totalPosts']);
		$c->setTotalViews($row['totalViews']);

		return $c;
	}

	/**
	 * Goes up the tree until it finds the "discussion" this post lives under -- top level forum
	 */
	public function getDiscussion() {
		if(isset($this->discussionID)) {
			return DiscussionModel::getByID($this->discussionID);
		} else {
			$this->setParents();
			if ($this->discussionID > 0) {
				return DiscussionModel::getByID($this->discussionID);
			}
		}
	}

	/* makes the assumption that a post is the level immidiately below the discussion */
	public function getPost() {
		if(isset($this->postID)) {
			return DiscussionPostModel::getByID($this->postID);
		} else {
			$this->setParents();
			if ($this->postID > 0) {
				return DiscussionPostModel::getByID($this->postID);
			} else {
				return DiscussionPostModel::getByID($this->cParentID);
			}
		}
	}

	/* sets the parent discussion and top level post if it's a reply */
	protected function setParents() {

		// possible parents
		$possibleParents = array('discussion');
		$possiblePosts =  array('discussion_post');
		$db = Loader::db();
		$cParentID = $db->GetOne("select cParentID from Pages where cID = ?", array($this->getCollectionID()));
		$discussionID = 0;
		$postID = 0;
		$lastPostID = 0;
		$i = 0;
		while ($cParentID > 0) {
			if (version_compare(APP_VERSION, '5.5.2.2','gt')) {
				// Rewrite the entire query rather than a simple substitution to allow further muting if needed.
				$ctHandle = $db->GetOne("select ctHandle from Pages inner join CollectionVersions cv on Pages.cID = cv.cID inner join PageTypes on cv.ctID = PageTypes.ctID where Pages.cID = ? and cv.cvIsApproved = 1", array($cParentID));
			} else {
				$ctHandle = $db->GetOne("select ctHandle from Pages inner join PageTypes on Pages.ctID = PageTypes.ctID where Pages.cID = ?", array($cParentID));
			}
			//echo $ctHandle."<br>";
			if (in_array($ctHandle,$possibleParents)) { // issue or discussion
				$discussionID = $cParentID;
				$cParentID = 0;
				if($i==0) {
					$postID = $this->getCollectionID();
				} else {
					$postID = $lastPostID;
				}
			} elseif(in_array($ctHandle,$possiblePosts)) {
				$lastPostID = $cParentID;
			}
			$cParentID = $db->GetOne("select cParentID from Pages where cID = ?", array($cParentID));
			$i++;
		}
		if ($discussionID > 0) {
			$this->discussionID = $discussionID;
			$this->postID = $postID;
		}
	}

	// iterates through and modifies the count all the way up the tree.
	// also, if this discussion post is immediately below the discussion page, it increments the totalTopics num
	public function updateParentCounts($num, $updateSelf = false) {
		$db = Loader::db();
		$cParentID = $this->getCollectionParentID();
		if ($num > 0) {
			$totalTopicsNum = 'totalTopics +1';
			$num = '+' . $num;
		} else {
			$totalTopicsNum = 'totalTopics -1';
		}
		if ($updateSelf) {
			$db->Replace('DiscussionSummary', array('cID' => $this->getCollectionID(), 'totalPosts' => 'totalPosts ' . $num), 'cID', false);
		}
		$discussionID = 0;
		while ($cParentID > 0) {
			$db->Replace('DiscussionSummary', array('cID' => $cParentID, 'totalPosts' => 'totalPosts ' . $num, 'lastPostCID' => $this->getCollectionID()), 'cID', false);
			if (version_compare(APP_VERSION, '5.5.2.2','gt')) {
				// Rewrite the entire query rather than a simple substitution to allow further muting if needed.
				$ctHandle = $db->GetOne("select ctHandle from Pages inner join CollectionVersions cv on Pages.cID = cv.cID inner join PageTypes on cv.ctID = PageTypes.ctID where Pages.cID = ? and cv.cvIsApproved = 1", array($cParentID));
			} else {
				$ctHandle = $db->GetOne("select ctHandle from Pages inner join PageTypes on Pages.ctID = PageTypes.ctID where Pages.cID = ?", array($cParentID));
			}
			if ($ctHandle == 'discussion') {
				$discussionID = $cParentID;
				$cParentID = 0;
			}
			$cParentID = $db->GetOne("select cParentID from Pages where cID = ?", array($cParentID));
		}

		// this is convoluted. In theory if we ever call this with updateSelf == true then we don't want
		// to run the code below, because it's operating on a parent collection that this doesn't really apply to
		if (!$updateSelf) {
			if ($discussionID > 0 && $discussionID == $this->getCollectionParentID()) {
				$db->Replace('DiscussionSummary', array('cID' => $discussionID, 'totalTopics' => $totalTopicsNum), 'cID', false);
			}
		}

		return $discussionID; // return the parent discussion
	}

	protected function setTotalReplies($totalPosts) {$this->totalReplies = $totalPosts;}
	public function setReplyLevel($level) {$this->replyLevel = $level;}




	public function getNewSummaryData($cID = NULL, $data = NULL) {
		$db = Loader::db();

		if(!isset($cID)) {
			$cID = $this->getCollectionID();
			$top = true;
		} else {
			$top = false;
		}

		if(!isset($data)) {
			$data = array('totalPosts'=>0, 'lastPostCID'=>0, 'lastPostTime'=>0);
		}

		$query = "SELECT Pages.cID, cDateAdded
			FROM Pages
			INNER JOIN Collections c on c.cID = Pages.cID
			INNER JOIN CollectionVersions cv ON (Pages.cID = cv.cID and cv.cvIsApproved = 1)
			INNER JOIN PageTypes on Pages.ctID = PageTypes.ctID
			WHERE PageTypes.ctHandle = ? AND Pages.cParentID = ? ORDER BY cDateAdded";
		// get

		$children = $db->getAll($query, array('discussion_post', $cID));

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


	public function recordView() {
		$db = Loader::db();
		$db->Replace('DiscussionSummary', array('cID' => $this->getCollectionID(), 'totalViews' => 'totalViews + 1'), 'cID', false);
	}


	/**
	 * Sets the moderation flags based on config + user object
	 * @return NULL
	 */
	public function setModeration() {
		if($this->shouldModerate()) {
			$this->setAttribute('discussion_post_not_displayed',1);
			$cv = $this->getVersionObject();
			$cv->deny();
			//$this->decrementCounts();
			$moderation = true;
			$this->sendModerationEmail();
			$pkg = Package::getByHandle('discussion');
			$pkg->saveConfig('MODERATION_NEW_MESSAGES', 1);

		} else {
			$moderation = false;
		}
		return $moderation;
	}

	public function sendModerationEmail() {
		$pkg = Package::getByHandle('discussion');
		// if we've got an email address and there weren't any new messages before this post.
		if(strlen(trim($pkg->config('MODERATOR_EMAIL'))) && $pkg->config('MODERATION_NEW_MESSAGES') == 0) {
			$url = BASE_URL . DIR_REL . '/' . DISPATCHER_FILENAME.'/dashboard/discussion/moderation/';
			$mh = Loader::helper('mail');
			$mh->to($pkg->config('MODERATOR_EMAIL'));
			$mh->addParameter('link', $url);
			$mh->load('moderation_required', 'discussion');
			$mh->sendMail();
		}
	}

	public function shouldModerate() {
		$ui = $this->getUserObject();
		// allow for editing by a privileged logged in user
		$lu = new User();
		if($lu->getUserID() != $ui->getUserID()) {
			$u = $lu;
		} else {
			$u = $ui->getUserObject();
		}
		$moderate = false;
		// admin or special skip mod group

		$g_admin = Group::getByName('Administrators');
		$g_nm = Group::getByName('No_Moderation');
		if($u->isSuperUser()) {
			return false;
		}
		if(is_object($g_admin) && $u->inGroup($g_admin)) {
			return false;
		}
		if(is_object($g_nm) && $u->inGroup($g_nm)) {
			return false;
		}

		$d = $this->getDiscussion();
		$dc = Loader::helper('discussion_config','discussion');
		$moderationType = $dc->getModerationType($d);

		if($moderationType != 'none') {
			// return if in groups that can skip moderation

			switch($moderationType) {
				case 'all':
					$moderate = true;
				break;
				case 'anon':
					if($u->getUserID() <= 0) {
						$moderate = true;
					}
				break;
				default:
					// default permissions
				break;
			}
		}
		return $moderate;
	}






	public function incrementCounts($userCounts=true) {
		$d = $this->getDiscussion();
		if (is_object($d)) {
			$d->updateLastPost($this);
			$this->updateParentCounts(1);
		}

		if($userCounts) {
			$ui = UserInfo::getByID($this->getCollectionUserID());
			if(is_object($ui) && $ui->getUserID() > 0) { // if we're not posting anonymously
				$num = $ui->getAttribute('discussion_total_posts');
				if ($num < 1) {
					$num = 0;
				}
				$num++;
				$ui->setAttribute('discussion_total_posts', $num);
			}
		}
	}

	public function decrementCounts($userCounts=true) {
		$numToDecrement = 1 + count($this->getCollectionChildrenArray());
		$d = $this->getDiscussion();
		if (is_object($d)) {
			//$d->updateLastPost($this); // DO SOMETHING ELSE
			$this->updateParentCounts((-1*$numToDecrement));
		}

		if($userCounts) {
			$ui = UserInfo::getByID($this->getCollectionUserID());
			if(is_object($ui) && $ui->getUserID() > 0) { // if we're not posting anonymously
				$num = $ui->getAttribute('discussion_total_posts');
				$num = $num - $numToDecrement;
				if ($num < 1) {
					$num = 0;
				}
				$ui->setAttribute('discussion_total_posts', $num);
			}
		}
	}



	/**
	 * Sets the post locale from the user's session only if it's different than the site locale as defined in ACTIVE_LOCALE
	 * @param string $locale default will use $locale from session
	 * @return boolean
	 */
	public function setPostLocale($locale = NULL) {
		if(Loader::helper('discussion_config','discussion')->isMultilingualEnabled()) {
			if(isset($locale) && strlen($locale)) {
				$currentLocale = $locale;
			} else {
				$currentLocale = Loader::helper('default_language','multilingual')->getSessionDefaultLocale();
			}
			$multPkg = Package::getByHandle('multilingual');
			$defaultLocale = $multPkg->config('DEFAULT_LANGUAGE');
			if(!strlen($defaultLocale)) {
				$defaultLocale = ACTIVE_LOCALE;
			}

			if($defaultLocale != $currentLocale) {
				$this->setAttribute('discussion_post_locale', $currentLocale);
				return true;
			}
		}
		return false;
	}
}
