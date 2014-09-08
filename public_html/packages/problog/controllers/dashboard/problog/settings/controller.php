<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardProblogSettingsController extends Controller {
	
	protected $stTable = 'btProBlogSettings';
	
	function view(){
		$db = Loader::db();
		$r = $db->query("SELECT * FROM btProBlogSettings");
		while($row=$r->fetchrow()){
				$this->set('tweet' , $row['tweet']);
				$this->set('google' , $row['google']); 
				$this->set('fb_like', $row['fb_like']);  
				$this->set('addthis', $row['addthis']);  
				$this->set('sharethis', $row['sharethis']);
				$this->set('embedly', $row['embedly']);  
				$this->set('author', $row['author']); 	
				$this->set('comments', $row['comments']); 	
				$this->set('trackback', $row['trackback']); 	
				$this->set('canonical', $row['canonical']); 	
				$this->set('search_path', $row['search_path']); 
				$this->set('mobile_path', $row['mobile_path']); 
				$this->set('disqus', $row['disqus']);  
				$this->set('icon_color', $row['icon_color']);
				$this->set('thumb_width', $row['thumb_width']);
				$this->set('thumb_height', $row['thumb_height']);
				$this->set('ctID',$row['ctID']);
				$this->set('breakSyntax',$row['breakSyntax']);
		}
		
		$this->loadPageTypes();
	}
	
	function save(){

		$pkg = Package::getByHandle('problog');
		
		$pkg->saveConfig('PROBLOG_COMMENT_MAIL', $this->post('email_notice'));
		$pkg->saveConfig('PROBLOG_COMMENT_MODERATE', $this->post('moderate'));
		
		$args= array(
			'tweet'=>$this->post('tweet'),
			'google'=>$this->post('google'),
			'fb_like'=>$this->post('fb_like'),
			'addthis'=>$this->post('addthis'),
			'sharethis'=> (strlen($this->post('sharethis'))>32) ? $this->post('sharethis') : '',
			'embedly'=>$this->post('embedly'),
			'author'=>$this->post('author'),
			'comments'=>$this->post('comments'),
			'trackback'=>$this->post('trackback'),
			'canonical'=>$this->post('canonical'),
			'search_path'=>$this->post('search_path'),
			'mobile_path'=>$this->post('mobile_path'),
			'disqus'=>$this->post('disqus'),
			'icon_color'=>$this->post('icon_color'),
			'thumb_width'=>$this->post('thumb_width'),
			'thumb_height'=>$this->post('thumb_height'),
			'ctID'=>$this->post('ctID'),
			'breakSyntax'=>$this->post('breakSyntax')
		);
		
		$db= Loader::db();
		
		$db->execute("DELETE from btProBlogSettings");
		
		$s = ("INSERT INTO btProBlogSettings (tweet,google,fb_like,addthis,sharethis,embedly,author,comments,trackback,canonical,search_path,mobile_path,disqus,icon_color,thumb_width,thumb_height,ctID,breakSyntax) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		
		$db->query($s,$args);
		
		$this->redirect('/dashboard/problog/settings/', 'view');
	}
	
	protected function loadPageTypes() {
		Loader::model("collection_types");
		$ctArray = CollectionType::getList('');
		$pageTypes = array();
		foreach($ctArray as $ct) {
			$pageTypes[$ct->getCollectionTypeID()] = $ct->getCollectionTypeName();		
		}
		$this->set('pageTypes', $pageTypes);
	}
	
	public function clear_twitter(){
		$pkg = Package::getByHandle('problog');
		$pkg->saveConfig('PB_AUTH_TOKEN','');
		$pkg->saveConfig('PB_AUTH_SECRET','');
		$this->view();
	}
	
}