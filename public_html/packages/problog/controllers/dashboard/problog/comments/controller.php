<?php       
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardProblogCommentsController extends Controller {

	public $helpers = array('html','form');
	
	public function on_start() {
		Loader::model('page_list');
		//$this->error = Loader::helper('validation/error');
	}
	
	public function view() {
		$this->loadblogSections();
		$blogList = new PageList();
		$sections = $this->get('sections');
		$keys = array_keys($sections);
		$comments = $this->getCommentsByParentIDs($keys);
		$this->set('comments', $comments);
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
	
	
	public function getCommentsByParentIDs($IDs){
		$db = Loader::db();
		$child_pages = array();
		
		$blogList = new PageList();
		$blogList->sortBy('cDateAdded', 'desc');
		$blogList->filter(false,"(CHAR_LENGTH(cv.cvName) > 4 OR cv.cvName NOT REGEXP '^[0-9]')");

		if(is_array($IDs)){
			foreach($IDs as $id){
				if($fs){$fs .= ' OR ';}
				$path = Page::getByID($id)->getCollectionPath().'/';
				$fs .= "PagePaths.cPath LIKE '$path%'";
			}
			$blogList->filter(false,"($fs)");
		}
		$blogList->filter(false,"(CHAR_LENGTH(cv.cvName) > 4 OR cv.cvName NOT REGEXP '^[0-9]')");
		$blogResults=$blogList->get();
		
		foreach($blogResults as $result){
			$child_pages[] = $result->getCollectionID();
		}
		
		$r = $db->EXECUTE("SELECT * FROM btGuestBookEntries ORDER BY entryDate DESC");
		$comments = array();
		
		while($row=$r->fetchrow()){
			$ccObj = Page::getByID($row['cID']);
			$pID = $ccObj->getCollectionID();
			//var_dump($pID.' - '.print_r($child_pages));
			if(in_array($pID, $child_pages)){
				$comments[] = $row;
			}
		}

		return $comments;
	}
	
	public function comment_proccess(){
		$db = Loader::db();
		
		$comments = array_keys($this->post('comment_do'));
		
		$doit = $this->post('comment_todo');
		switch($doit){
			case 'approve':
				foreach($comments as $commentID){
					$db->execute("UPDATE btGuestBookEntries SET approved = 1 WHERE entryID = $commentID");
				}
				break;
			case 'unapprove':
				foreach($comments as $commentID){
					$db->execute("UPDATE btGuestBookEntries SET approved = 0 WHERE entryID = $commentID");
				}
				break;
			case 'remove':
				foreach($comments as $commentID){
					$db->execute("DELETE FROM btGuestBookEntries WHERE entryID = $commentID");
				}
				break;
		}
		$this->view();
	}
}
?>