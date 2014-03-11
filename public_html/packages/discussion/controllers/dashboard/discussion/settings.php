<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 

class DashboardDiscussionSettingsController extends Controller {
	public $helpers = array('form', 'concrete/interface', 'validation/token');
	
	public function save() {
		if ($this->isPost()) {
			$pkg = Package::getByHandle('discussion');
			$pkg->saveConfig('FILTER_BANNED_WORDS', $this->post('FILTER_BANNED_WORDS'));
			$pkg->saveConfig('ENABLE_BADGES_OVERLAY', $this->post('ENABLE_BADGES_OVERLAY'));
			$pkg->saveConfig('ENABLE_BADGES_PROFILE', $this->post('ENABLE_BADGES_PROFILE'));
			$pkg->saveConfig('GLOBAL_DISPLAY_MODE', $this->post('GLOBAL_DISPLAY_MODE'));
			$pkg->saveConfig('GLOBAL_TOPIC_SORT_MODE', $this->post('GLOBAL_TOPIC_SORT_MODE'));
			$pkg->saveConfig('GLOBAL_TOPIC_SORT_MODE_DIR', $this->post('GLOBAL_TOPIC_SORT_MODE_DIR'));
			$pkg->saveConfig('GLOBAL_POSTING_METHOD', $this->post('GLOBAL_POSTING_METHOD'));
			
			// settings added v1.3
			$pkg->saveConfig('ENABLE_ANON_POSTING', $this->post('ENABLE_ANON_POSTING'));
			$pkg->saveConfig('ENABLE_ANON_POSTING_REPLIES', $this->post('ENABLE_ANON_POSTING_REPLIES'));
			$pkg->saveConfig('ANON_POSTING_CAPTCHA_REQUIRED', $this->post('ANON_POSTING_CAPTCHA_REQUIRED'));
			$pkg->saveConfig('ANON_POSTING_ATTACHMENTS', $this->post('ANON_POSTING_ATTACHMENTS'));
			$pkg->saveConfig('MODERATION_TYPE', $this->post('MODERATION_TYPE'));
			$pkg->saveConfig('MODERATOR_EMAIL', $this->post('MODERATOR_EMAIL'));
			
			$pkg->saveConfig('DISCUSSION_MULTILINGUAL_ENABLED', $this->post('DISCUSSION_MULTILINGUAL_ENABLED'));
			if($this->post('DISCUSSION_MULTILINGUAL_ENABLED')) {
				Loader::model('collection_types');
				Loader::model('collection_attributes');
				if(!CollectionAttributeKey::getByHandle('discussion_post_locale') instanceof CollectionAttributeKey) {
					$textt = AttributeType::getByHandle('text');
					$attr = CollectionAttributeKey::add($textt, array('akHandle' => 'discussion_post_locale', 'akName' => t('Discussion Post Locale'), 'akIsSearchable' => true), $pkg);
					$postCt = CollectionType::getByHandle('discussion_post');
					$postCt->assignCollectionAttribute($attr);
				}
			}
		}
        
        $this->set('message', t('Settings Updated.'));
		$this->view();
	}
	
	public function view() {
		$pkg = Package::getByHandle('discussion');
		$this->set('pkg', $pkg);	
	}

}