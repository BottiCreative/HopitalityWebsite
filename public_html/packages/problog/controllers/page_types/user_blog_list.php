<?php     

defined('C5_EXECUTE') or die("Access Denied.");

class UserBlogListPageTypeController extends Controller {
	
	public function on_page_add($c) {
		
		$parentCID = $c->getCollectionID();
		
		$aBlocks = $c->getBlocks("Main");
		foreach ($aBlocks as $block) {
			if ($block->getBlockTypeHandle() == "user_blog_list"){
				$newBlock = $block->duplicate($c);
				$cnt = Loader::controller($newBlock);
				$cnt->updateParentID($parentCID);
				$block->delete();
			}
		}
	}
	
}
?>