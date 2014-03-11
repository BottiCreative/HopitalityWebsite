<?php 

class DiscussionCategoryList extends PageList {
	
	public function __construct() {
		$this->filterByCollectionTypeHandle('discussion');
	}
	

	public function loadPageID($cID) {
		return DiscussionModel::getByID($cID);
	}

}
