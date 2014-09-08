<?php   defined('C5_EXECUTE') or die("Access Denied."); ?> 

<div id="ccm-user-search-results">

<?php   if ($searchType == 'DASHBOARD') { ?>

<div class="ccm-pane-body">

<?php   } 

$ek = PermissionKey::getByHandle('edit_user_properties');
$ik = PermissionKey::getByHandle('activate_user');
$gk = PermissionKey::getByHandle('assign_user_groups');
$dk = PermissionKey::getByHandle('delete_user');

if (!$mode) {
		$mode = $_REQUEST['mode'];
	}
	if (!$searchType) {
		$searchType = $_REQUEST['searchType'];
	}
	
	$soargs = array();
	$soargs['searchType'] = $searchType;
	$soargs['mode'] = $mode;
	$searchInstance = 'user';

	?>

<div id="ccm-list-wrapper"><a name="ccm-<?php  echo $searchInstance?>-list-wrapper-anchor"></a>

	<div style="margin-bottom: 10px">
		<?php   $form = Loader::helper('form'); ?>

		<a href="<?php  echo View::url('/dashboard/users/add')?>" style="float: right" class="btn primary"><?php  echo t("Add User")?></a>
		<select id="ccm-blog-<?php  echo $searchInstance?>-list-multiple-operations" class="span3" disabled>
					<option value="">** <?php  echo t('With Selected')?></option>
					<?php   if ($ek->validate()) { ?>
						<option value="properties"><?php  echo t('Edit Properties')?></option>
					<?php   } ?>
					<?php   if ($ik->validate()) { ?>
						<option value="activate"><?php  echo t('Activate')?></option>
						<option value="deactivate"><?php  echo t('Deactivate')?></option>
					<?php   } ?>
					<?php   if ($gk->validate()) { ?>
					<option value="group_add"><?php  echo t('Add to Group')?></option>
					<option value="group_remove"><?php  echo t('Remove from Group')?></option>
					<?php   } ?>
					<?php   if ($dk->validate()) { ?>
					<option value="delete"><?php  echo t('Delete')?></option>
					<?php   } ?>
				<?php   if ($mode == 'choose_multiple') { ?>
					<option value="choose"><?php  echo t('Choose')?></option>
				<?php   } ?>
				</select>

	</div>

	<?php  
	$txt = Loader::helper('text');
	$keywords = $_REQUEST['keywords'];
	$bu = Loader::helper('concrete/urls')->getToolsURL('search_users','problog');
	
	if (count($users) > 0) { ?>	
		<table border="0" cellspacing="0" cellpadding="0" id="ccm-user-list" class="ccm-results-list">
		<tr>
			<th width="1"><input id="ccm-user-list-cb-all" type="checkbox" /></th>
			<?php   foreach($columns->getColumns() as $col) { ?>
				<?php   if ($col->isColumnSortable()) { ?>
					<th class="<?php  echo $userList->getSearchResultsClass($col->getColumnKey())?>"><a href="<?php  echo $userList->getSortByURL($col->getColumnKey(), $col->getColumnDefaultSortDirection(), $bu, $soargs)?>"><?php  echo $col->getColumnName()?></a></th>
				<?php   } else { ?>
					<th><?php  echo $col->getColumnName()?></th>
				<?php   } ?>
			<?php   } ?>

		</tr>
	<?php  
		foreach($users as $ui) { 
			$action = View::url('/dashboard/users/search?uID=' . $ui->getUserID());
			
			if ($mode == 'choose_one'){
				$action = 'javascript:void(0); ccm_triggerSelectBlogUser(' . $ui->getUserID() . ',\'' . $txt->entities($ui->getUserName()) . '\',\'' . $txt->entities($ui->getUserEmail()) . '\'); jQuery.fn.dialog.closeTop();';
			}elseif($mode == 'choose_multiple') {
				$action = 'javascript:void(0); ccm_triggerSelectBlogMultiUser(' . $ui->getUserID() . ',\'' . $txt->entities($ui->getUserName()) . '\',\'' . $txt->entities($ui->getUserEmail()) . '\'); jQuery.fn.dialog.closeTop();';
			}
			
			if (!isset($striped) || $striped == 'ccm-list-record-alt') {
				$striped = '';
			} else if ($striped == '') { 
				$striped = 'ccm-list-record-alt';
			}

			?>
		
			<tr class="ccm-list-record <?php  echo $striped?> blog-user-item">
			<td class="ccm-user-list-cb" style="vertical-align: middle !important"><input type="checkbox" value="<?php  echo $ui->getUserID()?>" user-email="<?php  echo $ui->getUserEmail()?>" user-name="<?php  echo $ui->getUserName()?>" /></td>
			<?php   foreach($columns->getColumns() as $col) { ?>
				<?php   if ($col->getColumnKey() == 'uName') { ?>
					<td><a href="<?php  echo $action?>"><?php  echo $ui->getUserName()?></a></td>
				<?php   } else { ?>
					<td><?php  echo $col->getColumnValue($ui)?></td>
				<?php   } ?>
			<?php   } ?>

			</tr>
			<?php  
		}

	?>
	
	</table>
	
	

	<?php   } else { ?>
		
		<div id="ccm-list-none"><?php  echo t('No users found.')?></div>
		
	
	<?php   }  ?>

</div>

<div id="ccm-export-results-wrapper">
	<a id="ccm-export-results" href="javascript:void(0)" onclick="$('#ccm-user-advanced-search').attr('action', '<?php  echo REL_DIR_FILES_TOOLS_REQUIRED?>/users/search_results_export'); $('#ccm-user-advanced-search').get(0).submit(); $('#ccm-user-advanced-search').attr('action', '<?php  echo REL_DIR_FILES_TOOLS_REQUIRED?>/users/search_results');"><span></span><?php  echo t('Export')?></a>
</div>

<?php  
	$userList->displaySummary();
?>

<?php   if ($searchType == 'DASHBOARD') { ?>
</div>

<div class="ccm-pane-footer">
	<?php   	$userList->displayPagingV2($bu, false, $soargs); ?>
</div>

<?php   } else { ?>
	<div class="ccm-pane-dialog-pagination">
		<?php   	$userList->displayPagingV2($bu, false, $soargs); ?>
	</div>
<?php   } ?>

</div>

<script type="text/javascript">
$(function() { 	
	ccm_setupUserBlogSearch = function(searchInstance) {
		$(".chosen-select").chosen();	
		
		$("#ccm-user-list-cb-all").click(function() {
			if ($(this).prop('checked') == true) {
				$('.ccm-list-record td.ccm-user-list-cb input[type=checkbox]').attr('checked', true);
				$("#ccm-blog-user-list-multiple-operations").attr('disabled', false);
			} else {
				$('.ccm-list-record td.ccm-user-list-cb input[type=checkbox]').attr('checked', false);
				$("#ccm-blog-user-list-multiple-operations").attr('disabled', true);
			}
		});
		$("td.ccm-user-list-cb input[type=checkbox]").click(function(e) {
			if ($("td.ccm-user-list-cb input[type=checkbox]:checked").length > 0) {
				$("#ccm-blog-user-list-multiple-operations").attr('disabled', false);
			} else {
				$("#ccm-blog-user-list-multiple-operations").attr('disabled', true);
			}
		});
		
		// if we're not in the dashboard, add to the multiple operations select menu
	
		$("#ccm-blog-user-list-multiple-operations").change(function() {
			var action = $(this).val();
			switch(action) {
				case 'choose':
					console.log('multi_blog_chose');
					var idstr = '';
					$("td.ccm-user-list-cb input[type=checkbox]:checked").each(function() {
						ccm_triggerSelectBlogMultiUser($(this).val(), $(this).attr('user-name'), $(this).attr('user-email'));
					});
					jQuery.fn.dialog.closeTop();
					break;
				case "properties": 
					uIDstring = '';
					$("td.ccm-user-list-cb input[type=checkbox]:checked").each(function() {
						uIDstring=uIDstring+'&uID[]='+$(this).val();
					});
					jQuery.fn.dialog.open({
						width: 630,
						height: 450,
						modal: false,
						href: CCM_TOOLS_PATH + '/users/bulk_properties?' + uIDstring,
						title: ccmi18n.properties				
					});
					break;
				case "activate": 
					uIDstring = '';
					$("td.ccm-user-list-cb input[type=checkbox]:checked").each(function() {
						uIDstring=uIDstring+'&uID[]='+$(this).val();
					});
					jQuery.fn.dialog.open({
						width: 630,
						height: 450,
						modal: false,
						href: CCM_TOOLS_PATH + '/users/bulk_activate?searchInstance='+ searchInstance + '&' + uIDstring,
						title: ccmi18n.user_activate				
					});
					break;
				case "deactivate": 
					uIDstring = '';
					$("td.ccm-user-list-cb input[type=checkbox]:checked").each(function() {
						uIDstring=uIDstring+'&uID[]='+$(this).val();
					});
					jQuery.fn.dialog.open({
						width: 630,
						height: 450,
						modal: false,
						href: CCM_TOOLS_PATH + '/users/bulk_deactivate?searchInstance='+ searchInstance + '&' + uIDstring,
						title: ccmi18n.user_deactivate
					});
					break;
				case "group_add": 
					uIDstring = '';
					$("td.ccm-user-list-cb input[type=checkbox]:checked").each(function() {
						uIDstring=uIDstring+'&uID[]='+$(this).val();
					});
					jQuery.fn.dialog.open({
						width: 630,
						height: 450,
						modal: false,
						href: CCM_TOOLS_PATH + '/users/bulk_group_add?searchInstance='+ searchInstance + '&' + uIDstring,
						title: ccmi18n.user_group_add		
					});
					break;
				case "group_remove": 
					uIDstring = '';
					$("td.ccm-user-list-cb input[type=checkbox]:checked").each(function() {
						uIDstring=uIDstring+'&uID[]='+$(this).val();
					});
					jQuery.fn.dialog.open({
						width: 630,
						height: 450,
						modal: false,
						href: CCM_TOOLS_PATH + '/users/bulk_group_remove?searchInstance='+ searchInstance + '&' + uIDstring,
						title: ccmi18n.user_group_remove				
					});
					break;
				case "delete": 
					uIDstring = '';
					$("td.ccm-user-list-cb input[type=checkbox]:checked").each(function() {
						uIDstring=uIDstring+'&uID[]='+$(this).val();
					});
					jQuery.fn.dialog.open({
						width: 630,
						height: 450,
						modal: false,
						href: CCM_TOOLS_PATH + '/users/bulk_delete?searchInstance='+ searchInstance + '&' + uIDstring,
						title: ccmi18n.user_delete				
					});
					break;
			}
			
			$(this).get(0).selectedIndex = 0;
		});
	}
	ccm_setupUserBlogSearch('<?php  echo $searchInstance?>'); 
});
</script>