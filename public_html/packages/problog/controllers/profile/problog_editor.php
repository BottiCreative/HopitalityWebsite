<?php       
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class ProfileProblogEditorController extends Controller {

	public function view($id=null){
		
		
		$html = Loader::helper('html');
		$this->addHeaderItem($html->javascript('tiny_mce/tiny_mce.js'));	
		$this->addFooterItem($html->javascript('jquery.ui.js'));
		$this->addHeaderItem('<script type="text/javascript" src="' . REL_DIR_FILES_TOOLS_REQUIRED . '/i18n_js"></script>'); 
		$this->addFooterItem($html->javascript('ccm.app.js'));
		$this->addFooterItem($html->javascript('bootstrap.js'));
		$this->addHeaderItem($html->css('ccm.app.css'));	
		
		$blogify = Loader::helper('blogify','problog');
		Loader::model("attribute/categories/collection");
		Loader::model("collection_types");
		Loader::model('page_list');
		

		$this->set('settings',$blogify->getBlogSettings());
		$this->set('AJAXeventPost',BASE_URL.Loader::helper('concrete/urls')->getToolsURL('post_blog.php','problog'));
		$this->set('df',Loader::helper('form/date_time'));
		$this->set('nh',Loader::helper('navigation'));
		$this->set('form',Loader::helper('form'));
	
		$blogSectionList = new PageList();
		$blogSectionList->filterByBlogSection(1);
		$blogSectionList->sortBy('cvName', 'asc');
		$tmpSections = $blogSectionList->get();
		$sections = array();
		foreach($tmpSections as $_c) {
			$sections[$_c->getCollectionID()] = $_c->getCollectionName();
		}
		$this->set('sections',$sections);
		
		
		$ctArray = CollectionType::getList('');
		$pageTypes = array();
		foreach($ctArray as $ct) {
			$pageTypes[$ct->getCollectionTypeID()] = $ct->getCollectionTypeName();		
		}
		$this->set('pageTypes',$pageTypes);
		
		if($id){
			$keys = array_keys($sections);
			$keys[] = -1;
			Loader::model('page');
			$current_page = Page::getByID($id);
			$canonical_parent_id = Loader::helper('blogify','problog')->getCanonicalParent($current_page->getCollectionDatePublic(),$current_page);
			if(in_array($canonical_parent_id, $keys)){
				$blog = $current_page;
				$this->set('blog',$blog);
			}
		}
		
		$drafts = array();
		foreach($tmpSections as $_c) {
			$pID = $_c->getCollectionID();
			$spl = new PageList();
			//$spl->filterByParentID($pID);
			$path = Page::getByID($pID)->getCollectionPath();
			$spl->filterByPath($path);
			$spl->filter(false,"cv.cvName NOT REGEXP '^[0-9]'");
			$spl->includeInactivePages();
			$spl->displayUnapprovedPages();
			$spl->filter(false,"p1.cIsActive = 0");
			//$spl->debug();
			$draft_list = $spl->get();
			foreach($draft_list as $draft_item){
				$drafts[] = $draft_item;
			}
		}
		$this->set('drafts',$drafts);
	}
	
	public function approvethis($cIDd,$name) {
		$p = Page::getByID($cIDd);
		$p->activate();
		$this->set('message', t('"'.$name.'" has been approved and is now public')); 
		$this->view();
	}
	
	public function post_added(){
		$this->set('message', t('Your post has been added')); 
		$this->view();
	}
	
	public function delete_check($cIDd,$name) {
		$this->set('remove_name',$name);
		$this->set('remove_cid',$cIDd);
		$this->view();
	}
	
	public function deletethis($cIDd,$name) {
		$c= Page::getByID($cIDd);
		$c->delete();
		$this->set('message', t('"'.$name.'" has been deleted')); 
		$this->set('remove_name','');
		$this->set('remove_cid','');
		$this->view();
	}
	
	public function clear_warning(){
		$this->set('remove_name','');
		$this->set('remove_cid','');
		$this->view();
	}
}
?>