<?php 
Loader::model('discussion', 'discussion');
Loader::model('discussion_post', 'discussion');
Loader::model('discussion_track', 'discussion');
class DiscussionPageTypeController extends Controller {

	public $helpers = array('form', 'html');
	protected $error = false;
	protected $discussion;
	protected $dTrack; // discussion tracking
	protected $allowedAttributeHandles = array();

	/**
	 * Returns all the posts beneath a given discussion
	 */
	public function on_start() {
		Loader::model('attribute/categories/collection');
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

		$this->error = Loader::helper('validation/error');
		$this->loadModel(); // loads the discussion model
		//$this->set('posts', $this->discussion->getPosts());
		$this->dTrack = new DiscussionTrack($this->getCollectionObject());
		$this->set("dTrack",$this->dTrack);
		$u = new User();
		$this->set("u",$u);
		$this->set("closed",$this->isClosed());

		$pkg = Package::getByHandle('discussion');
		if (!$this->canPost()) {
			$this->set('startDiscussionAction', 'location.href=\'' . View::url('/login', 'forward', $this->getCollectionObject()->getCollectionID()) . '\';');
		} else {
			if ($pkg->config('GLOBAL_POSTING_METHOD') == 'overlay') {
				$uID = $u->isRegistered() ? $u->getUserID() : 0;
				$this->set('startDiscussionAction', 'ccmDiscussion.postOverlay(' . $this->getCollectionObject()->getCollectionID() .', ' . $uID . ', \''
					.Loader::helper('concrete/urls')->getToolsURL('post_form','discussion').'\',1)');
			} else {
				$this->set('startDiscussionAction', 'ccmDiscussion.postForm(' . $this->getCollectionObject()->getCollectionID() .')');
			}
		}

		// captcha, attachments or not
		$dc = Loader::helper('discussion_config','discussion');
		$this->set('captchaRequired',$dc->captchaRequired($this->discussion));
		$this->set('anonAttachments',$dc->anonPostAttachmentsEnabled($this->discussion));

		$tags = CollectionAttributeKey::getByHandle(DISCUSSION_POST_TAG_HANDLE);
		$this->set('tags',$tags);
	}

	protected function loadModel() {
		$this->discussion = DiscussionModel::load($this->getCollectionObject());
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

	/**
	 * Creates a top level post in a discussion
	 * Also used for edit of an existing discussion
	 */
	public function add_post() {

		if ($this->isPost() && $this->canPost()) {
			$v = Loader::helper('validation/strings');
			$vf = Loader::helper('validation/file');
			$wordFilter = Loader::helper('validation/banned_words');
			$dc = Loader::helper('discussion_config','discussion');
			$captcha = Loader::helper('validation/captcha');
			$txt = Loader::helper('text');

			$pkg = Package::getByHandle('discussion');
			$u = new User();

			// ip validation
			$ip = Loader::helper('validation/ip');
			if (!$ip->check()) {
				$this->error->add($ip->getErrorMessage());
			}

			if (!$v->notempty($this->post('subject'))) {
				$this->error->add(t('Your subject cannot be empty.'));
			}elseif($pkg->config('FILTER_BANNED_WORDS') == 1 && $wordFilter->hasBannedWords($this->post('subject')) ){
				$this->error->add(t('Your subject contains inappropriate content.'));
			}
			if (!$v->notempty($this->post('message'))) {
				$this->error->add(t('Your message cannot be empty.'));
			}elseif($pkg->config('FILTER_BANNED_WORDS') == 1 && $wordFilter->hasBannedWords($this->post('message')) ){
				$this->error->add(t('Your message contains inappropriate content.'));
			}


			if (!$u->isRegistered() && $dc->captchaRequired($this->discussion)) {
				if (!$captcha->check()) {
					$this->error->add(t("Incorrect captcha code"));
				}
			}

			// saving attachments
			if ($u->isRegistered() || ($dc->anonPostEnabled($this->discussion) && $dc->anonPostAttachmentsEnabled($this->discussion))) {
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

			// load current post if editing
			if(intval($this->post('cDiscussionPostID'))>0){
				$editMode=1;
				$discussionPost=DiscussionPostModel::getByID( intval($this->post('cDiscussionPostID')), 'ACTIVE');
				$typeHandle=$discussionPost->getCollectionTypeHandle();

				if($discussionPost->getCollectionUserID()!=$u->getUserID() )
					$this->error->add(t('Permission Denied - Invalid User'));
			}
			if (!$this->error->has()) {
				$nh = Loader::helper('navigation');
				$files = $this->processAttachments();

				$subject = $txt->sanitize($this->post('subject'));
				$message = $txt->sanitize($this->post('message'));


				if( $editMode ){
					$dpm = $discussionPost->edit($subject, $message, $files, $this->post('retainAttachmentBIDs'));
				}else{ //new post - add mode
					$dpm = $this->discussion->addPost($subject, $message, $files, $this->post('track'));
				}
				if (is_object($dpm)) {
					Loader::model('attribute/categories/collection');
					$discussionCollection = Page::getByID($dpm->getCollectionID(), 'RECENT');
					$ak = CollectionAttributeKey::getByHandle(DISCUSSION_POST_TAG_HANDLE);
					if(is_object($ak)) {
						$ak->saveAttributeForm($discussionCollection);
					}
					$discussionCollection->refreshCache();
					$discussionCollection->reindex();


					$moderated = $dpm->setModeration();
					if($moderated) {
						$resp['pending'] = 1;
					} else {
						$resp['redirect'] = BASE_URL . DIR_REL . '/index.php?cID=' . $dpm->getCollectionID();
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

	public function processAttachments() {
		// iterate through valid attachments and create files for them
		$files = array();
		Loader::library('file/importer');
		$fi = new FileImporter();
		if (isset($_FILES['attachments']) && is_array($_FILES['attachments']['tmp_name'])) {
			for ($i = 0; $i < count($_FILES['attachments']['tmp_name']); $i++) {
				if (is_uploaded_file($_FILES['attachments']['tmp_name'][$i])) {
					$files[] = $fi->import($_FILES['attachments']['tmp_name'][$i], $_FILES['attachments']['name'][$i]);
				}
			}
		}
		return $files;
	}


	public function canPost() {
		$u = new User();
		$canPost = false;
		if($u->isRegistered()) {
			$canPost = true;
		} else {
			$dc = Loader::helper('discussion_config','discussion');
			$page = $this->getCollectionObject();
			$d = DiscussionModel::getByID($page->getCollectionID());
			$canPost = $dc->anonPostEnabled($d);
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


	public function on_before_render() {
		$this->set('error', $this->error);
		$html = Loader::helper('html');
		$this->addHeaderItem($html->css('discussion.css', 'discussion'));

		$json = $this->get('json');
		if (isset($json)) {
			print '<script type="text/javascript">parent.ccmDiscussion.response(\'' . $json . '\');</script>';
			exit;
		}
	}

	public function preload($cID) {
		if(intval($cID) > 0) {
			// preload tags
			$page = Page::getByID($cID);
			Loader::model('attribute/categories/collection');
			$tags = CollectionAttributeKey::getByHandle(DISCUSSION_POST_TAG_HANDLE);
			$tagsValue = $page->getAttributeValueObject($tags);
			$this->set('tags',$tags);
			$this->set('tagsValue',$tagsValue);
		}

		$this->set('preload',true);
	}


	public static function on_page_view($c) {
		$db = Loader::db();
		$dm = DiscussionModel::load($c);
		$dm->recordView();
	}

}
