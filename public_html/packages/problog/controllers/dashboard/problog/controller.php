<?php       
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardProblogController extends Controller {
	


	public function view() {
		$this->redirect('/dashboard/problog/list/');
	}
	
}