<?php 
Loader::model('discussion_post', 'discussion');
Loader::model('discussion', 'discussion');
Loader::model('discussion_track', 'discussion');

class DiscussionPostPageTypeController extends Controller {

	public $helpers = array('form', 'html');
	private $dTrack;

	private function loadModel() {
		$this->post = DiscussionPostModel::load($this->getCollectionObject());
	}

	public function on_start() {
		$html = Loader::helper('html');
		$this->addHeaderItem($html->javascript('jquery.js'));
		$this->addHeaderItem($html->javascript('jquery.ui.js'));
		$this->addHeaderItem($html->css('ccm.calendar.css'));
		$this->addHeaderItem($html->css('jquery.ui.css'));
		$this->addHeaderItem($html->javascript('ccm.spellchecker.js'));
		$this->addHeaderItem($html->css('ccm.spellchecker.css'));
		$this->addHeaderItem($html->javascript('ccm.dialog.js'));
		$this->addHeaderItem($html->css('ccm.dialog.css'));
		$this->addHeaderItem($html->javascript('discussion.js', 'discussion'));
		$this->addHeaderItem($html->javascript('bootstrap.js'));

		$this->loadModel();
		$this->error = Loader::helper('validation/error');

		$u = new User();

		$this->set("u",$u);
		$this->dTrack = new DiscussionTrack($this->getCollectionObject());
		$this->set("dTrack",$this->dTrack);
		$this->set("closed",$this->isClosed());

		$this->setupDiscussionMode();

		$pkg = Package::getByHandle('discussion');
		if (!$this->canPost()) {
			$this->set('startDiscussionAction', 'location.href=\'' . View::url('/login', 'forward', $this->getCollectionObject()->getCollectionID()) . '\';');
		} else {
			if ($pkg->config('GLOBAL_POSTING_METHOD') == 'overlay') {
				$uID = $u->isRegistered() ? $u->getUserID() : 0;
				$this->set('startDiscussionAction', 'ccmDiscussion.postOverlay(' . $this->getCollectionObject()->getCollectionID() .', ' . $uID . ', \''
					.Loader::helper('concrete/urls')->getToolsURL('post_form','discussion').'\')');
			} else {
				$this->set('startDiscussionAction', 'ccmDiscussion.postForm(' . $this->getCollectionObject()->getCollectionID() .')');
            //Added the cID in there
			}
		}

		$d = $this->post->getDiscussion();
		// captcha, attachments or not
		$dc = Loader::helper('discussion_config','discussion');
		$this->set('captchaRequired',$dc->captchaRequired($d));
		$this->set('anonAttachments',$dc->anonPostAttachmentsEnabled($d));

		Loader::model('attribute/categories/collection');
		$tags = CollectionAttributeKey::getByHandle(DISCUSSION_POST_TAG_HANDLE);

		if($tags instanceof AttributeKey && $d instanceof Page) {
			$value = $d->getAttributeValueObject($tags);
			$this->set('tags',array('label'=>$tags->render('label',null,true),'form'=>$tags->render('form',null,true)));
		}
	}

	public function setupDiscussionMode() {
		$discussion = $this->post->getDiscussion();
		$pkg = Package::getByHandle('discussion');

		if ($pkg->config('GLOBAL_DISPLAY_MODE')) {
			$this->set('displayMode' , $pkg->config('GLOBAL_DISPLAY_MODE'));
		}
		if ($discussion && $discussion->getAttribute("discussion_mode") != '') {
			$this->set('displayMode' , strtolower($discussion->getAttribute("discussion_mode")));
		}

		$displayMode = $this->get('displayMode');
		if ($displayMode == '') {
			$this->set('displayMode' , 'flat');
		}

		if ($_REQUEST['cDiscussionDisplayMode'] == 'threaded') {
			$_SESSION['cDiscussionDisplayMode'] = 'threaded';
		} else if ($_REQUEST['cDiscussionDisplayMode'] == 'flat') {
			$_SESSION['cDiscussionDisplayMode'] = 'flat';
		}

		if (isset($_SESSION['cDiscussionDisplayMode'])) {
			$this->set('displayMode', $_SESSION['cDiscussionDisplayMode']);
		}

		$c = Page::getCurrentPage();
		$pm = DiscussionPostModel::getByID($c->getCollectionID());
		$this->set('av', Loader::helper('concrete/avatar'));
		$this->set('html', Loader::helper('html'));

		if($this->get('displayMode') =='threaded'){
			$messageList = $pm->getThreadedReplies();
			$this->set('replies', $messageList);
		} else {
			$messageList = $pm->getFlatList($this->get('discussion_p'));
		}
		$this->set('topic', $pm);
		$this->set('messageList', $messageList);
	}

	public function download() {
		$c = $this->getCollectionObject();
		$a = new Area("Attachments");
		$a->display($c);
		exit;
	}

	public function remove_track() {
		$this->theme = "none";
		$u = $this->getvar("u");
		$uID = $u->getUserID();
		$this->dTrack->removeTrack($uID);
		$this->set('trackRemoved', true);
	}

	public function do_track() {
		$this->theme = "none";
		$u = $this->getvar("u");
		$uID = $u->getUserID();
		$this->dTrack->addTrack($uID);
		$this->set('trackSuccess', true);
	}

	public function track() {
		$this->theme = "none";
	}

	public function delete_post() {
		if ($this->isPost() && $this->post->canDelete()) {
			$dpm = $this->post->getPost();
			if ($dpm->getCollectionID() == $this->post->getCollectionID()) {
				$dpm = Page::getByID($dpm->getCollectionParentID());
			}
			$this->post->delete();
			$this->redirect($dpm->getCollectionPath());
		}
	}

	/**
	 * Replies to a given discussion or reply
	 */
	public function reply() {
		if ($this->isPost() && $this->canPost()) {
			$v = Loader::helper('validation/strings');
			$vf = Loader::helper('validation/file');
			$pkg = Package::getByHandle('discussion');
			$dc = Loader::helper('discussion_config','discussion');

			$u = new User();

			// ip validation
			$ip = Loader::helper('validation/ip');
			if (!$ip->check()) {
				$this->error->add($ip->getErrorMessage());
			}

			$wordFilter = Loader::helper('validation/banned_words');
			if (!$v->notempty($this->post('subject'))) {
				$this->error->add(t('Your subject cannot be empty.'));
			}elseif($pkg->config('FILTER_BANNED_WORDS') == 1 && $wordFilter->hasBannedWords($this->post('subject'))) {
				$this->error->add(t('Your subject contains inappropriate content.'));
			}
			if (!$v->notempty($this->post('message'))) {
				$this->error->add(t('Your message cannot be empty.'));
			}elseif( $pkg->config('FILTER_BANNED_WORDS') == 1 && $wordFilter->hasBannedWords($this->post('message')) ){
				$this->error->add(t('Your message contains inappropriate content.'));
			}


			$d = $this->post->getDiscussion(); // discussion object used for captcha, attach checking
			// check captcha if activated
			if (!$u->isRegistered() && $dc->captchaRequired($d)) {
				$captcha = Loader::helper('validation/captcha');
				if (!$captcha->check()) {
					$this->error->add(t("Incorrect captcha code"));
				}
			}


			if ($u->isRegistered() || ($dc->anonPostAttachmentsEnabled($d) && $dc->anonPostRepliesEnabled($d))) {
				if (isset($_FILES['attachments']) && is_array($_FILES['attachments']['tmp_name'])) {
					foreach($_FILES['attachments']['name'] as $fa) {
						if ($fa != '') {
							if (!$vf->extension($fa)) {
								$this->error->add(t("File {$fa} has an invalid extension."));
							}
						}
					}
				}
			}

			//edit mode, loading existing reply & checking permissions
			if(intval($this->post('cDiscussionPostID'))>0){
				$editMode=1;
				$discussionPost=DiscussionPostModel::getByID( intval($this->post('cDiscussionPostID')), 'ACTIVE');
				if(!$discussionPost->canEdit()) {
					$this->error->add(t('Permission Denied - Invalid User'));
				}
			}

			if (!$this->error->has()) {
				// iterate through valid attachments and create files for them
				$files = array();
				if ($u->isRegistered() || ($dc->anonPostAttachmentsEnabled($d) && $dc->anonPostRepliesEnabled($d))) {
					if (isset($_FILES['attachments']) && is_array($_FILES['attachments']['tmp_name'])) {
						Loader::library("file/importer");
						$fi = new FileImporter();
						for ($i = 0; $i < count($_FILES['attachments']['tmp_name']); $i++) {
							if (is_uploaded_file($_FILES['attachments']['tmp_name'][$i])) {
								$files[] = $fi->import($_FILES['attachments']['tmp_name'][$i], $_FILES['attachments']['name'][$i]);
							}
						}
					}
				}


				//existing post - edit mode
				if( $editMode ){
					$dpm = $discussionPost->edit($this->post('subject'), $this->post('message'), $files, $this->post('retainAttachmentBIDs'), $this->post('track'));
				}else{ //new post - add mode
					if ($this->post('cDiscussionPostParentID') > 0) {
						$dpm2 = DiscussionPostModel::getByID($this->post('cDiscussionPostParentID'));
						$dpm = $dpm2->addPostReply($this->post('subject'), $this->post('message'), $files, $this->post('track'));
					} else {
						$dpm = $this->post->addPostReply($this->post('subject'), $this->post('message'), $files, $this->post('track'));
					}
				}

				if (is_object($dpm)) {
					Loader::model('attribute/categories/collection');
					$ak = CollectionAttributeKey::getByHandle(DISCUSSION_POST_TAG_HANDLE);
					if(is_object($ak)) {
						if(intval($this->post('cDiscussionPostID'))>0) {
							$ak->saveAttributeForm($this->getCollectionObject());
						}
					}
					$moderated = $dpm->setModeration();
					if($moderated) {
						$resp['pending'] = 1;
					} else {
						$post = $dpm->getPost();
						$postReloaded = DiscussionPostModel::load($this->getCollectionObject());
						$resp['redirect'] = BASE_URL . DIR_REL . '/index.php?cID=' . $post->getCollectionID() . '&ccm_paging_p=' . $postReloaded->getTotalPages() . '&time=' . time() . '#msg' . $dpm->getCollectionID();
					}
					$js = Loader::helper('json');
					$this->set('json', $js->encode($resp));
				}
			} else {
				$ci = Loader::helper('concrete/urls');
      			$resp['newCaptcha'] = $ci->getToolsURL('captcha') . '?nocache=' .time();
				$e = $this->error->getList();
				$resp['errors'] = $e;
				$js = Loader::helper('json');
				$this->set('json', $js->encode($resp));
			}
		}
	}

	public function on_before_render() {
		$html = Loader::helper('html');
		$this->addHeaderItem($html->css('discussion.css', 'discussion'));

		$json = $this->get('json');
		if (isset($json)) {
			print '<script type="text/javascript">parent.ccmDiscussion.response(\'' . $json . '\');</script>';
			exit;
		} else {
			$u = new User();
			if($u->isRegistered()) {
				$this->dTrack->userView($u->getUserID());
			}
		}
	}

	public function promote_to_page() {
		Loader::model('collection_types');
		$dpm = DiscussionPostModel::getByID($_POST['discussionPostID']);
		if (is_object($dpm) && (!$dpm->isError())) {
			$newParent = Page::getByID($_POST['cParentID']);
			if (is_object($newParent) && (!$newParent->isError())) {
				$ct = CollectionType::getByID($_POST['ctID']);
				$newParentP = new Permissions($newParent);
				if ($newParentP->canAddSubCollection($ct)) {

					// add page. We don't duplicate it because we want the new page to inherit the master collection blocks
					$data = array('cName' => $dpm->getCollectionName(), 'cDescription' => $dpm->getCollectionDescription(), 'uID' => $dpm->getCollectionUserID());
					$nc = $newParent->add($ct, $data);

					DiscussionTrack::copyTrackedDiscussions($dpm, $nc);

					// now we add the bbcode block's HTML content as a regular content block in the main area
					$b1 = BlockType::getByHandle('content');
					$nc->addBlock($b1, "Main", array('content' => $dpm->getHTMLBody()));

					// now we go through attachments
					$attachments = $dpm->getBlocks('Attachments');
					$a = Area::getOrCreate($nc, 'Main');
					foreach($attachments as $att) {
						$att->move($nc, $a);
					}


					// if moveCopy is set to copy_new, we duplicate the discussion and point to the current spot
					$b2 = BlockType::getByHandle('discussion_guestbook');
					if ($_POST['moveCopy'] == 'copy_new' || $_POST['moveCopy'] == 'move') {
						$pages = $dpm->getThreadedReplies(0, 9999);
						Loader::model('page_list');
						foreach($pages as $pc) {
							$pc->duplicate($nc);
						}

						$gbOptions = array('cThis' => 1,
							'cParentID' => 0,
							'displayGuestBookForm' => 1,
							'enableAnonymous' => 0,
							'captchaChoice'=>DiscussionGuestbookBlockController::CAPTCHA_DEFAULT,
							'anonymousPostChoice'=>DiscussionGuestbookBlockController::ANON_DEFAULT
						);

						// now we add the discussion guestbook summary
						$nc->addBlock($b2, "Main", $gbOptions);
					} else if ($_POST['moveCopy'] == 'copy_retain') {
						$gbOptions['cThis'] = 0;
						$nc->addBlock($b2, "Main", $gbOptions);
					}

					// if it's MOVE we remove the old discussion
					if ($_POST['moveCopy'] == 'move') {
						$dpm->delete();
					}

					header('Location: ' . BASE_URL . DIR_REL . '/index.php?cID=' . $nc->getCollectionID());
					exit;
				}
			}
		}
	}
	/**
	 * The following methods automatically get run and populate the discussionsummary table so that we
	 * can have quick access to statistics
	 * TESTED
	 */
	public function on_page_add($c) {
		$dpm = DiscussionPostModel::load($c);
		if(!$dpm->shouldModerate()) {
			$dpm->incrementCounts();
		}
		$dpm->setPostLocale();
		$dpm->setAttribute('exclude_nav',1);
	}

	/* TESTED */
	public function on_page_move($c, $op, $np) {
		$dpm = DiscussionPostModel::load($c);
		$numToIncrement = 1 + count($dpm->getCollectionChildrenArray());
		$numToDecrement = 0 - $numToIncrement;
		$dpm->updateParentCounts($numToIncrement);

		switch($op->getCollectionTypeHandle()) {
			case 'discussion_post':
				$dpm = DiscussionPostModel::load($op);
				$dpm->updateParentCounts($numToDecrement, true);
				break;
			case 'discussion':
				// the parent page is the discussion directly, so we decrement it
				$d = DiscussionModel::load($op);
				$d->decrementTotalTopics();
				// this is really confusing but you have to use the numToIncrement variable here, because it's positive - and the function
				// decrementTotalPosts expects a positive number because it uses a minus sign in its arithmetic
				$d->decrementTotalPosts($numToIncrement);
				break;
		}
	}

	/* TESTED */
	public function on_page_duplicate($c, $np) {
		$dpm = DiscussionPostModel::load($c);
		$numToIncrement = 1 + count($dpm->getCollectionChildrenArray());
		$dpm->updateParentCounts($numToIncrement);
	}

	/* TESTED */
	public function on_page_delete($c) {
		$dpm = DiscussionPostModel::getByID($c->getCollectionID(),'RECENT');
		$moderated = $dpm->getAttribute('discussion_post_not_displayed');
		if(!$moderated) {
			$numToDecrement = 1 + count($dpm->getCollectionChildrenArray());
			$num = 0 - $numToDecrement;
			//$dpm = DiscussionPostModel::load($c);
			$dpm->updateParentCounts($num);
		}
		return true;
	}

	public static function on_page_view($c) {
		$db = Loader::db();
		$dm = DiscussionPostModel::load($c);
		$dm->recordView();
	}


	public function canPost() {
		$u = new User();
		$canPost = false;
		if($u->isRegistered()) {
			$canPost = true;
		} else {
			$dc = Loader::helper('discussion_config','discussion');
			$dpm = DiscussionPostModel::load($this->getCollectionObject());
			$d = $dpm->getDiscussion();
			$canPost = $dc->anonPostRepliesEnabled($d);
			/*
			$pkg = Package::getByHandle('discussion');
			if($pkg->config('ENABLE_ANON_POSTING_REPLIES')) { // add paackage config value here
				$canPost = true;
			}
			*/
		}
		if($this->isClosed()) {
			$canPost = false;
		}
		return $canPost;
	}


	public function isClosed() {
		$closed = false;
		$c = $this->getCollectionObject();
		if($c->getCollectionAttributeValue('discussion_is_closed') == 1) {
			$closed = true;
		}
		return $closed;
	}

}
