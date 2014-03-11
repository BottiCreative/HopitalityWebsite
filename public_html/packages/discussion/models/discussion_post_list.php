<?php 

class DiscussionPostList extends PageList {

	public function __construct() {
		$this->filterByCollectionTypeHandle('discussion_post');
		if (version_compare(APP_VERSION, '5.5.2.2','gt')) {
			$this->ignoreAliases();
		}
		$this->sortBy('cvDatePublic', 'asc');
	}

	public function loadPageID($cID) {
		return DiscussionPostModel::getByID($cID);
	}
/*
	public function get($itemsToGet,$offset) { //change the get for the dbitemlist to see if you can get whatever the current query is back from that.
		echo "ok: ";
		$q = $this->getQuery();
		echo $this->query;

		var_dump($q);
		return parent::get($itemsToGet,$offset);
	}
	*/
}
