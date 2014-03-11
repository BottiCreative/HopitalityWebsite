<?php    defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

if( !class_exists( KillerStats ) ){
	class KillerStats extends Model {

		public function __construct() {}

		public static function loadAllOffenders() {
			$db = Loader::db();
			$offArray = array();
			// gives result per user for the latest period
			$query = 'SELECT uID, counting_from, nbr_logouts, last_logout FROM btSimultaneousLoginKillerStats SLKS WHERE counting_from=(SELECT MAX(counting_from) FROM btSimultaneousLoginKillerStats WHERE uID=SLKS.uID) GROUP BY uID';

			$offArray = $db->getAll($query);

			if (count($offArray) >= 1) {
				return $offArray;
			} else {
				return false;
			}
		}

		public static function loadOffenderStats($uID) {
			$db = Loader::db();
			$offAnswers = array();
			$offTmpArray = array();

			// Gets all stats for the selected user
			$query = "SELECT * FROM btSimultaneousLoginKillerStats WHERE uID = ? ORDER by counting_from DESC";

			$offTmpArray = $db->getAll($query, $uID);


			if (count($offTmpArray) >= 1) {
				// Get time in human readable form
				Loader::library('expressive_date', 'simultaneous_login_killer');
				$beginDate = new ExpressiveDate($offTmpArray[0]['counting_from']);

				$diffInWords = $beginDate->differenceAsWords();
				$total_logouts = 0;

				// Calculate total logouts recorder
				foreach ($offTmpArray as $arr) {
					$total_logouts += intval($arr['nbr_logouts']);
				}
				$offAnswers['total_logouts'] = $total_logouts;
				$offAnswers['total_time'] = $diffInWords;
				$offAnswers['details'] = $offTmpArray;
				return $offAnswers;
			} else {
				return false;
			}
		}

		public static function delete_stats($ui) {

			$co = new Config();
			$pkg = Package::getByHandle('simultaneous_login_killer');
			$co->setPackageObject($pkg);
			$clear_stats = $co->get('clear_stats');
			if (!empty($clear_stats)) {
				$db = Loader::db();
				// delete all stats for the selected user
				$query = "DELETE FROM btSimultaneousLoginKillerStats WHERE uID = ?";
				$db->execute($query, intval($ui->getUserID()));
			}
		}
	} //END of class
} //END of If class doesn't exist

?>