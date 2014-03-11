<?php       
defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('page_list');
/**
*
* An object that allows a filtered list of blogs to be returned.
* @package ProBlog
*
**/
class ProblogList extends PageList {

	public function sortByPublicDateTime(){
		$this->sortBy('cvDatePublic', 'desc');
	}

}