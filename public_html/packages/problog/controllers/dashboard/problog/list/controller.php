<?php       
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardProblogListController extends Controller {
	
	public $num = 15;
	
	public $helpers = array('html','form');
	
	public function on_start() {
		Loader::model('page_list');
		$this->error = Loader::helper('validation/error');
	}
	
	public function view() {
	
		$this->loadblogSections();
		$blogList = new PageList();
		//$blogList->displayUnapprovedPages();
		$blogList->includeInactivePages(true);
		$blogList->sortBy('cDateAdded', 'desc');
			if(isset($_GET['cParentID']) && $_GET['cParentID'] > 0){
				$path = Page::getByID($_GET['cParentID'])->getCollectionPath();
				$blogList->filterByPath($path);
			}
			
			$blogList->filter(false,"(CHAR_LENGTH(cv.cvName) > 4 OR cv.cvName NOT REGEXP '^[0-9]')");
			
			if(empty($_GET['cParentID'])){
				$sections = $this->get('sections');
				$keys = array_keys($sections);
				if(is_array($keys)){
					foreach($keys as $id){
						if($fs){$fs .= ' OR ';}
						$path = Page::getByID($id)->getCollectionPath().'/';
						$fs .= "PagePaths.cPath LIKE '$path%'";
					}
					$blogList->filter(false,"($fs)");
				}
			}
			
			$blogList->displayUnapprovedPages();
			
			if(!empty($_GET['like'])){
				$blogList->filterByName($_GET['like']);
			}
			
			if($_GET['only_unaproved'] > 0){
				$blogList->filter(false,"p1.cIsActive != 1");
			}

			$blogList->setItemsPerPage($this->num);
			
			if(!empty($_GET['cat'])){
				$cat = $_GET['cat'];
				$blogList->filter(false,"ak_blog_category LIKE '%\n$cat\n%'");
			}
			
			if(!empty($_GET['tag'])){
				$tag = $_GET['tag'];
				$blogList->filter(false,"ak_tags LIKE '%\n$tag\n%'");
			}
			//$blogList->debug();
			$blogResults=$blogList->getPage();
			


		$this->set('blogResults', $blogResults);
		$this->set('blogList', $blogList);
		$this->set('cat_values', $this->getblogCats());
		$this->set('tag_values', $this->getblogTags());
		
	}

	protected function loadblogSections() {
		$blogSectionList = new PageList();
		$blogSectionList->setItemsPerPage($this->num);
		$blogSectionList->filterByBlogSection(1);
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