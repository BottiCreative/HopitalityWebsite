<?php 
Loader::model('discussion', 'discussion');
Loader::model('discussion_post', 'discussion');

$db = Loader::db();


$query = "SELECT Pages.cID, cDateAdded 
		FROM Pages 
		INNER JOIN Collections c on c.cID = Pages.cID 
		INNER JOIN CollectionVersions cv ON (Pages.cID = cv.cID and cv.cvIsApproved = 1)
		INNER JOIN PageTypes on Pages.ctID = PageTypes.ctID  
		WHERE PageTypes.ctHandle = ? ORDER BY cDateAdded";


echo "<h3>".t('Discussion')."</h3><hr/>";

$discussions = $db->getAll($query,array('discussion'));

foreach($discussions as $d) {
	$dm = DiscussionModel::getByID($d['cID']);
	$data = $dm->getNewSummaryData();
	
	echo $dm->getCollectionName()."<br/>";
	$db->Replace('DiscussionSummary', array('cID' => $d['cID'] ,'totalTopics'=>$data['totalTopics'], 'totalPosts' => $data['totalPosts'],'lastPostCID' => $data['lastPostCID']), 'cID', false);
}

/*
echo "<h3>".IssueTrackerModel::CTHANDLE."</h3><hr/>";

$issues_trackers = $db->getAll($query,array(IssueTrackerModel::CTHANDLE));
foreach($issues_trackers as $d) {
	$dm = IssueTrackerModel::getByID($d['cID']);
	$data = $dm->getNewSummaryData();
	
	echo $dm->getCollectionName()."<br/>";
	$db->Replace('DiscussionSummary', array('cID' => $d['cID'], 'totalTopics'=>$data['totalTopics'], 'totalPosts' => $data['totalPosts'],'lastPostCID' => $data['lastPostCID']), 'cID', false);
}

echo "<h3>".IssueModel::CTHANDLE."</h3><hr/>";

$issues = $db->getAll($query,array(IssueModel::CTHANDLE));
foreach($issues as $d) {
	$dm = IssueModel::getByID($d['cID']);
	$data = $dm->getNewSummaryData();
	
	$db->Replace('DiscussionSummary', array('cID' => $d['cID'], 'totalPosts' => $data['totalPosts'],'lastPostCID' => $data['lastPostCID']), 'cID', false);
	echo $dm->getSubject()."<br/>";
}
*/

echo "<h3>".t('Discussion Post')."</h3><hr/>";

$discussion_posts = $db->getAll($query,array('discussion_post'));
foreach($discussion_posts as $d) {
	$dm = DiscussionPostModel::getByID($d['cID']);
	$data = $dm->getNewSummaryData();
	
	$db->Replace('DiscussionSummary', array('cID' => $d['cID'], 'totalPosts' => $data['totalPosts'],'lastPostCID' => $data['lastPostCID']), 'cID', false);
	echo $dm->getSubject()."<br/>";
}


?>