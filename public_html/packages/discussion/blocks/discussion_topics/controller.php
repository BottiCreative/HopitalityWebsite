<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

	class DiscussionTopicsBlockController extends BlockController {
		
		protected $btTable = 'btDiscussionTopics';
		protected $btInterfaceWidth = "400";
		protected $btInterfaceHeight = "300";
		protected $btWrapperClass = 'ccm-ui';

		/** 
		 * Used for localization. If we want to localize the name/description we have to include this
		 */
		public function getBlockTypeDescription() {
			return t("Displays topics in a discussion page type.");
		}
		
		public function getBlockTypeName() {
			return t("Discussion Topics");
		}
		
		public function on_page_view() {
			$html = Loader::helper('html');
			$this->addHeaderItem($html->javascript('jquery.js'));
			$this->addHeaderItem($html->css('discussion.css', 'discussion'));
			$this->addHeaderItem($html->javascript('discussion.js', 'discussion'));
			$this->addHeaderItem($html->javascript('ccm.spellchecker.js'));
			$this->addHeaderItem($html->javascript('jquery.ui.js'));
			$this->addHeaderItem($html->javascript('ccm.dialog.js'));
			$this->addHeaderItem($html->css('ccm.spellchecker.css'));
			$this->addHeaderItem($html->css('ccm.calendar.css'));
			$this->addHeaderItem($html->css('jquery.ui.css'));
			$this->addHeaderItem($html->css('ccm.dialog.css'));
			
			//login popup requirements
			/*
			$this->addHeaderItem($html->javascript('ccm.popup_login.js'));
			$this->addHeaderItem($html->javascript('jquery.form.js'));
			$this->addHeaderItem($html->css('ccm.popup_login.css'));			
			*/
		}
		
		function save($args) {
			
			$args['cThis'] = ($args['cThis'] > 0) ? 1 : 0;
			$args['cParentID'] = ($args['cParentID'] > 0) ? $args['cParentID'] : 0;
			$args['sortModeOverrideGlobal'] = ($args['sortModeOverrideGlobal'] > 0) ? 1 : 0;
			
			if ($args['cThis'] == 0 && $args['cParentIDValue']) {
				$args['cParentID'] = $args['cParentIDValue'];
			}
			
			parent::save($args);	
		}
		
		public function getDiscussionCollectionID() {
			global $c;
			$cParentID = ($this->cThis) ? $c->getCollectionID() : $this->cParentID;
			return $cParentID;
		}
		
		public function view() {
			Loader::model('discussion', 'discussion');
			Loader::model('discussion_post', 'discussion');
			$nav = Loader::helper('navigation');
			$this->set('html', Loader::helper('html'));
			$this->set('display_mode', $this->display_mode);
			$c = Page::getCurrentPage();
			
			$dm = DiscussionModel::getByID($this->getDiscussionCollectionID());
			/*
			$sd = (!empty($_REQUEST['cDiscussionStartDate'])) ? date(DATE_APP_GENERIC_MDY, strtotime($_REQUEST['cDiscussionStartDate'])) : false;
			$ed = (!empty($_REQUEST['cDiscussionEndDate'])) ? date(DATE_APP_GENERIC_MDY, strtotime($_REQUEST['cDiscussionEndDate'])) : false;
			$sortBy = (!empty($_REQUEST['cDiscussionSortBy'])) ? $_REQUEST['cDiscussionSortBy'] : 'most_recent_post';
			$messageList = $dm->getTopics($sd, $ed, $sortBy);					
			*/
			
			Loader::model('discussion_topic_list', 'discussion');
			$pkg = Package::getByHandle('discussion');
			// This is not terribly elegant - we are assuming that the column name will not change in future c5 versions. We ideally should be using sortby and
			// passing the attributekey but it's not setup to allow that with multiple sorts. so instead we have a try/catch block
			try {
				$messageList = new DiscussionTopicList();
				$messageList->filterByParentID($dm->getCollectionID()); 
				//$messageList->filterByAttribute('discussion_post_not_displayed',0);

				
            //$messageList->debug();
            $what = $this->get('ccm_order_by');
            $how  = $this->get('ccm_order_dir');

            if ($this->sortModeOverrideGlobal) {  //enabling this does not allow the user sorting
               $messageList->sortByMultiple('(if(ak_discussion_post_is_pinned = 1, 1, 0)) desc', (strlen($what) ? $what :  $this->sortMode) . ' '  . (strlen($how)?$how: $this->sortModeDir));
            } else {  //this sort was breaking user sort for all cases
               //it looks like if sortByString exists in the get() for a PageList libraries/item_list.php, the order by gets coopted.
               //for now taking this out makes the package user-sortable but it breaks the pinning option.
            //It looks like sortByString is supposed to work with the ccm_order_by but it doesn't appear so.
					$messageList->sortByMultiple('(if(ak_discussion_post_is_pinned = 1, 1, 0)) desc', (strlen($what) ? $what : $pkg->config('GLOBAL_TOPIC_SORT_MODE')) . ' ' . (strlen($how) ? $how : $pkg->config('GLOBAL_TOPIC_SORT_MODE_DIR')));
				}
				$topics = $messageList->getPage();
			} catch(Exception $e) {
				$messageList = new DiscussionTopicList();
				//$messageList->filterByParentID($dm->getCollectionID()); 
				if ($this->sortModeOverrideGlobal) {
					$messageList->sortBy($this->sortMode, $this->sortModeDir);
				} else {
					$messageList->sortBy($pkg->config('GLOBAL_TOPIC_SORT_MODE'), $pkg->config('GLOBAL_TOPIC_SORT_MODE_DIR'));
				}

				$topics = $messageList->getPage();
			}
         $this->set('no_sort',false);
			$this->set('topics', $topics);
			$this->set('topicList', $messageList);
			$this->set('av', Loader::helper('concrete/avatar'));
			$this->set('nav', $nav);
		}
	}
