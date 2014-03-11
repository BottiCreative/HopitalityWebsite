<?php      
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardProblogListShowUserBlogsController extends Controller {
	
	public $num = 15;
	
	public $helpers = array('html','form');
	
	public function on_start() {
		Loader::model('page_list');
		$this->error = Loader::helper('validation/error');
	}
	
	public function view() {
		$this->loadblogSections();
		$blogList = new PageList();
		$blogList->displayUnapprovedPages();
		$blogList->sortBy('cDateAdded', 'desc');
			if(isset($_GET['cParentID']) && $_GET['cParentID'] > 0){
			$blogList->filterByParentID($_GET['cParentID']);
			}
			if(empty($_GET['cParentID'])){
			$sections = $this->get('sections');
			$keys = array_keys($sections);
			$keys[] = -1;
			$blogList->filterByParentID($keys);
			}
			if(!empty($_GET['like'])){
			$blogList->filterByName($_GET['like']);
			}

			$blogList->setItemsPerPage($this->num);
		
		$blogResults=$blogList->getPage();
			if(!empty($_GET['cat'])){
                Loader::model('/attribute/categories/collection');
				$pageList = $blogResults;
				$blogResults = array();
				foreach($pageList as $page){
                    $aklc = CollectionAttributeKey::getByHandle('blog_category');
                    $blogCat = $page->getCollectionAttributeValue($aklc);
                    if(is_a($blogCat,'SelectAttributeTypeOptionList')){
                        $blogCat = $page->getCollectionAttributeValue($aklc)->current()->value;
                    }else{
                        $blogCat = $page->getCollectionAttributeValue($aklc)->value;
                    }
  	 				if($blogCat == $_GET['cat']) {
      					array_push($blogResults, $page);   
   					}
				}
				
			}
			if(!empty($_GET['tag'])){
                Loader::model('/attribute/categories/collection');
				$pageList = $blogResults;
				$blogResults = array();
				foreach($pageList as $page){
                    $aklc = CollectionAttributeKey::getByHandle('tags');
                    $blogTag = $page->getCollectionAttributeValue($aklc);
                 
                    if(is_object($blogTag)){
                    foreach($blogTag as $tag){
               
                      if($tag == $_GET['tag']) {
                          array_push($blogResults, $page);
                      }

                    }
                    }else{
                 
                      if($blogTag == $_GET['tag']) {
                          array_push($blogResults, $page);
                      }
                    }
				}
				
			}
		$this->set('blogResults', $blogResults);
		$this->set('blogList', $blogList);
		$this->set('cat_values', $this->getblogCats());
		$this->set('tag_values', $this->getblogTags());
		
	}

	protected function loadblogSections() {
		$blogSectionList = new PageList();
		$blogSectionList->setItemsPerPage($this->num);
		$blogSectionList->filterByUserBlogSection(1);
		$blogSectionList->sortBy('cvName', 'asc');
		$tmpSections = $blogSectionList->get();
		$sections = array();
		foreach($tmpSections as $_c) {
			$sections[$_c->getCollectionID()] = $_c->getCollectionName();
		}
		$this->set('sections', $sections);
	}
	
	public function delete_check($cIDd,$name) {
		$this->set('remove_name',$name);
		$this->set('remove_cid',$cIDd);
		$this->view();
	}
	
	public function approvethis($cIDd,$name) {
		$p = Page::getByID($cIDd);
		$p->activate();
		$this->set('message', t('"'.$name.'" has been approved and is now public')); 
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
	
	
	public function getblogCats(){
		$db = Loader::db();
		$akID = $db->query("SELECT akID FROM AttributeKeys WHERE akHandle = 'blog_category'");
		while($row=$akID->fetchrow()){
			$akIDc = $row['akID'];
		}
		$akv = $db->execute("SELECT value FROM atSelectOptions WHERE akID = $akIDc");
		while($row=$akv->fetchrow()){
			$values[]=$row;
		}
		if (empty($values)){
			$values = array();
		}
		return $values;
	}
	
	
	public function getblogTags(){
		$db = Loader::db();
		$akID = $db->query("SELECT akID FROM AttributeKeys WHERE akHandle = 'tags'");
		while($row=$akID->fetchrow()){
			$akIDc = $row['akID'];
		}
		$akv = $db->execute("SELECT value FROM atSelectOptions WHERE akID = $akIDc");
		while($row=$akv->fetchrow()){
			$values[]=$row;
		}
		if (empty($values)){
			$values = array();
		}
		return $values;
	}
	
	
	public function blogadded() {
		$this->set('message', t('Blog added.'));
		$this->view();
	}
	
	public function blog_updated() {
		$this->set('message', t('Blog updated.'));
		$this->view();
	}
	
	
	
}