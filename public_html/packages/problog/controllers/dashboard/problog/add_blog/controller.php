<?php       
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardProblogAddBlogController extends Controller {
	

	public $helpers = array('html','form');
	protected $posting_type = array('problog', 'problog_post', 'ProBlog Post', 'has posted a new Blog Entry %1$p', 1, 2);
	
	public function on_start() {
		Loader::model('page_list');
		Loader::model('attribute/categories/collection');
		$html = Loader::helper('html');
		$this->error = Loader::helper('validation/error');
		//$this->addHeaderItem($html->javascript('tiny_mce_popup.js','problog'));
		$this->addHeaderItem($html->css('css/font-awesome.css','problog'));
		$this->addHeaderItem($html->css('css/seo_tools.css','problog'));
		$this->addHeaderItem($html->javascript('seo_tools.js','problog'));
	}
	
	public function view() {
		$blogify = Loader::helper('blogify','problog');
		Loader::model("attribute/categories/collection");
		Loader::model("collection_types");
		Loader::model('page_list');
		$settings = $blogify->getBlogSettings();
		$this->set('settings',$settings);
		$this->setupForm();
		$blogList = new PageList();
		$blogList->sortBy('cDateAdded', 'desc');
		if (isset($_GET['cParentID']) && $_GET['cParentID'] > 0) {
			$blogList->filterByParentID($_GET['cParentID']);
		} else {
			$sections = $this->get('sections');
			$keys = array_keys($sections);
			$keys[] = -1;
			$blogList->filterByParentID($keys);
		}
	}
	

	protected function loadblogSections() {
		$blogSectionList = new PageList();
		$blogSectionList->filterByBlogSection(1);
		$blogSectionList->sortBy('cvName', 'asc');
		$tmpSections = $blogSectionList->get();
		$sections = array();
		foreach($tmpSections as $_c) {
			$sections[$_c->getCollectionID()] = $_c->getCollectionName();
		}
		$this->set('sections', $sections);
	}
	
	
	protected function loaduserBlogSections() {
		$pkg = Package::getByHandle('problog');
		if($pkg){
			$blogSectionList = new PageList();
			$blogSectionList->filterByUserBlogSection(1);
			$blogSectionList->sortBy('cvName', 'asc');
			$tmpSections = $blogSectionList->get();
			$sections = array();
			foreach($tmpSections as $_c) {
				$sections[$_c->getCollectionID()] = $_c->getCollectionName();
			}
			$this->set('user_sections', $sections);
		}
	}
	
	protected function setupForm() {
		$this->loadblogSections();
		$ubp = Page::getByPath('/profile/user_blog');
		if($ubp->cID){
			$this->loaduserBlogSections();
		}
		Loader::model("collection_types");
		$ctArray = CollectionType::getList('');
		$pageTypes = array();
		foreach($ctArray as $ct) {
			$pageTypes[$ct->getCollectionTypeID()] = $ct->getCollectionTypeName();		
		}
		$this->set('pageTypes', $pageTypes);
		$this->addHeaderItem(Loader::helper('html')->javascript('tiny_mce/tiny_mce.js'));
	}



	public function edit($cID) {
		$this->setupForm();
		
		$blog = Page::getByID($cID);
		$date = $blog->getCollectionDatePublic();
		
		$canonical_parent_id = Loader::helper('blogify','problog')->getCanonicalParent($date,$blog);
		
		$newdate = Loader::helper('form/date_time')->translate('blogDate');

		if ($this->isPost()) {
			$this->validate();
			if (!$this->error->has()) {
				$p = Page::getByID($this->post('blogID'));
				$parent = Page::getByID($this->post('cParentID'));
				$ct = CollectionType::getByID($this->post('ctID'));				
				$data = array('ctID' =>$ct->getCollectionTypeID(), 'cDescription' => $this->post('blogDescription'), 'cName' => $this->post('blogTitle'), 'cDatePublic' => $newdate);
				$p->update($data);
				
				if($this->post('draft')==1 || $this->post('draft')==2){
					$p->deactivate();
					$p->getVersionObject()->deny();
					if($this->post('draft')==2){
						Loader::helper('blog_actions','problog')->send_publish_request($p);
					}
				}else{
					$p->getVersionObject()->approve();
					$p->activate();
				}
				
				if ($canonical_parent_id != $parent->getCollectionID() || $date != $newdate) {
					$canonical = Loader::helper('blogify','problog')->getOrCreateCanonical($newdate,$parent);
					$p->move($canonical);
				}
				$this->saveData($p);
				if(!$this->post('save_post')){
					$this->redirect('/dashboard/problog/list/', 'blog_updated');
				}
			}
		}
		
		$sections = $this->get('sections');
		$user_sections = $this->get('user_sections');

		if (in_array($canonical_parent_id, array_keys($sections)) || in_array($canonical_parent_id, array_keys($user_sections))) {
			$this->set('blog', $blog);	
			$this->set('cParentID',$canonical_parent_id);
		} else {
			$this->redirect('/dashboard/problog/add_blog/');
		}

	}

	public function add() {

		$this->setupForm();
		if ($this->isPost()) {
			$this->validate();
			if (!$this->error->has()) {
				$date = Loader::helper('form/date_time')->translate('blogDate');
				$parent = Page::getByID($this->post('cParentID'));
				$canonical = Loader::helper('blogify','problog')->getOrCreateCanonical($date,$parent);

				$ct = CollectionType::getByID($this->post('ctID'));				
				$data = array('cName' => $this->post('blogTitle'), 'cDescription' => $this->post('blogDescription'), 'cDatePublic' => $date);
				$p = $canonical->add($ct, $data);

				if($this->post('draft')==1 || $this->post('draft')==2){
					$p->deactivate();
					if($this->post('draft')==2){
						Loader::helper('blog_actions','problog')->send_publish_request($p);
					}
				}
				
				$this->saveData($p);
				
				// we try to load the lerteco_wall package and then check if it's available
				$wall = Loader::package('lerteco_wall');
				if (is_object($wall)) {
					if($wall->isPackageInstalled()){
						$ak = CollectionAttributeKey::getByHandle('blog_author');
						if($this->post('user_pick_'.$ak->akID)>0){
							$uID = $this->post('user_pick_'.$ak->akID);
						}else{
							$u = new User();
							$uID = $u->getUserID();
						}
					    //it's installed. now we call the single method which creates the posting and, if necessary, the posting type
					    $wall->postAndPossiblyRegister($uID, $p->getCollectionID(), $this->posting_type);
					}
				}
				if(!$this->post('save_post')){
					$this->redirect('/dashboard/problog/list/', 'blogadded');
				}
			}
		}
	}
	



	protected function validate() {
		$vt = Loader::helper('validation/strings');
		$vn = Loader::Helper('validation/numbers');
		$dt = Loader::helper("form/date_time");
		if (!$vn->integer($this->post('cParentID'))) {
			$this->error->add(t('You must choose a parent page for this blog entry.'));
		}			

		if (!$vn->integer($this->post('ctID'))) {
			$this->error->add(t('You must choose a page type for this blog entry.'));
		}			
		
		if (!$vt->notempty($this->post('blogTitle'))) {
			$this->error->add(t('Title is required'));
		}
		
		if(!$this->get('sections')){
			$this->error->add(t('You must have at least one page in your website designated as a "blog section".'));
		}

		Loader::model("attribute/categories/collection");

		
		$akct = CollectionAttributeKey::getByHandle('blog_category');
		$ctKey = $akct->getAttributeKeyID();
		foreach($this->post(akID) as $key => $value){
			if($key==$ctKey){
				foreach($value as $type => $values){
					if($type=='atSelectNewOption'){
						foreach($values as $cat => $valued){
							if($valued==''){
								$this->error->add(t('Categories must have a value'));	
							}
						}
					}
				}
			}
		}

		if (!$this->error->has()) {
			Loader::model('collection_types');
			$ct = CollectionType::getByID($this->post('ctID'));				
			$parent = Page::getByID($this->post('cParentID'));				
			$parentPermissions = new Permissions($parent);
			if (!$parentPermissions->canAddSubCollection($ct)) {
				$this->error->add(t('You do not have permission to add a page of that type to that area of the site.'));
			}
		}
	}
	
	
	private function saveData($p) {
	
		$blocks = $p->getBlocks('Main');
		foreach($blocks as $b) {
			if($b->getBlockTypeHandle()=='content' || $b->getBlockTypeHandle()=='sb_add_blog'){
				$b->deleteBlock();
			}
		}
		
		//remove for commercial version
		$shareWith = $_REQUEST['share_with'];
		if($shareWith){
			if (strlen($shareWith)>0){
				$p->setAttribute('share_with', $shareWith);
			} else {
				$p->setAttribute('share_with', 'all');
			}
		}

		Loader::model("attribute/categories/collection");
		$cak = CollectionAttributeKey::getByHandle('tags');
		$cak->saveAttributeForm($p);	
		
		$cck = CollectionAttributeKey::getByHandle('meta_title');
		$cck->saveAttributeForm($p);
		
		$cck = CollectionAttributeKey::getByHandle('meta_description');
		$cck->saveAttributeForm($p);
		
		$cck = CollectionAttributeKey::getByHandle('meta_keywords');
		$cck->saveAttributeForm($p);
		
		$cck = CollectionAttributeKey::getByHandle('blog_category');
		$cck->saveAttributeForm($p);
		
		$cnv = CollectionAttributeKey::getByHandle('exclude_nav');
		$cnv->saveAttributeForm($p);
		
		$ct = CollectionAttributeKey::getByHandle('thumbnail');
		$ct->saveAttributeForm($p);
		
		$ca = CollectionAttributeKey::getByHandle('blog_author');
		$ca->saveAttributeForm($p);
		
		$set = AttributeSet::getByHandle('problog_additional_attributes');
		$setAttribs = $set->getAttributeKeys();
		if($setAttribs){
			foreach ($setAttribs as $ak) {
				$aksv = CollectionAttributeKey::getByHandle($ak->akHandle);
				$aksv->saveAttributeForm($p);
			}	
		}
		
		$bt = BlockType::getByHandle('content');
		if(empty($_POST['blogBody'])){$content = ' ';}else{$content = $_POST['blogBody'];}
		$data = array('content' => $content);		
		$b = $p->addBlock($bt, 'Main', $data);
		$b->setCustomTemplate('blog_post');
		$b->setBlockDisplayOrder('+1');
		$b->setBlockDisplayOrder('+1');
		
		$ba = Loader::helper('blog_actions','problog');
		
		$ba->doScrape($p,$content);
		$ba->doTweet($p,$this->post('twitter_hash'));
		$ba->doSubscription($p);
		
		Events::fire('on_problog_submit', $p);
			
		$p->reindex();
			
	}
	
	
	public function on_before_render() {
		$this->set('error', $this->error);
	}
	
}