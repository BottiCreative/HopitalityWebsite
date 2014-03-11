<?php  	defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('page_list');
Loader::model('discussion_post', 'discussion');
Loader::model('discussion_post_list', 'discussion');
Loader::model('discussion_track', 'discussion');

class DiscussionGuestbookBlockController extends BlockController {
	const ANON_YES = 1;
	const ANON_NO = 0;
	const ANON_DEFAULT = 2;

	const CAPTCHA_YES = 1;
	const CAPTCHA_NO = 0;
	const CAPTCHA_ANON = 2;
	const CAPTCHA_DEFAULT = 3;

	protected $btTable = 'btDiscussionGuestBook';
	protected $btInterfaceWidth = "350";
	protected $btInterfaceHeight = "350";

	protected $btIncludeAll = 1;

	public $anonymousPostChoice = self::ANON_DEFAULT;
	public $captchaChoice = self::CAPTCHA_DEFAULT;

	/**
	 * Used for localization. If we want to localize the name/description we have to include this
	 */
	public function getBlockTypeDescription() {
		return t("Adds blog-style comments (a guestbook) to your page, but uses the discussion backend to create posts.");
	}

	public function getBlockTypeName() {
		return t("Discussion Guestbook");
	}

	/**
	 * returns the title
	 * @return string $title
	*/
	function getTitle() {
		return $this->title;
	}


	/**
	 * returns wether or not to require approval
	 * @return bool
	*/
	function getRequireApproval() {
		return $this->requireApproval;
	}


	/**
	 * returns the bool to display the form
	 * @return bool
	*/
	function getDisplayGuestBookForm() {
		return $this->displayGuestBookForm;
	}

	public function action_remove_track() {
		$c = Page::getCurrentPage();
		$u = new User();
		$dTrack = new DiscussionTrack($c);
		$uID = $u->getUserID();
		$dTrack->removeTrack($uID);
		Loader::packageElement('discussion_track', 'discussion', array('trackRemoved' => 'true', 'dTrack' => $dTrack, 'uID' => $u->getUserID(), 'c' => $c));
		exit;
	}

	public function action_do_track() {
		$c = Page::getCurrentPage();
		$u = new User();
		$dTrack = new DiscussionTrack($c);
		$uID = $u->getUserID();
		$dTrack->addTrack($uID);
		Loader::packageElement('discussion_track', 'discussion', array('trackSuccess' => 'true','dTrack' => $dTrack, 'uID' => $u->getUserID(), 'c' => $c));
		exit;
	}

	public function action_track() {
		$c = Page::getCurrentPage();
		$u = new User();
		$dTrack = new DiscussionTrack($c);

		Loader::packageElement('discussion_track', 'discussion', array('dTrack' => $dTrack, 'uID' => $u->getUserID(), 'c' => $c));
		exit;
	}

	public function on_page_view() {
		$html = Loader::helper('html');
		$this->addHeaderItem($html->javascript('discussion.js', 'discussion'));
		//$this->addHeaderItem($html->javascript('jquery.js'));
		//$this->addHeaderItem($html->javascript('ccm.dialog.js'));
		$this->addHeaderItem($html->css('ccm.dialog.css'));
		$this->addHeaderItem($html->css('discussion.css', 'discussion'));
	}

	public function view() {
		if ($this->cThis == 1) {
			$c = Page::getCurrentPage();
			$pm = DiscussionPostModel::getByID($c->getCollectionID());
		} else {
			$pm = DiscussionPostModel::getByID($this->cParentID);
		}
		$posts = $pm->getThreadedReplies();
		$this->set('posts', $posts);
		$this->set('enableAnonymous',$this->enableAnonymous);
	}

	function save($args) {
		$args['cThis'] = ($args['cThis'] > 0) ? 1 : 0;

		if ($args['cThis'] == 0 && $args['cParentIDValue'] > 0) {
			$args['cParentID'] = $args['cParentIDValue'];
		} else if ($args['cParentID'] < 1) {
			$args['cParentID'] = 0;
		}

		$args['enableAnonymous'] = $args['anonymousPostChoice'];
		if($args['enableAnonymous'] == self::ANON_DEFAULT) {
			$pkg = Package::getByHandle('discussion');
			$args['enableAnonymous'] = $pkg->config('ENABLE_ANON_POSTING');
		}
		if ($args['enableAnonymous'] == '') {
			$args['enableAnonymous'] = 0;
		}
		$otherargs = array('captchaChoice'=>0,'anonymousPostChoice'=>0);
		// Make sure required columns are set to bool 0.
		$args = array_merge($otherargs,$args);

		foreach ($args as &$val) {
			// Stop the null!
			if ($val === null){
				$val = 0;
			}
		}

		parent::save($args);
	}

	function captcha_enabled($anonUser = false) {

		switch ($this->captchaChoice) {
			case self::CAPTCHA_YES:
				return true;
				break;

			case self::CAPTCHA_NO:
				return false;
				break;

			case self::CAPTCHA_ANON:
				return $anonUser;
				break;

			case self::CAPTCHA_DEFAULT:
				$pkg = Package::getByHandle('discussion');
				return $pkg->config('ANON_POSTING_CAPTCHA_REQUIRED') && $anonUser; //package captchaRequired only affects anonymous users.
		}
	}



	/**
	 * Handles the form post for adding a new guest book entry
	 *
	*/
	function action_form_save_entry() {
		$v = Loader::helper('validation/strings');
		$ip = Loader::helper('validation/ip');
		$e = Loader::helper('validation/error');
		$u = new User();

		if (!$ip->check()) {
			$e->add($ip->getErrorMessage());
		}

		if (!$u->isRegistered() && !$this->enableAnonymous) {
			$e->add(t("You must be logged in to post."));
	    } elseif (!$u->isRegistered() && $this->enableAnonymous) {
	    	$u = new AnonymousUser();
	    }

		if (!$this->displayGuestBookForm) {
			$e->add(t('Posting is disabled.'));
		}

		if(!$v->notempty($this->post('discussionGuestbookBody'))) {
			$e->add(t("Your comment is empty."));
		}

		if($this->captcha_enabled(!$u->isRegistered())) {
			$captcha = Loader::helper('validation/captcha');
			if(!$captcha->check()){
				$e->add(t('Incorrect captcha.'));
			}
		}

		if (!$e->has()) {
			$txt = Loader::helper('text');
			$subject = $txt->shorten($this->post('discussionGuestbookBody'), 32, '');
			$c = Page::getCurrentPage();
			if (isset($_POST['entryID'])) {
				$dpm = DiscussionPostModel::getByID($_POST['entryID']);
				if ($dpm->canEdit()) {
					$reply = $dpm->edit($subject, $this->post('discussionGuestbookBody'));
				}
			} else {
				if ($this->cThis == 1) {
					$dpm = DiscussionPostModel::getByID($c->getCollectionID());
				} else {
					$dpm = DiscussionPostModel::getByID($this->cParentID);
				}
				$reply = $dpm->addPostReply($subject, $this->post('discussionGuestbookBody'));
			}
			header('Location: ' . BASE_URL . DIR_REL . '/index.php?cID=' . $c->getCollectionID() . '&method=discussion_comment_posted#ccm-discussion-guestbook-form-' . $this->bID);
		}
		$this->set('error', $e);
	}


	/**
	 * Loads a guestbook entry and sets the $Entry GuestBookBlockEntry object instance for use by the view
	 *
	 * @return bool
	*/
	function action_loadEntry($entryID) {
		$dpm = DiscussionPostModel::getByID($_REQUEST['entryID']);
		if (is_object($dpm) && (!$dpm->isError())) {
			if ($dpm->canEdit()) {
				$this->set('entryBody', $dpm->getPlainTextBody());
				$this->set('entryID', $dpm->getCollectionID());
			}
		}
	}

	/**
	 * deltes a given Entry, sets the response message for use in the view
	 *
	*/
	function action_removeEntry() {
		$dpm = DiscussionPostModel::getByID($_REQUEST['entryID']);
		if (is_object($dpm) && (!$dpm->isError())) {
			if ($dpm->canDelete()) {
				$dpm->delete();
			}
		}
	}

} // end class def

