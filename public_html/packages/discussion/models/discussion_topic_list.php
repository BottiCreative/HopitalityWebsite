<?php 

class DiscussionTopicList extends PageList {

	protected $autoSortColumns = array('cvName', 'cvDatePublicLastPost', 'cvDatePublic', 'totalViews', 'totalPosts');
	protected $itemsPerPage = 10;

	public function __construct() {
		$this->filterByCollectionTypeHandle('discussion_post');
		if (version_compare(APP_VERSION, '5.5.2.2','gt')) {
			$this->ignoreAliases();
		}
		$this->addToQuery("left join DiscussionSummary ds on p1.cID = ds.cID");
	}

	public function setBaseQuery() {
		parent::setBaseQuery(', if (ds.lastPostCID = 0, cvDatePublic, (select cvDatePublic from CollectionVersions where cID = ds.lastPostCID and cvIsApproved = 1)) as cvDatePublicLastPost');
	}

	public function loadPageID($cID) {
		return DiscussionPostModel::getByID($cID);
	}

}