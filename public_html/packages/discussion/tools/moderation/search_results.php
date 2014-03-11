<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
$c1 = Page::getByPath('/dashboard/discussion/moderation');
$cp1 = new Permissions($c1);
if (!$cp1->canRead()) { 
	die(_("Access Denied."));
}

$u = new User();
$cnt = Loader::controller('/dashboard/discussion/moderation');
$postList = $cnt->getRequestedSearchResults();
$posts = $postList->getPage();
$pagination = $postList->getPagination();

Loader::packageElement('moderation/search_results', 'discussion', array('posts' => $posts, 'postList' => $postList, 'pagination' => $pagination));
