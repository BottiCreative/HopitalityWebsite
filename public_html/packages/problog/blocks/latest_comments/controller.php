<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));
class LatestCommentsBlockController extends BlockController {

	protected $btTable = 'btLatestComments';
	protected $btInterfaceWidth = "300";
	protected $btInterfaceHeight = "100";
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;

	public function getBlockTypeDescription() {
		return t("List of Latest Comments");
	}
	
	public function getBlockTypeName() {
		return t("Latest Comments");
	}
	
	public function view(){
		if($this->maxItems==0){
			$this->maxItems='none';
		}
		$entries=$this->getAllEntries($this->maxItems);
		$this->set('entries', $entries);
	}
	
	function save($args){
		$args['maxItems'] = ($args['maxItems'] === '') ? '0' : $args['maxItems'];
		parent::save($args);
	}
	
	function getAllEntries($limit='none'){
		$db = Loader::db();
		if($limit=='none'){
			$q="SELECT * FROM btGuestBookEntries WHERE approved=1 ORDER BY entryDate DESC";
		}else{
			$q="SELECT * FROM btGuestBookEntries WHERE approved=1 ORDER BY entryDate DESC LIMIT 0, $limit";
		}

		$rows = $db->getAll($q);		
		
		$pkg = Package::getByHandle('problog');
		if($pkg){
			//grab problog settings
			//if the Disqus sitename is set
			//use disqus
			$blogify = Loader::helper('blogify','problog');
			$settings = $blogify->getBlogSettings();
			if($settings['disqus']){
				return '<div id="recentcomments" class="dsq-widget"><h2 class="dsq-widget-title">Latest Comments</h2><script type="text/javascript" src="https://'.$settings['disqus'].'.disqus.com/recent_comments_widget.js?num_items='.$limit.'&hide_avatars=0&avatar_size=22&excerpt_length=100"></script></div><a href="https://disqus.com/">Powered by Disqus</a>';
			}else{
				return $rows;
			}
		}else{
			return $rows;
		}
	}
}