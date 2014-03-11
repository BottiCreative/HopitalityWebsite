<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

	class DiscussionCategoriesBlockController extends BlockController {
		
		protected $btTable = 'btDiscussionCategories';
		protected $btInterfaceWidth = "400";
		protected $btInterfaceHeight = "400";	

		/** 
		 * Used for localization. If we want to localize the name/description we have to include this
		 */
		public function getBlockTypeDescription() {
			return t("Display discussion categories on your website.");
		}
		
		public function getBlockTypeName() {
			return t("Discussion Categories");
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
			//$this->addHeaderItem($html->javascript('ccm.popup_login.js'));
			$this->addHeaderItem($html->javascript('jquery.form.js'));
			//$this->addHeaderItem($html->css('ccm.popup_login.css'));			
		}
		
		function save($args) {
			
			$args['cThis'] = ($args['cThis'] > 0) ? 1 : 0;
			$args['sortModeOverrideGlobal'] = ($args['sortModeOverrideGlobal'] > 0) ? 1 : 0;
			$args['cParentID'] = 0;
			
			if ($args['cThis'] == 0) {
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
			global $c;
			
			Loader::model('discussion_category_list', 'discussion');
			$dcl = new DiscussionCategoryList();
			$dcl->filterByParentID($this->getDiscussionCollectionID()); 
			
			if ($this->sortMode=='recent') {
				$dcl->sortByMultiple('cvDatePublic desc', 'cvDateCreated DESC');
			} else if ($this->sortMode == 'display_asc') { 
				$dcl->sortBy('p1.cDisplayOrder', 'asc');
			} else {
				$dcl->sortByMultiple('cvDatePublic', 'cvDateCreated');
			}
			$categories = $dcl->get();
			$this->set('categories', $categories);
			$this->set('nav', $nav);
			
		}

	}