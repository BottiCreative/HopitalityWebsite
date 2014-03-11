<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
 
Loader::model('discussion_badge', 'discussion');
class DashboardDiscussionBadgesController extends Controller {
	public $helpers = array('form', 'text', 'concrete/interface', 'validation/token');

	public function view() {
		$badges = DiscussionBadge::getAvailableBadges();
		$this->set("badges",$badges);
	}
	
	public function add() {
		$this->set('mode','form');
		$this->view();
	}
	
	public function save() {
		$error = Loader::helper('validation/error');	
		$badgeID = $this->post('badgeGroupID');
		if(!is_numeric($badgeID) || $badgeID <=0) {
			$badgeID = 0;
		}
		
		if(!$badgeID && !strlen($this->post('badgeName'))) {
			$error->add(t('Name Required'));
		}
		
		if(!strlen($this->post('badgeDescription'))) {
			$error->add(t('Description Required'));
		}
		
		if(!$badgeID && !is_uploaded_file($_FILES['badgeImage']['tmp_name'])) {
			$error->add(t('Image Required'));
		}
		
		if(!$error->has()) {
			if($badgeID) {
				DiscussionBadge::editBadge($badgeID, $this->post('badgeDescription'), $_FILES['badgeImage']['tmp_name']);
				$this->set("message",t('The badge has been updated successfully'));
			} else {
				DiscussionBadge::addBadge($this->post('badgeName'), $this->post('badgeDescription'), $_FILES['badgeImage']['tmp_name']);	
				$this->set("message",t('The badge has been added successfully'));
			}
			$this->view();
		} else {
			$this->set('badgeName',$this->post('badgeName'));
			$this->set('badgeDescription',$this->post('badgeDescription'));
			if($error->has()) {
				if($badgeID) {
					$b = new DiscussionBadge($badgeID);
					$this->set("badge",$b);
				} 
				$this->set('error',$error);
				$this->set('mode','form');
			}
			$this->view();
		}

	}
	

	public function edit($gID) {
		$b = new DiscussionBadge($gID);
		$this->set("badge",$b);
		$this->set("badgeName",$b->getBadgeName());
		$this->set("badgeDescription",$b->getBadgeDescription());
		$this->set('mode','form');
		$this->view();	
	}
	
	public function delete($gID) {
		DiscussionBadge::deleteBadge($gID);
		$this->set("message",t('The badge has been deleted'));
		$this->view();
	}	
}