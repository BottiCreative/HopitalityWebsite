<?php  
defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

class DashboardSimultaneousLoginKillerListController extends Controller {

	public function on_start(){}

	public function view(){
		$all_offenders = $this->loadAllOffenders();

		$this->set('all_offenders', $all_offenders);

		if ($all_offenders && is_array($all_offenders)) {
			$html = Loader::helper('html');
			$concrete_urls = Loader::helper('concrete/urls');

			$this->addHeaderItem($html->javascript('dashboard/stats/offenders.js', 'simultaneous_login_killer'));
			$this->addHeaderItem($html->javascript('dashboard/stats/table-sorter.js', 'simultaneous_login_killer'));
			$script = "<script>
			var dialog_url = '".$concrete_urls->getToolsURL('dashboard/stats/dialog', 'simultaneous_login_killer')."';
			</script>";

			$script_table = "<script>
			var off_sorter = new TINY.table.sorter('off_sorter','offenders_table',{
				headclass:'head',
				ascclass:'asc',
				descclass:'desc',
				evenclass:'',
				oddclass:'',
				evenselclass:'',
				oddselclass:'',
				paginate:true,
				size:3,
				colddid:'off-columns',
				currentid:'off-currentpage',
				totalid:'off-totalpages',
				startingrecid:'off-startrecord',
				endingrecid:'off-endrecord',
				totalrecid:'off-totalrecords',
				hoverid:'',
				pageddid:'off-pagedropdown',
				navid:'off-tablenav',
				sortcolumn:0,
				sortdir:1,
				sum:[],
				avg:[],
				columns:[],
				init:true
			});
			</script>";
			$this->addHeaderItem($script);
			$this->addFooterItem($script_table);
		}

	}

	private function loadAllOffenders() {
		// $u = new User();
		// if($u->isLoggedIn()) {
			// $uID = $u->getUserID();
			Loader::model('killer_stats', 'simultaneous_login_killer');
			$killerStats = new KillerStats();

			return $killerStats->loadAllOffenders();
		// }
	}

	public function loadOffenderStats() {
		$data = $this->get();
		$uID = intval($data['uID']);

		if($uID) {
			Loader::model('killer_stats', 'simultaneous_login_killer');
			$killerStats = new KillerStats();

			$this->offenderStats = $killerStats->loadOffenderStats($uID);
			$this->nouID = false;
		} else {
			$this->nouID = true;
		}

	}

}