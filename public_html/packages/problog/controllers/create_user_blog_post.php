<?php       
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class CreateUserBlogPostController extends Controller {
	

	public $helpers = array('html','form');
	protected $posting_type = array('problog', 'user_blog_post', 'UserBlog Post', 'has posted a new Blog Entry %1$p', 1, 2);
	
	
	public function on_start() {
		Loader::model('page_list');
		$this->error = Loader::helper('validation/error');
		$html = Loader::helper('html');
		
		Loader::model('permissions');
		$u = new User();
		$pm = new Permissions($c);

		//if($pm->canAdmin() && $u->isSuperUser()){
			$this->addHeaderItem($html->css('ccm.app.css'));
			$this->addHeaderItem($html->css('ccm.base.css'));
			$this->addHeaderItem($html->css('jquery.ui.css'));
			
			$this->addHeaderItem($html->javascript('jquery.js'));
			$this->addHeaderItem($html->javascript('jquery.ui.js'));
			$this->addHeaderItem('<script type="text/javascript" src="' . REL_DIR_FILES_TOOLS_REQUIRED . '/i18n_js"></script>'); 
			$this->addHeaderItem($html->javascript('ccm.base.js'));
			$this->addFooterItem($html->javascript('ccm.app.js'));
			$this->addHeaderItem($html->javascript('tiny_mce/tiny_mce.js'));
		//}
		
		$this->addHeaderItem('<script type="text/javascript" src="/index.php/tools/required/i18n_js"></script>');
		//$this->addHeaderItem($html->javascript('tiny_mce_popup.js','problog'));
	}
	
	public function create_user_blog_page(){
		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		if (intval($ui->getUserBlogLocation())==0){
			$co = new Config;
			$pkg = Package::getByHandle('problog');
			$co->setPackageObject($pkg);
			$problog_root = Page::getByID($co->get("USER_BLOGS_PARENT_PAGE"));
			$problog_format = $co->get("USER_BLOG_PAGE_PATH_FORMAT");
			$txt = Loader::helper('text');
			$blogListCT = CollectionType::getByHandle('user_blog_list');
			$data = array();
			switch ($problog_format) {
				case 'username':
					$data['cName'] = $ui->getUserName();
					$data['cPath'] = $txt->sanitizeFileSystem($ui->getUserName());
					break;
				case 'userid':
					$data['cName'] = $ui->getUserID();
					$data['cPath'] = $data['cName'];
					break;
				case 'personname':
				default:
					$data['cName'] = $ui->getUserFirstName() . " " . $ui->getUserLastName() ;
					$data['cPath'] = $txt->sanitizeFileSystem($data['cName']);
					break;
			}
			$data['cDescription'] = $ui->getUserUserBio();
			$newBlog = $problog_root->add($blogListCT, $data);
			$newBlog->setAttribute('user_blog_section', 1);
			$newBlog->setAttribute('exclude_nav', 1);
			
			
			$ak = CollectionAttributeKey::getByHandle('hide_children_from_megamenu');
			if(is_object($ak)){
				$newBlog->setAttribute('hide_children_from_megamenu', 1);
			}
			$newBlogID = $newBlog->getCollectionID();
			$ui->setAttribute('blog_location', $newBlogID);
			$nh = Loader::helper('navigation');
			$newBlogURL = BASE_URL . $nh->getLinkToCollection($newBlog);
			$message = t("New user blog page created, url = %s", $newBlogURL);
			$this->set('message', $message);
		}
		$this->view();
	}
	
	public function view($userID = 0) {
		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		if (intval($ui->getUserBlogLocation())==0){
			$nh = Loader::helper('navigation');
			$this->redirect('/create_user_blog_post', 'create_user_blog_page');
		} else {
			$this->set("cParentID", $ui->getUserBlogLocation());	
		}
		$this->setupForm();
		
		if(!isset($this->ctID)){
			$this->set('ctID', CollectionType::getByHandle('user_blog_post')->getCollectionTypeID());
		}
				if(!ENABLE_USER_PROFILES) {
			$this->render("/page_not_found");
		}
		
		$this->setProfile($u);
	}
	
	
	protected function setProfile($u){
		$html = Loader::helper('html');
		$canEdit = false;

		if ($userID > 0) {
			$profile = UserInfo::getByID($userID);
			if (!is_object($profile)) {
				throw new Exception('Invalid User ID.');
			}
		} else if ($u->isRegistered()) {
			$profile = UserInfo::getByID($u->getUserID());
			$canEdit = true;
		} else {
			$this->set('intro_msg', t('You must sign in order to access this page!'));
			$this->render('/login');
		}
		
		$this->set('profile', $profile);
		$this->set('av', Loader::helper('concrete/avatar'));
		$this->set('t', Loader::helper('text'));
		$this->set('canEdit',$canEdit);
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
	
	public function blog_added() {
		$this->set('message', t('Blog added.'));
		$this->view();
	}
	
	public function blog_updated() {
		$this->set('message', t('Blog updated.'));
		$this->view();
	}

	public function editthis($cID) {
		
		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		
		$this->setProfile($u);
		
		if (intval($ui->getUserBlogLocation())==0){
			$nh = Loader::helper('navigation');
			$this->redirect('/create_user_blog_post', 'create_user_blog_page');
		} else {
			$this->set("cParentID", $ui->getUserBlogLocation());	
		}
		$this->setupForm();
		$blog = Page::getByID($cID);
		
		if ($this->isPost()) {
			$this->validate();
			if (!$this->error->has()) {
				$p = Page::getByID($this->post('blogID'));
				$parent = Page::getByID($this->post('cParentID'));
				$ct = CollectionType::getByID($this->post('ctID'));				
				$data = array('ctID' =>$ct->getCollectionTypeID(), 'cDescription' => $this->post('blogDescription'), 'cName' => $this->post('blogTitle'), 'cDatePublic' => Loader::helper('form/date_time')->translate('blogDate'));
				$p->update($data);
				if($this->post('draft')==true){
					$p->deactivate();
				}else{
					$p->activate();
				}
				if ($p->getCollectionParentID() != $parent->getCollectionID()) {
					$p->move($parent);
				}
				$this->saveData($p);
				$url = $p->getCollectionPath();
				$this->redirect($url);
			}
		}
		
		if ($blog->getCollectionParentID() == $ui->getUserBlogLocation()) {
			$this->set('blog', $blog);	
		} else {
			$this->redirect('/create_user_blog_post');
		}

	}

	protected function setupForm() {
		$this->addHeaderItem(Loader::helper('html')->javascript('tiny_mce/tiny_mce.js'));
	}

	public function addthis() {
		$u = new User();
		$this->setProfile($u);
		
		if($this->post('front_side')){
			$parent = Page::getByID($this->post('cParentID'));
			Loader::model("collection_types");
			$ct = CollectionType::getByID($this->post('ctID'));				
			$data = array('cName' => $this->post('blogTitle'), 'cDescription' => $this->post('blogDescription'), 'cDatePublic' => Loader::helper('form/date_time')->translate('blogDate'));
			$p = $parent->add($ct, $data);
			if($this->post('draft')==true){
				$p->deactivate();
			}
			$this->saveData($p);
			$this->redirect($this->post('return_url'), 'post_added');
		}else{
			$this->setupForm();
			if ($this->isPost()) {
				$this->validate();
				if (!$this->error->has()) {
					$parent = Page::getByID($this->post('cParentID'));
					$ct = CollectionType::getByID($this->post('ctID'));				
					$data = array('cName' => $this->post('blogTitle'), 'cDescription' => $this->post('blogDescription'), 'cDatePublic' => Loader::helper('form/date_time')->translate('blogDate'));
					$p = $parent->add($ct, $data);
					if($this->post('draft')==true){
						$p->deactivate();
					}
					$this->saveData($p);
					
					// we try to load the lerteco_wall package and then check if it's available
					$wall = Loader::package('lerteco_wall');
					if ($wall && $wall->isPackageInstalled()) {
						$u = new User();
						$uID = $u->getUserID();
					    //it's installed. now we call the single method which creates the posting and, if necessary, the posting type
					    $wall->postAndPossiblyRegister($uID, $p->getCollectionID(), $this->posting_type);
					}
					
					
					$url = $p->getCollectionPath();
					$this->redirect($url);
				}
			}
		}
	}


	protected function validate() {
	
		$vt = Loader::helper('validation/strings');
		$vn = Loader::Helper('validation/numbers');
		$dt = Loader::helper("form/date_time");
		if (!$vt->notempty($this->post('cParentID'))) {
			$this->error->add(t('You must choose a parent page for this blog entry.'));
		}			

		if (!$vt->notempty($this->post('ctID'))) {
			$this->error->add(t('You must choose a page type for this blog entry.'));
		}			
		
		if (!$vt->notempty($this->post('blogTitle'))) {
			$this->error->add(t('Title is required'));
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
	}
	
	
	private function saveData($p) {
	
		$blocks = $p->getBlocks('Main');
		foreach($blocks as $b) {
			if($b->getBlockTypeHandle()=='content'){
				$b->deleteBlock();
			}
		}
		
		$faves_set = false;
		$blocks = $p->getBlocks('FavBar');
		foreach($blocks as $b) {
			if($b->getBlockTypeHandle()=='favorites_button'){
				$faves_set = true;
			}
		}

		Loader::model("attribute/categories/collection");
		$cak = CollectionAttributeKey::getByHandle('tags');
		$cak->saveAttributeForm($p);	
		
		$cck = CollectionAttributeKey::getByHandle('blog_category');
		$cck->saveAttributeForm($p);
		
		$cnv = CollectionAttributeKey::getByHandle('exclude_nav');
		$cnv->saveAttributeForm($p);
		
		$ct = CollectionAttributeKey::getByHandle('thumbnail');
		$ct->saveAttributeForm($p);
		
		$ca = CollectionAttributeKey::getByHandle('blog_author');
		$ca->saveAttributeForm($p);
		

		//remove for commercial version
		$shareWith = $_POST['share_with'];
		if (strlen($shareWith)>0){
			$p->setAttribute('share_with', $shareWith);
		} else {
			$p->setAttribute('share_with', 'all');
		}
		
		/*
		if(!$faves_set){
			Loader::model('attribute/categories/user');
			$ak = UserAttributeKey::getByHandle('my_faves');
			$bt = BlockType::getByHandle('favorites_button');
			$data = array(
				'cID' => $p->getCollectionID(),
				'akID' => $ak->akID,
				'name' => 'iFavorites',
				'ticker' => 0
			);		
					
			$p->addBlock($bt, 'FavBar', $data);
		}
		*/
		
		$bt = BlockType::getByHandle('content');
		if(empty($_POST['blogBody'])){$content = ' ';}else{$content = $_POST['blogBody'];}
		$data = array('content' => $content);		
					
		$p->addBlock($bt, 'Main', $data);
		
		$p->reindex();
       
       $block = $p->getBlocks('Main');
		foreach($block as $b) {
			if($b->getBlockTypeHandle()=='content'){
				$b->setCustomTemplate('user_blog_post');
				$b->setBlockDisplayOrder('+1');
				$b->setBlockDisplayOrder('+1');
			}
		}
			
	}

	
	public function on_before_render() {
		$this->set('error', $this->error);
	}
	
}