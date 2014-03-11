<?php     

defined('C5_EXECUTE') or die("Access Denied.");

class UserBlogPostPageTypeController extends Controller {
	
	public function on_page_add($c) {
		
		$parentCID = $c->getCollectionParentID();
		
		$aBlocks = $c->getBlocks("Sidebar");
		foreach ($aBlocks as $block) {
			if ($block->getBlockTypeHandle() == "user_blog_list"){
				$newBlock = $block->duplicate($c);
				$cnt = Loader::controller($newBlock);
				$cnt->updateParentID($parentCID);
				$block->delete();
			}
		}
	}
	
	public function on_start(){
		$u = new User();
		$html = Loader::helper('html');
		if($u->isLoggedIn()){
		  	$v = View::getInstance();
			$v->addHeaderItem($html->css('ccm.app.css'));
			$v->addHeaderItem($html->javascript('jquery.ui.js'));
			$v->addHeaderItem($html->javascript('ccm.dialog.js'));
			$v->addHeaderItem($html->css('ccm.dialog.css'));
			$v->addHeaderItem($html->css('jquery.ui.css'));
		}
	}
	
}
?>