<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

	class UserPostsBlockController extends BlockController {
		
		protected $btTable = 'btDiscussionUserPosts';
		protected $btInterfaceWidth = "400";
		protected $btInterfaceHeight = "250";
		protected $btWrapperClass = 'ccm-ui';		

		/** 
		 * Used for localization. If we want to localize the name/description we have to include this
		 */
		public function getBlockTypeDescription() {
			return t("Display all discussion posts by a certain user.");
		}
		
		public function getBlockTypeName() {
			return t("User Posts");
		}
		
		public function on_page_view() {
			$html = Loader::helper('html');
			$this->addHeaderItem($html->css('discussion.css', 'discussion'));
		}
		
		public function add() {
			$this->set('num',20);
		}
		
		function save($args) {
			$args['byUserID'] = ($args['byUserID']) ? $args['byUserID'] : 0;
			$args['num'] = (is_numeric($args['num'])?$args['num']:20);
			parent::save($args);
		}
		
		/** 
		 * We need to call this from within the view template because the controller doesn't know
		 * whether it's a user profile or a db profile user id
		 */
		public function getPosts($uID) {
			
			$messageList = new DiscussionPostList();
			if($uID) {
				$messageList->filterByUserID($uID);
			}
			$messageList->sortByMultiple('cvDatePublic desc', 'cvDateCreated DESC');
			
			if(is_numeric($this->num) && $this->num > 0) {
				$messageList->setItemsPerPage($this->num);
			}
			
			return $messageList;
		}
		
		public function view() {
			Loader::model('discussion', 'discussion');
			Loader::model('discussion_post', 'discussion');
			Loader::model('discussion_post_list', 'discussion');
			$nav = Loader::helper('navigation');
			$this->set('html', Loader::helper('html'));
			$this->set('nav', $nav);
			$this->set('av', Loader::helper('concrete/avatar'));
		}

	}