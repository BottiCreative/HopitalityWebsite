<?php     
defined('C5_EXECUTE') or die("Access Denied.");

$tp = new TaskPermission();
if (!$tp->canAccessUserSearch()) { 
	die(t("You have no access to users."));
}

$cnt = Loader::controller('/dashboard/users/search');
$userList = $cnt->getRequestedSearchResults();
$users = $userList->getPage();
$pagination = $userList->getPagination();
$columns = $cnt->get('columns');

if (!isset($mode)) {
	$mode = Loader::helper('text')->entities($_REQUEST['mode']);
}

ob_start();
Loader::element('users/search_form_advanced', array('columns' => $columns, 'mode' => $mode)) ;
$searchForm = ob_get_contents();
ob_end_clean();

$v = View::getInstance();
$v->outputHeaderItems();

?>

<div class="ccm-ui">
<div id="ccm-search-overlay" >
<div class="ccm-pane-options" id="ccm-<?php     echo $searchInstance?>-pane-options">
	<?php     echo $searchForm?>
</div>

<?php      Loader::element('users/search_results', array('columns' => $columns, 'mode' => $mode, 'users' => $users, 'userList' => $userList, 'pagination' => $pagination)); ?>
</div>
</div>

<script type="text/javascript">
$(function() {
	ccm_setupAdvancedSearch('user');

	ccm_triggerSelectBlogUser = function(uID,uName){
			var par = $(ccmActiveUserField).parent().find('.ccm-summary-selected-user-label');
			var pari = $(ccmActiveUserField).parent().find('input');
			$(ccmActiveUserField).parent().find('.ccm-sitemap-clear-selected-user').show();
			par.html(uName);
			pari.val(uID);
			return false;
	}
	ccm_triggerSelectUser = function(uID, uName, uEmail) {
		ccm_triggerSelectBlogUser(uID, uName);
	}
});
</script>