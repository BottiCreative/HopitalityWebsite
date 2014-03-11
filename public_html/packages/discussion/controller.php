<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

class DiscussionPackage extends Package {

	protected $pkgHandle = 'discussion';
	protected $appVersionRequired = '5.5.0';
	protected $pkgVersion = '1.8.6';

	public function getPackageDescription() {
		return t('Adds a forum and discussion system to your website.');
	}

	public function getPackageName() {
		return t('Discussion');
	}

	// automatically run by the package. Let's setup some events
	public function on_start() {
		Events::extendPageType('discussion', 'on_page_view');
		Events::extendPageType('discussion_post');

		if(!defined('DISCUSSION_POST_TAG_HANDLE')) {
			define('DISCUSSION_POST_TAG_HANDLE','discussion_post_tags');
		}

	}

	public function install() {
		$pkg = parent::install();

		Loader::model('single_page');
		Loader::model('user_attributes');

		Loader::model('collection_types');
		Loader::model('collection_attributes');

		$data['ctHandle'] = 'discussion';
		$data['ctName'] = t('Discussion');
		$eve = CollectionType::add($data, $pkg);

		$data['ctHandle'] = 'discussion_post';
		$data['ctName'] = t('Discussion Post');
		$evc = CollectionType::add($data, $pkg);

		// install attributes
		$cab1 = CollectionAttributeKey::add('IMAGE_FILE', array('akHandle' => 'discussion_image', 'akName' => t('Discussion Image'), 'akIsSearchable' => true), $pkg);
		$cab2 = CollectionAttributeKey::add('BOOLEAN',array('akHandle' => 'discussion_post_is_pinned', 'akName' => t('Discussion Post is Pinned'), 'akIsSearchable' => true), $pkg);
		$cab3 = CollectionAttributeKey::add('BOOLEAN',array('akHandle' => 'discussion_is_closed', 'akName' => t('Discussion is Closed'), 'akIsSearchable' => true), $pkg);
		$cab4 = CollectionAttributeKey::add('SELECT',array('akHandle' => 'discussion_mode', 'akName' => t('Discussion Mode'), 'akIsSearchable' => true), $pkg);

		SelectAttributeTypeOption::add($cab4, t('Flat'));
		SelectAttributeTypeOption::add($cab4, t('Threaded'));

		$cab5 = CollectionAttributeKey::add('SELECT',array('akHandle' => 'discussion_post_tags', 'akSelectAllowMultipleValues' => 1, 'akSelectAllowOtherValues' => 1, 'akName' => t('Discussion Post Tags'), 'akIsSearchable' => true), $pkg);

		/*
		$cab5 = CollectionAttributeKey::add('BOOLEAN',array('akHandle' => 'discussion_post_allows_rating', 'akName' => t('Discussion Allow Ratings'), 'akIsSearchable' => true), $pkg);
		$cab6 = CollectionAttributeKey::add('RATING',array('akHandle' => 'discussion_post_rating', 'akName' => t('Discussion Rating'), 'akIsSearchable' => true), $pkg);
		*/
		$cab7 = CollectionAttributeKey::add('BOOLEAN',array('akHandle' => 'discussion_post_not_displayed', 'akName' => t('Discussion Post is not Displayed'), 'akIsSearchable' => true), $pkg);

		$ak = CollectionAttributeKey::getByHandle('discussion_moderation_type');
		if(!is_object($ak)) {
			$cab = CollectionAttributeKey::add('SELECT',array('akHandle' => 'discussion_moderation_type', 'akName' => t('Discussion Moderation'), 'akIsSearchable' => true), $pkg);
			$opt = new SelectAttributeTypeOption(0, t('All Posts'), 1);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t('Only Posts by Anonymous Users'), 2);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t("Don't Moderate Any Posts"), 3);
			$opt->saveOrCreate($cab);
			$eve->assignCollectionAttribute($cab);
		}
		$ak = CollectionAttributeKey::getByHandle('discussion_anonymous_posting');
		if(!is_object($ak)) {
			$cab = CollectionAttributeKey::add('SELECT',array('akHandle' => 'discussion_anonymous_posting', 'akName' => t('Discussion Anonymous Posting'), 'akIsSearchable' => true, 'akIsSearchableIndexed'=>true, 'akSelectAllowMultipleValues'=>true), $pkg);
			$opt = new SelectAttributeTypeOption(0, t('Enable Anonymous Posting (new posts)'), 1);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t('Enable Anonymous Replies'), 2);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t('Solving Captcha is Required to Post'), 3);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t('Allow Anonymous Posters To Attach Files'), 4);
			$opt->saveOrCreate($cab);
			$eve->assignCollectionAttribute($cab);
		}

		UserAttributeKey::add('NUMBER',array('akHandle' => 'discussion_total_posts', 'akName' => t('Total Posts'), 'akIsSearchable' => 1, 'akIsEditable' => false, 'uakProfileDisplay' => true), $pkg);

		$eve->assignCollectionAttribute($cab1);
		$evc->assignCollectionAttribute($cab2);
		$evc->assignCollectionAttribute($cab3);
		$eve->assignCollectionAttribute($cab4);
		$evc->assignCollectionAttribute($cab5);
		//$evc->assignCollectionAttribute($cab6);
		$evc->assignCollectionAttribute($cab7);

		$dau = SinglePage::add('/dashboard/discussion', $pkg);
		$dau->update(array('cName'=>'Discussion', 'cDescription'=>'Manage forums and community.'));
		$dau2 = SinglePage::add('/dashboard/discussion/settings', $pkg);
		$dau3 = SinglePage::add('/dashboard/discussion/badges', $pkg);
		$dau4 = SinglePage::add('/dashboard/discussion/moderation', $pkg);

		// install block
		BlockType::installBlockTypeFromPackage('discussion_categories', $pkg);
		BlockType::installBlockTypeFromPackage('discussion_guestbook', $pkg);
		BlockType::installBlockTypeFromPackage('discussion_topics', $pkg);
		BlockType::installBlockTypeFromPackage('discussion_post_list', $pkg);
		BlockType::installBlockTypeFromPackage('user_posts', $pkg);
		BlockType::installBlockTypeFromPackage('user_badges', $pkg);

		$bt = BlockType::getByHandle('bbcode');
		if (!is_object($bt)) {
			BlockType::installBlockTypeFromPackage('bbcode', $pkg);
		}

		BlockType::installBlockTypeFromPackage('users_online', $pkg);

		Loader::library('mail/importer');
		MailImporter::add(array('miHandle' => 'discussion_post_reply'), $pkg);

		$this->installDefaultBadges();

		// setup default configuration
		$pkg->saveConfig('FILTER_BANNED_WORDS', 0);
		$pkg->saveConfig('ENABLE_BADGES_OVERLAY', 1);
		$pkg->saveConfig('ENABLE_BADGES_PROFILE', 1);
		$pkg->saveConfig('GLOBAL_DISPLAY_MODE', 'flat');
		$pkg->saveConfig('GLOBAL_TOPIC_SORT_MODE', 'cvDatePublicLastPost');
		$pkg->saveConfig('GLOBAL_TOPIC_SORT_MODE_DIR', 'desc');
		$pkg->saveConfig('GLOBAL_POSTING_METHOD', 'overlay');

		$pkg->saveConfig('ENABLE_ANON_POSTING', 0);
		$pkg->saveConfig('ENABLE_ANON_POSTING_REPLIES', 0);
		$pkg->saveConfig('ANON_POSTING_CAPTCHA_REQUIRED', 1);
		$pkg->saveConfig('ANON_POSTING_ATTACHMENTS', 0);
		$pkg->saveConfig('MODERATION_TYPE', 'anon');
		$pkg->saveConfig('MODERATOR_EMAIL', '');
		$pkg->saveConfig('MODERATION_NEW_MESSAGES', 0);

		// install default content
		$mc1 = CollectionType::getByHandle('full');
		if (is_object($mc1) && is_object($eve)) {
			$dm = $mc1->getMasterTemplate();
			$blocks = $dm->getBlocks();

			$dm2 = $eve->getMasterTemplate();
			// alias these blocks to the new event calendar page
			foreach($blocks as $b) {
				$b->alias($dm2);
			}

			// now we add a discussion topic list to the master collection
			$bt = BlockType::getByHandle('discussion_topics');
			$args['cParentID'] = $dm2->getCollectionID();
			$args['cThis'] = 1;
			$dm2->addBlock($bt, "Main", $args);

			// Now let's add a calendar page type beneath the root.
			$home = Page::getByID(HOME_CID);
			$data = array();
			$data['name'] = t('Forums');
			$forumsLanding = $home->add($mc1, $data);

			// Now we add the categories block to the forums landing page
			$bt = BlockType::getByHandle('discussion_categories');
			$args['cParentID'] = $forumsLanding->getCollectionID();
			$args['cThis'] = 1;
			$forumsLanding->addBlock($bt, "Main", $args);

			// now we add two discussions underneath
			$data = array();
			$data['name'] = t('Announcements');
			$forumDiscussion1 = $forumsLanding->add($eve, $data);

			$data = array();
			$data['name'] = t('General Chat');
			$forumDiscussion2 = $forumsLanding->add($eve, $data);

			// add badges and posts blocks to user profile page
			$userProfile = Page::getByPath('/profile');
			if (is_object($userProfile) && (!$userProfile->isError())) {
				$bt1 = BlockType::getByHandle('user_posts');
				$userProfile->addBlock($bt1, "Main", array());
				$bt2 = BlockType::getByHandle('user_badges');
				$userProfile->addBlock($bt2, "Main", array());
			}

			$g = Group::getByName('No_Moderation');
			if(!is_object($g)) {
				Group::add('No_Moderation',t('Allowed to post to discussion forums regardless of moderation'));
			}
		}
	}

	public function uninstall() {
		// Uninstall block types gracefully
		// We must do this as, 5.5.2.1 has a bug that disallows uninstall with page default blocks.

		// Only do this for 5.5 < version < 5.5.3
		if (version_compare(APP_VERSION, '5.5.3') && version_compare('5.5', APP_VERSION)) {
			$db = Loader::db();
			$bts = array('discussion_categories','discussion_guestbook','discussion_topics','discussion_post_list','user_posts','user_badges','users_online');
			foreach ($bts as $btHandle) {
				$bt = BlockType::getByHandle($btHandle);
				if (is_object($bt)) {
					$r = $db->Execute('select cID, cvID, b.bID, arHandle from CollectionVersionBlocks cvb inner join Blocks b on b.bID = cvb.bID where btID = ?', array($bt->getBlockTypeID()));
					while ($row = $r->FetchRow()) {
						$nc = Page::getByID($row['cID'], $row['cvID']);
						$b = Block::getByID($row['bID'], $nc, $row['arHandle']);
						if (is_object($b)) { // Eliminate issue
							$b->deleteBlock();
						}
					}
					$ca = new Cache();
					$ca->delete('blockTypeByID', $bt->btID);
					$ca->delete('blockTypeByHandle', $bt->btHandle);
					$ca->delete('blockTypeList', false);
					$db->Execute("delete from BlockTypes where btID = ?", array($bt->btID));
				}
			}
		}

		// Nothing to see here, move along
		parent::uninstall();
	}

	public function upgrade() {
		parent::upgrade();
		Loader::model('collection_types');
		Loader::model('collection_attributes');
		Loader::model('single_page');

		$pkg = Package::getByHandle('discussion');
		// Version 1.2
		$bt = BlockType::getByHandle('discussion_post_list');
		if (!is_object($bt)) {
			BlockType::installBlockTypeFromPackage('discussion_post_list', $pkg);
		}

		// Version 1.3
		$pkg->saveConfig('ENABLE_ANON_POSTING', 0);
		$pkg->saveConfig('ENABLE_ANON_POSTING_REPLIES', 0);
		$pkg->saveConfig('ANON_POSTING_CAPTCHA_REQUIRED', 1);
		$pkg->saveConfig('ANON_POSTING_ATTACHMENTS', 0);
		$pkg->saveConfig('MODERATION_TYPE', 'anon');
		$pkg->saveConfig('MODERATOR_EMAIL', '');
		$pkg->saveConfig('MODERATION_NEW_MESSAGES', 0);

		$ak = CollectionAttributeKey::getByHandle('discussion_post_not_displayed');
		if(!is_object($ak)) {
			$ct = CollectionType::getByHandle('discussion_post');
			$cab = CollectionAttributeKey::add('BOOLEAN',array('akHandle' => 'discussion_post_not_displayed', 'akName' => t('Discussion Post is not Displayed'), 'akIsSearchable' => true), $pkg);
			$ct->assignCollectionAttribute($cab);
		}

		$ct = CollectionType::getByHandle('discussion');
		$ak = CollectionAttributeKey::getByHandle('discussion_moderation_type');
		if(!is_object($ak)) {
			$cab = CollectionAttributeKey::add('SELECT',array('akHandle' => 'discussion_moderation_type', 'akName' => t('Discussion Moderation'), 'akIsSearchable' => true), $pkg);
			$opt = new SelectAttributeTypeOption(0, t('All Posts'), 1);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t('Only Posts by Anonymous Users'), 2);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t("Don't Moderate Any Posts"), 3);
			$opt->saveOrCreate($cab);
			$ct->assignCollectionAttribute($cab);
		}
		$ak = CollectionAttributeKey::getByHandle('discussion_anonymous_posting');
		if(!is_object($ak)) {
			$cab = CollectionAttributeKey::add('SELECT',array('akHandle' => 'discussion_anonymous_posting', 'akName' => t('Discussion Anonymous Posting'), 'akIsSearchable' => true, 'akIsSearchableIndexed'=>true, 'akSelectAllowMultipleValues'=>true), $pkg);
			$opt = new SelectAttributeTypeOption(0, t('Enable Anonymous Posting (new posts)'), 1);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t('Enable Anonymous Replies'), 2);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t('Solving Captcha is Required to Post'), 3);
			$opt->saveOrCreate($cab);
			$opt = new SelectAttributeTypeOption(0, t('Allow Anonymous Posters To Attach Files'), 4);
			$opt->saveOrCreate($cab);
			$ct->assignCollectionAttribute($cab);
		}

		$g = Group::getByName('No_Moderation');
		if(!is_object($g)) {
			Group::add('No_Moderation',t('Allowed to post to discussion forums regardless of moderation'));
		}

		$dau = SinglePage::add('/dashboard/discussion/moderation', $pkg);

		// 1.7 - discussion tags
		$ak = CollectionAttributeKey::getByHandle('discussion_post_tags');
		if(!is_object($ak)) {
			$cab = CollectionAttributeKey::add('SELECT',array('akHandle' => 'discussion_post_tags', 'akSelectAllowMultipleValues' => 1, 'akSelectAllowOtherValues' => 1, 'akName' => t('Discussion Post Tags'), 'akIsSearchable' => true), $pkg);
			$postCt = CollectionType::getByHandle('discussion_post');
			$postCt->assignCollectionAttribute($cab);
		}
	}


	function installDefaultBadges(){

		//Install default badge groups
		Loader::model('discussion_badge', 'discussion');
		if( !count(DiscussionBadge::getAvailableBadges()) ){
			DiscussionBadge::addBadge( t('Gold'), t('Exceptional Achievement'), $this->getPackagePath().'/images/goldstar_1.png' );
			DiscussionBadge::addBadge( t('Silver'), t('Great Achievement'), $this->getPackagePath().'/images/silver_1.png' );
		}
	}

}

?>
