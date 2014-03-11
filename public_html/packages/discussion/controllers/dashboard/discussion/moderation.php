<?php 
Loader::model('page_list');
Loader::model('discussion','discussion');
Loader::model('discussion_post','discussion');
Loader::model('discussion_post_list','discussion');

class DashboardDiscussionModerationController extends Controller {

	public function view() {
		$html = Loader::helper('html');
		$form = Loader::helper('form');
		$this->set('form', $form);
		$this->addHeaderItem($html->javascript('moderation_search.js','discussion'));
		$postList = $this->getRequestedSearchResults();
		$this->set('postList', $postList);	
		$this->set('posts',$postList->getPage());
		$this->set('pagination', $postList->getPagination());
		// mark moderation as viewed
		$pkg = Package::getByHandle('discussion');
		$pkg->saveConfig('MODERATION_NEW_MESSAGES', 0);
		
	}

	
	public function getRequestedSearchResults() {
		$postList = new DiscussionPostList();
		$postList->displayUnapprovedPages();
		//@TODO test in pre-5.6 if (version_compare(APP_VERSION, '5.5.2.2','gt')) {
		$postList->addToQuery("LEFT JOIN Users ON Users.uID = p1.uID");
		
		$postList->filterByAttribute('discussion_post_not_displayed',1);
		
		if ($_GET['keywords'] != '') {
			$postList->filterByKeywords($_GET['keywords']);
		}	
		
		if ($_REQUEST['numResults']) {
			$postList->setItemsPerPage($_REQUEST['numResults']);
		}
		
		switch($_REQUEST['ccm_order_by']) {
			case 'date_added':
				$postList->sortBy('cDateAdded', $_REQUEST['ccm_order_dir']);
			break;
			case 'post_user':
				$postList->sortBy('Users.uName', $_REQUEST['ccm_order_dir']);
			break;
			case 'post_title':
				$postList->sortBy('cvName', $_REQUEST['ccm_order_dir']);
			break;
			default:
				$postList->sortBy('cDateAdded', 'desc');
			break;
		}
		return $postList;
	}

	
	public function moderate_posts() {
		$postIDs = $this->post('postIDs');
		if(is_array($postIDs) && count($postIDs)) {
			switch($this->post('posts_action')) {
				case "delete";
					$deleted = 0;
					foreach($postIDs as $pID) {
						$post = DiscussionPostModel::getByID($pID);
						if(is_object($post)) { //&& $post->getCollectionTypeHandle() == 'discussion_post') {
							$post->delete();
							$deleted++;
						}
					} 
					$msg = $deleted .' '.t('posts deleted');
					if ($deleted == 1) {
						$msg = $deleted.' '.t('post deleted');
					}
				break;
				case "approve";
					$approved = 0;
					foreach($postIDs as $pID) {
						$post = DiscussionPostModel::getByID($pID);
						//if(is_object($post) && $post->getCollectionTypeHandle() == 'discussion_post') { //@TODO unapproved versions don't return ctHandle
						if($post instanceof DiscussionPostModel) {
							$v = CollectionVersion::get($post, 'RECENT');
							$v->approve();
							//$v = $post->getVersionObject();
							//$v = $post->getVersionToModify();
							//$v->approve();
							$post = DiscussionPostModel::getByID($post->getCollectionID());
							if(is_object($post)) {
								$post->setAttribute('discussion_post_not_displayed',0);
								$post->incrementCounts(true);
								// do the tracking stuff
								$this->doTracking($post);
							}
							$approved++;
						}
					}
					$msg = $approved . t(' posts approved');
				break;
				default:
					$msg = t('Invalid action specified.');
				break;
			} 
			
		}
		$this->redirect('/dashboard/discussion/moderation','moderated',urlencode($msg));
	}
	
	public function moderated($msg) {
		$this->set('message',urldecode($msg));
		$this->view();
	}
	
	protected function doTracking($dpm) {
		Loader::model('discussion_track','discussion');
		$nh = Loader::helper('navigation');
		
		$post 	= $dpm->getPost();
		$user 	= $dpm->getUserObject();
		$d 		= $dpm->getDiscussion();
		$posted_title = $dpm->getCollectionName();
		$posted_body = 	$dpm->getPlainTextBody();
		
		if($dpm->getCollectionID() != $post->getCollectionID()) {
			$postLink = $nh->getCollectionURL($post)."#".$dpm->getCollectionID();
		} else {
			$postLink = $nh->getCollectionURL($post);
		}
		
		$dTrack = new DiscussionTrack($post);
		$dTrack->setUrl($postLink);
		$dTrack->discussionHasChanged($user->getUserID(), $posted_title, $posted_body, $post->getCollectionName(), $dpm);
		
		
		// track the post for the top level forum, if it's not in edit mode.
		if (is_object($d)) {
			$topdTrack = new DiscussionTrack($d);
			$topdTrack->setUrl($postLink);
			$topdTrack->discussionHasChanged($user->getUserID(), $posted_title, $posted_body, $post->getCollectionName(), $dpm);
		}
	}
	
}
