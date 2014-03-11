<?php  
defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

$pkg = Package::getByHandle('simultaneous_login_killer');
$sprites = $pkg->getRelativePath() . '/img';

$dbh = Loader::helper('concrete/dashboard');

echo $dbh->getDashboardPaneHeaderWrapper(t('View all offenders latest logouts'), t('View simultaneous login offenders'), false, false);

if ($all_offenders && is_array($all_offenders)) { ?>

<div class="ccm-list-wrapper ccm-pane-body">
	<fieldset>
		<div id="tableheader">
			<div class="search">
				<select id="off-columns" onchange="off_sorter.search('query')"></select>
				<input type="text" id="query" onkeyup="off_sorter.search('query')" />
			</div>
			<span class="details">
				<div><?php   echo t('Records') ?> <span id="off-startrecord"></span>-<span id="off-endrecord"></span> <?php   echo t('of') ?> <span id="off-totalrecords"></span></div>
				<div><a href="javascript:off_sorter.reset()"><?php   echo t('reset') ?></a></div>
			</span>
		</div>
		<table id="offenders_table" class="table table-striped ccm-results-list tinytable">
			<thead>
				<tr class="table-header">
					<th class="head"><strong><?php   echo t('User') ?></strong></th>
					<th class="head"><strong><?php   echo t('Email') ?></strong></th>
					<th class="head"><strong><?php   echo t('Counting From') ?></strong></th>
					<th class="head"><strong><?php   echo t('Total Logouts') ?></strong></th>
					<th class="head"><strong><?php   echo t('Last Logout') ?></strong></th>
					<th class="head"><strong><?php   echo t('Account Status') ?></strong></th>
					<th class="nosort"></th>
				</tr>
			</thead>
			<tbody>

				<?php  
				foreach($all_offenders as $offender) {
					$ui = UserInfo::getByID(intval($offender['uID']));
					if (is_object($ui)) {
						$uName = $ui->getUserName();
						$uEmail = $ui->getUserEmail();
						$uStatus = $ui->isActive() ? 'Activated' : 'Deactivated';
					} else {
						$uName = 'n/a';
						$uEmail = 'n/a';
						$uStatus = 'Deleted';
					}
				?>

					<tr class="ccm-list-record">
						<td><?php   echo $uName; ?></td>
						<td><?php   echo $uEmail; ?></td>
						<td><?php   echo $offender['counting_from']; ?></td>
						<td><?php   echo $offender['nbr_logouts']; ?></td>
						<td><?php   echo $offender['last_logout']; ?></td>
						<td><?php   echo $uStatus; ?></td>

						<td>
							<a href="javascript:ccmSlkOpenDetailStatsDialog(<?php   echo $offender['uID'] ?>);" class="btn primary"><?php     echo t('History') ?></a>
						</td>
					</tr>
					<?php  

				 }	?>
				</tbody>
			</table>
			<div id="off-tablenav">
				<div class="lineup">
					<img src="<?php   echo $sprites; ?>/first.gif" width="16" height="16" alt="First Page" onclick="off_sorter.move(-1,true)" />
					<img src="<?php   echo $sprites; ?>/previous.gif" width="16" height="16" alt="First Page" onclick="off_sorter.move(-1)" />
					<img src="<?php   echo $sprites; ?>/next.gif" width="16" height="16" alt="First Page" onclick="off_sorter.move(1)" />
					<img src="<?php   echo $sprites; ?>/last.gif" width="16" height="16" alt="Last Page" onclick="off_sorter.move(1,true)" />
				</div>
				<div>
					<select id="off-pagedropdown"></select>
				</div>
				<div class="lineup">
					<a href="javascript:off_sorter.showall()"><?php   echo t('View all') ?></a>
				</div>
			</div>
			<div id="off-tablelocation">
				<div>
					<select onchange="off_sorter.size(this.value)">
						<option value="5" selected="selected">5</option>
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
					<span><?php   echo t('Entries Per Page') ?></span>
				</div>
				<div class="page"><?php   echo t('Page') ?> <span id="off-currentpage"></span> <?php   echo t('of') ?> <span id="off-totalpages"></span></div>
			</div>
		</fieldset>
	</div>
	<?php  
} else { ?>
	<div class="ccm-list-wrapper ccm-pane-body">
		<p><?php   echo t('No data available, meaning no simultaneous logins were spotted yet.') ?>
	</div>
<?php   }
echo $dbh->getDashboardPaneFooterWrapper(false);?>
<style>
	.search {float:left; padding:6px; background:transparent; margin-bottom: 5px;}
	#off-tableheader select, #tableheader select {float:left; font-size:12px; width:125px; padding:2px 4px 4px}
	#off-tableheader input, #tableheader input {float:left; font-size:12px; width:225px; padding:2px 4px 4px; margin-left:4px}

	.details {float:right; padding-top:12px}
	.details div {float:left; margin-left:15px; font-size:12px}

	#off-tablenav, #tablenav {float:left; display: none;}
	#off-tablenav img, #tablenav img {cursor:pointer}
	#off-tablenav div, #tablenav div {float:left; margin-right:15px}
	#off-tablenav select, #tablenav select {width: auto;}
	#off-tablenav .lineup, #tablenav .lineup {margin-top: 5px;}
	#off-tablelocation, #tablelocation {float:right; font-size:12px}
	#off-tablelocation select, #tablelocation select {margin-right:3px; width: auto;}
	#off-tablelocation div, #tablelocation div {float:left; margin-left:15px}
	.page {margin-top:7px; font-style:italic}

	.tinytable th strong {padding:6px 8px 8px; font-weight: bold;}
	.tinytable .head strong {background:url(<?php   echo $sprites; ?>/sort.png) left center no-repeat; cursor:pointer; padding-left:12px}
	.tinytable .desc strong {background:url(<?php   echo $sprites; ?>/desc.png) left 14px no-repeat; cursor:pointer; padding-left:12px}
	.tinytable .asc strong {background:url(<?php   echo $sprites; ?>/asc.png) left  8px no-repeat; cursor:pointer; padding-left:12px}
</style>