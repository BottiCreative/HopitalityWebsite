<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
class UserBadgesBlockController extends BlockController {
	
	protected $btTable = 'btDiscussionUserBadges';
	protected $btInterfaceWidth = "400";
	protected $btInterfaceHeight = "250";	

	/** 
	 * Used for localization. If we want to localize the name/description we have to include this
	 */
	public function getBlockTypeDescription() {
		return t("Display the badges of a certain user.");
	}
	
	public function getBlockTypeName() {
		return t("User Badges");
	}
	
	public function on_page_view() {
		$html = Loader::helper('html');
		$this->addHeaderItem($html->javascript('jquery.js'));
		$this->addHeaderItem($html->css('discussion.css', 'discussion'));
		$this->addHeaderItem($html->javascript('discussion.js', 'discussion'));
		$this->addHeaderItem($html->javascript('jquery.ui.js'));
		$this->addHeaderItem($html->css('jquery.ui.css'));
	}
	
	function save($args) {
		$args['byUserID'] = ($args['byUserID']) ? $args['byUserID'] : 0;
		parent::save($args);	
	}
	
	/** 
	 * We need to call this from within the view template because the controller doesn't know
	 * whether it's a user profile or a db profile user id
	 */
	public function getBadges($profile) {
		$profileu = $profile->getUserObject();
		$badges = DiscussionBadge::getBadges($profileu);
		return $badges;
	}
	
	public function view() {
		Loader::model('discussion_badge', 'discussion');
		Loader::model('userinfo');
	}
}