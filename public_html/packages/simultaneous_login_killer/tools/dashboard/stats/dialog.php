<?php   defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */
$path = '/dashboard/simultaneous_login_killer/list';
$page = Page::getByPath($path);
$permissions = new Permissions($page);
$canRead = $permissions->canRead();
if($canRead) {
	$pkg = Package::getByHandle('simultaneous_login_killer');
	$sprites = $pkg->getRelativePath() . '/img';

	$cnt = Loader::controller('/dashboard/simultaneous_login_killer/list');
	$cnt->loadOffenderStats();

	$offenderStats = $cnt->offenderStats;
	$nouID = $cnt->nouID;
	if ($nouID) { ?>
		<div class="ccm-ui element-body">
			<div class="message alert-message error dialog_message">
				<?php   echo t('It seems something went terribly wrong. You might want to try again.'); ?>
			</div>
		</div>
		<?php  
		die();
	} else if ($offenderStats && is_array($offenderStats)) {
		?>
		<div class="ccm-ui element-body">
			<fieldset>
				<legend><?php     echo t('Summary') ?></legend>
				<table class="table table-striped ccm-results-list">
					<tbody>
						<?php  
						$ui = UserInfo::getByID(intval($offenderStats['details'][0]['uID']));
						if (is_object($ui)) {
							$uName = $ui->getUserName();
						} ?>

						<tr class="ccm-list-record">
							<td><?php  
								if (is_object($ui)) {
									echo t("User %s has been flagged and logged out %s time(s) in %s", $uName, $offenderStats['total_logouts'], $offenderStats['total_time']);
								} else {
									echo t('This user account was deleted.');
								}
								?>
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>

			<fieldset>
				<legend><?php     echo t('History') ?></legend>
				<div id="tableheader">
					<div class="search">
						<select id="columns" onchange="sorter.search('query')"></select>
						<input type="text" id="query" onkeyup="sorter.search('query')" />
					</div>
					<span class="details">
						<div><?php   echo t('Records') ?> <span id="startrecord"></span>-<span id="endrecord"></span> <?php   echo t('of') ?> <span id="totalrecords"></span></div>
						<div><a href="javascript:sorter.reset()">reset</a></div>
					</span>
				</div>
				<table id="stats" class="table table-striped ccm-results-list tinytable">
					<thead>
						<tr class="table-header">
							<th class="head"><strong><?php   echo t('Counting From'); ?></strong></th>
							<th class="head"><strong><?php   echo t('Total Logouts'); ?></strong></th>
							<th class="head"><strong><?php   echo t('Last Logout'); ?></strong></th>
							<th class="head"><strong><?php   echo t('Status (end of period)'); ?></strong></th>
						</tr>
					</thead>
					<tbody>

						<?php  
						$row_style = 'ccm-list-record-alt';
						foreach($offenderStats['details'] as $stat) {
							$row_style = 'ccm-list-record-alt' ? '' : 'ccm-list-record-alt';
							?>

							<tr class="ccm-list-record <?php   echo $row_style; ?>">
								<td><?php   echo $stat['counting_from']; ?></td>
								<td><?php   echo $stat['nbr_logouts']; ?></td>
								<td><?php   echo $stat['last_logout']; ?></td>
								<td><?php   echo $stat['deactivated'] ? t('Deactivated') : t('Still active'); ?></td>

							</tr>
							<?php   } ?>
						</tbody>
					</table>
					<div id="tablenav">
						<div class="lineup">
							<img src="<?php   echo $sprites; ?>/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
							<img src="<?php   echo $sprites; ?>/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
							<img src="<?php   echo $sprites; ?>/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
							<img src="<?php   echo $sprites; ?>/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
						</div>
						<div>
							<select id="pagedropdown"></select>
						</div>
						<div class="lineup">
							<a href="javascript:sorter.showall()"><?php   echo t('View all') ?></a>
						</div>
					</div>
					<div id="tablelocation">
						<div>
							<select onchange="sorter.size(this.value)">
								<option value="5" selected="selected">5</option>
								<option value="10">10</option>
								<option value="20">20</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
							<span><?php   echo t('Entries Per Page') ?></span>
						</div>
						<div class="page"><?php   echo t('Page') ?> <span id="currentpage"></span> <?php   echo t('of') ?> <span id="totalpages"></span></div>
					</div>
				</div>
			</fieldset>

		</div>

		<script type="text/javascript">
		var sorter = new TINY.table.sorter('sorter','stats',{
			headclass:'head',
			ascclass:'asc',
			descclass:'desc',
			evenclass:'',
			oddclass:'',
			evenselclass:'',
			oddselclass:'',
			paginate:true,
			size:3,
			colddid:'columns',
			currentid:'currentpage',
			totalid:'totalpages',
			startingrecid:'startrecord',
			endingrecid:'endrecord',
			totalrecid:'totalrecords',
			hoverid:'',
			pageddid:'pagedropdown',
			navid:'tablenav',
			sortcolumn:0,
			sortdir:-1,
			sum:[1],
			avg:[],
			columns:[],
			init:true
		});
		</script>
		<?php  
	} else {
		?>
		<div class="ccm-ui element-body">
			<div class="message alert-message error dialog_message">
				<?php   echo t('There is no recorded data yet for this user.'); ?>
			</div>
		</div>
		<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix ccm-ui">
			<a href="javascript:void(0)" class="btn" onclick="ccm_blockWindowClose()"><?php     echo t('Cancel')?></a>
		</div>
		<?php  
		die();
	}

}?>

