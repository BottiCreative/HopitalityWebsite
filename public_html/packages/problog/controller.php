<?php        
defined('C5_EXECUTE') or die(_("Access Denied."));

class ProblogPackage extends Package {

	protected $pkgHandle = 'problog';
	protected $appVersionRequired = '5.6.0';
	protected $pkgVersion = '12.0.0';
	
	public function getPackageDescription() {
		return t("A professional Blog package");
	}
	
	public function getPackageName() {
		return t("Pro Blog");
	}
	
	public function uninstall(){
		
		parent::uninstall();
	}
	
	public function upgrade(){
	
		$db = Loader::db();
		
		$pkg = Package::getByHandle('problog');

		////////////////////////////////////////////////////////////////////////////
		//pre v3 updates
		///////////////////////////////////////////////////////////////////////////
		
		
		$userpicker = AttributeType::getByHandle('user_picker');
		if(!is_object($userpicker) || !intval($userpicker->getAttributeTypeID())){
		
			$euku = AttributeKeyCategory::getByHandle('user');
  			$euku->setAllowAttributeSets(AttributeKeyCategory::ASET_ALLOW_SINGLE);

			$userpicker = AttributeType::getByHandle('user_picker');
			if(!is_object($userpicker) || !intval($userpicker->getAttributeTypeID()) ) { 
				$userpicker = AttributeType::add('user_picker', t('User Picker'), $pkg);	  
			} 
		  	$euku->associateAttributeKeyType($userpicker);
		  	
		  	$blogauth=CollectionAttributeKey::getByHandle('blog_author'); 
			if( !is_object($blogauth) ) {
		     	CollectionAttributeKey::add($userpicker, 
		     	array('akHandle' => 'blog_author', 
		     	'akName' => t('Blog Author')
		     	),$pkg); 
		  	}

			$checkn = AttributeType::getByHandle('boolean'); 
		    $blogman= UserAttributeKey::getByHandle('blog_editor'); 
			if( !is_object($blogman) ) {
		     	UserAttributeKey::add($checkn, 
		     	array('akHandle' => 'blog_editor', 
		     	'akName' => t('Blog Editor'),
		     	'uakProfileEdit' => '1'
		     	),$pkg); 
		  	}
		  	
		  	$comments = Page::getByPath('/dashboard/problog/comments');
		  	if( !is_object($comments) || $comments->cID==null) {
		  		SinglePage::add('/dashboard/problog/comments', $pkg);
		  	}
		}
		
		
		
		
		////////////////////////////////////////////////////////////////////////////
		//pre v4 updates
		///////////////////////////////////////////////////////////////////////////
		if(version_compare(APP_VERSION,'5.4.1.1', '>')){
			$tudes= UserAttributeKey::getByHandle('post_location'); 
			if(!is_object($tudes) || !intval($tudes->getAttributeTypeID())){
				$eaku = AttributeKeyCategory::getByHandle('collection');
				$bset = AttributeSet::getByHandle('problog_additional_attributes');
				if(!is_object($bset)){
	  				$bset = $eaku->addSet('problog_additional_attributes', t('ProBlog Additional Attributes'),$pkg);
	  			}
				$textn = AttributeType::getByHandle('text'); 
			  	$eventurl=CollectionAttributeKey::getByHandle('post_location'); 
				if( !is_object($eventurl) ) {
			     	CollectionAttributeKey::add($textn, 
			     	array('akHandle' => 'post_location', 
			     	'akName' => t('Post Geodata'), 
			     	),$pkg)->setAttributeSet($bset); 
			  	}
			}
		}else{
			$db = Loader::db();
			$db->Execute("UPDATE Packages SET pkgVersion='3.1.5' WHERE pkgHandle='problog'");
			throw new Exception(t('Attention!  You are missing key features of ProBlog v4 because you failed to upgrade your C5 core to v5.4.2 first.'));  
      		exit;
		}
		
		
		////////////////////////////////////////////////////////////////////////////
		//pre v5 updates
		///////////////////////////////////////////////////////////////////////////
		$bt = BlockType::getByHandle('trackback');
		if(!$bt){
			//////////////////////////////////////////
			// install trackback block to pb_post
			// page_type defaults
			//////////////////////////////////////////
			BlockType::installBlockTypeFromPackage('trackback', $pkg);	
			$bt = BlockType::getByHandle('trackback');
			if(is_object($bt)){
				$blogPostCollectionTypeMT = CollectionType::getByHandle('pb_post')->getMasterTemplate();	
				$bt_array = array();
			    $blogPostCollectionTypeMT->addBlock($bt,'Blog Post Trackback', $bt_array);                    
			}
		}
		
		$help = Page::getByPath('/dashboard/problog/help');
	  	if( !is_object($help) || $help->cID==null) {
	  		SinglePage::add('/dashboard/problog/help', $pkg);
	  	}
	  	
	  	$db = Loader::db();
	  	
	  	////////////////////////////////////////////////////////////////////////////
		//pre v6 updates
		///////////////////////////////////////////////////////////////////////////
		
		$bt = BlockType::getByHandle('latest_comments');
		if(!is_object($bt)){
			BlockType::installBlockTypeFromPackage('latest_comments', $pkg);			
		}
		
		$bt = BlockType::getByHandle('problog_date_archive');
		if(!is_object($bt)){
			BlockType::installBlockTypeFromPackage('problog_date_archive', $pkg);	
		}
		
		
		////////////////////////////////////////////////////////////////////////////
		//pre v7 updates
		///////////////////////////////////////////////////////////////////////////
		$userBlogs = Page::getByPath('/dashboard/problog/user_blogs');
		if(!is_object($userBlogs) || $userBlogs->cID==null){
		
			$iak = CollectionAttributeKey::getByHandle('icon_dashboard');
			
			$pbl = Page::getByPath('/dashboard/problog/list');
			$pbl->setAttribute($iak,'icon-list-alt');
			
			$pba = Page::getByPath('/dashboard/problog/add_blog');
			$pba->setAttribute($iak,'icon-pencil');
			
			$pbc = Page::getByPath('/dashboard/problog/comments');
			$pbc->setAttribute($iak,'icon-comment');
			
			$pbs = Page::getByPath('/dashboard/problog/settings');
			$pbs->setAttribute($iak,'icon-wrench');
			
			$pbl = Page::getByPath('/dashboard/problog/help');
			$pbl->setAttribute($iak,'icon-question-sign');
			
			$userBlogSettings = SinglePage::add('/dashboard/problog/user_blogs', $pkg);
			$userBlogSettings->update(array('cName' => t('User Blogs'), 'cDescription' => t('Manage user blogs.')));
			$userBlogSettings->setAttribute($iak,'icon-list-alt');
		}
		
		
		////////////////////////////////////////////////////////////////////////////
		//new v7 SEO'able tags
		///////////////////////////////////////////////////////////////////////////
		$search = Page::getByPath('/blogsearch');
		if(!is_object($search) || $search->cID==null){
			$search = SinglePage::add('/blogsearch', $pkg);
			
			/////////////////////////
		    //now we go add blocks to the /blogsearch singlepage
		    ////////////////////////
		    $setblogAt = Page::getByPath('/blogsearch');
		    
		    $setblogParent = Page::getByPath('/blog');
		    $cParentID = $setblogParent->getCollectionID();
		    
		    $block = $setblogAt->getBlocks('Main');
			foreach($block as $b) {
				$b->delete();
			}
			
			
			$block = $setblogAt->getBlocks('Sidebar');
			foreach($block as $b) {
				$b->delete();
			}
		    
		    $bt = BlockType::getByHandle('search');
		    $searchPath = $setblogAt->getCollectionPath();
				
			$data = array('title' => t('Blog Search'),
			'buttonText'=>t('go'),
			'baseSearchPath'=>$searchPath,
			'searchUnderCID'=>$searchPath,
			'resultsURL'=>''
			);			
						
			$setblogAt->addBlock($bt, 'Main', $data);
			
			$block = $setblogAt->getBlocks('Main');
			foreach($block as $b) {
				$b->setCustomTemplate('templates/blog_search');
			}
			
			if($cParentID > 0){
				$bt = BlockType::getByHandle('problog_list');
				for($bb=1;$bb<=4;$bb+=1){	
					
					if($bb==1){
						$title=t('Category List');
					}elseif($bb==2){
						$title=t('Tag List');
					}elseif($bb==3){
						$title=t('Tag Cloud');
					}elseif($bb==4){
						$title=t('Archive');
					}
				
					$data = array('num' => '25',
					'cParentID'=>$cParentID,
					'cThis'=>'0',
					'paginate'=>'0',
					'displayAliases'=>'0',
					'ctID'=>$ctID,
					'rss'=>'0',
					'rssTitle'=>'',
					'rssDescription'=>'',
					'truncateSummaries'=>'0',
					'truncateChars'=>'128',
					'category'=>t('All Categories'),
					'title'=>$title
					);			
								
					$setblogAt->addBlock($bt, 'Sidebar', $data);
				}
				
				$block = $setblogAt->getBlocks('Sidebar');
				$i=0;
				foreach($block as $b) {
					$i++;
					if($i==1){
						$b->setCustomTemplate('categories');
					}elseif($i==2){
						$b->setCustomTemplate('tags');
					}elseif($i==3){
						$b->setCustomTemplate('tag_cloud');
					}elseif($i==4){
						$b->setCustomTemplate('archive');
					}
				}
			}
			
			$setblogAt->reindex();
		}
		$db->Execute('update Pages set cIsSystemPage = 1 where cID = ?', array($search->getCollectionID()));
		
		////////////////////////////////////////////////////////////////////////////
		//new v8 drafter installer
		///////////////////////////////////////////////////////////////////////////
		
		/*
		$draft = Page::getByPath('/problog_editor');
		if(!is_object($draft) || $draft->cID==null){
			$draft = SinglePage::add('/problog_editor', $pkg);
			$draft->setAttribute('exclude_nav',1);
		}
		*/
		

		////////////////////////////////////////////////////////////////////////////
		//pre v9 updates
		///////////////////////////////////////////////////////////////////////////
		
		$blog_editor = UserAttributeKey::getByHandle('blog_editor');
		if($blog_editor->akID){
			$blog_editor->delete();
		}
		
		$group = Group::getByName('ProBlog Editor');
		if(!$group || $group->getGroupID() < 1){
			$group = Group::add('ProBlog Editor','Can create and edit Blog posts');
		}
		
		$pk = PermissionKey::getByHandle('problog_post');
		if(!$pk || $pk->getPermissionKeyID() < 1){
			$pk = AdminPermissionKey::add('admin','problog_post',t('Create Blog Posts'),t('User can use ProBlog frontend features.'),true,false,$pkg);
		}
		
		$pe = GroupPermissionAccessEntity::getOrCreate($group);
		
		$pa = AdminPermissionAccess::create($pk);
		
		$pka = new PermissionAssignment();
		$pka->setPermissionKeyObject($pk);
		$pka->assignPermissionAccess($pa);
		
		$pa->addListItem($pe, false, 10);
		
		$agroup = Group::getByName('ProBlog Approver');
		if(!$agroup || $group->getGroupID() < 1){
			$agroup = Group::add('ProBlog Approver','Can Approve Blog posts');
		}
		
		$apk = PermissionKey::getByHandle('problog_approve');
		if(!$apk || $apk->getPermissionKeyID() < 1){
			$apk = AdminPermissionKey::add('admin','problog_approve',t('Approve Blog Posts'),t('User can Approve ProBlog posts.'),true,false,$pkg);
		}

		$ape = GroupPermissionAccessEntity::getOrCreate($agroup);
		
		$apa = AdminPermissionAccess::create($apk);
		
		$apka = new PermissionAssignment();
		$apka->setPermissionKeyObject($apk);
		$apka->assignPermissionAccess($apa);
		
		$apa->addListItem($ape, false, 10); //add approver
		$pa->addListItem($ape, false, 10); //append approver to edit 
		
		
		////////////////////////////////////////////////////////////////////////////
		//pre v10 updates
		///////////////////////////////////////////////////////////////////////////
		$apib = Page::getByPath('/problog/');
		$api = Page::getByPath('/problog/api/');
		if($api->cID < 1){
		
			$api = SinglePage::add('/problog/api/', $pkg);
			
			$api->setAttribute('exclude_nav',1);
			$api->setAttribute('exclude_page_list',1);
			$api->setAttribute('exclude_sitemapxml',1);
			
			$apib = Page::getByPath('/problog/');
			
		}
		
		$db->Execute('update Pages set cIsSystemPage = 1 where cID = ?', array($apib->getCollectionID()));
		
		//////////
	  	// other attributes
	  	//////////  	
	  	$multiuser = AttributeType::getByHandle('multi_user_picker');
		if(!is_object($multiuser) || !intval($multiuser->getAttributeTypeID()) ) { 
			$multiuser = AttributeType::add('multi_user_picker', t('Multi User Picker'), $pkg);	 
			$eaku->associateAttributeKeyType($multiuser); 
		} 
		
	  	$users = CollectionAttributeKey::getByHandle('subscription'); 
	  	if( !is_object($users) ) {
		 	$users = array(
				'akHandle' => 'subscription',
				'akName' => 'Subscribed Members',
				'akIsSearchable' => 0,
				'akIsSearchableIndexed' => 0,				
				'akIsAutoCreated' => 1,
				'akIsEditable' => 1
			);
			$users = CollectionAttributeKey::add($multiuser,$users,$pkg);
		}	
		/**
		************************************************
		UserBlog Removal
		************************************************
		**/
		/**
			//check for userblog list block and remove
			$userbloglistblock = BlockType::getByHandle('user_blog_list');
			if($userbloglistblock->btID){
				$userbloglistblock->delete();
			}
			
			//check for userblog create page and remove
			$userblog_create = Page::getByPath('/create_user_blog_post');
			if($userblog_create->cID){
				$userblog_create->delete();
			}
			
			//check for userblog dashboard page and remove
			$show_user_blogs = Page::getByPath('/dashboard/problog/list/show_user_blogs');
			if($show_user_blogs->cID){
				$show_user_blogs->delete();
			}
		**/
			//check for userblog dashboard page and remove
			$userblog_dashboard = Page::getByPath('/dashboard/problog/user_blogs');
			if($userblog_dashboard->cID){
				$userblog_dashboard->delete();
			}
		/**
			//check for userblog profile page and remove
			$userblog_profile = Page::getByPath('/profile/user_blog');
			if($userblog_profile->cID){
				$userblog_profile->delete();
			}
			
			//check for userblog page type and remove
			$userblog_ct = CollectionType::getByHandle('user_blog_list');
			if($userblog_ct->ctID){
				$userblog_ct->delete();
				$userblog_ct = CollectionType::getByHandle('user_blog_post');
				$userblog_ct->delete();
			}
		**/
		$bt = BlockType::getByHandle('related_pages');
		if(!$bt){
			BlockType::installBlockTypeFromPackage('related_pages', $pkg);	
		}
		
		$draft = Page::getByPath('/problog_editor');
		if(is_object($draft)){
			$draft->delete();
		}
		$draft = Page::getByPath('/profile/problog_editor');
		if(!is_object($draft) || $draft->cID==null){
			$draft = SinglePage::add('/profile/problog_editor', $pkg);
			$draft->update(array('cName'=>t('Blog'), 'cDescription'=>t('Blog Management')));
		}
		parent::upgrade();

	}
	
	public function install() {
		
		$this->load_required_models();
		
		Config::save('ENABLE_CACHE', 0);
	
		$pkg = parent::install();
		
		$this->install_pb_blocks($pkg);
		$this->install_pb_singlepages($pkg);
		$this->install_pb_attributes($pkg);
		$this->install_pb_user_attributes($pkg);
		$this->install_pb_pages($pkg);
		$this->install_pb_page_defaults($pkg);
		$this->install_pb_settings();
      
	}
	
	function install_pb_blocks($pkg){
	
		//install blocks
		cache::flush();
	  	BlockType::installBlockTypeFromPackage('problog_list', $pkg);	
	  	BlockType::installBlockTypeFromPackage('trackback', $pkg);	
	  	BlockType::installBlockTypeFromPackage('latest_comments', $pkg);
	  	BlockType::installBlockTypeFromPackage('problog_date_archive', $pkg);	
	  	$bt = BlockType::getByHandle('related_pages');
		if(!$bt){
			BlockType::installBlockTypeFromPackage('related_pages', $pkg);	
		}
	}
	
	function install_pb_singlepages($pkg){
	
		$db = Loader::db();
	
		$iak = CollectionAttributeKey::getByHandle('icon_dashboard');
		
		$pbp = SinglePage::add('/dashboard/problog', $pkg);
		$pbp->update(array('cName'=>t('Pro Blog'), 'cDescription'=>t('Blog Management')));
		
		$pbl = SinglePage::add('/dashboard/problog/list', $pkg);
		$pbl = Page::getByPath('/dashboard/problog/list');
		$pbl->setAttribute($iak,'icon-list-alt');
		
		$pba = SinglePage::add('/dashboard/problog/add_blog', $pkg);
		$pba->update(array('cName'=>t('Add/Edit')));
		$pba = Page::getByPath('/dashboard/problog/add_blog');
		$pba->setAttribute($iak,'icon-pencil');
		
		$pbc = SinglePage::add('/dashboard/problog/comments', $pkg);
		$pbc->update(array('cName'=>t('Comments')));
		$pbc = Page::getByPath('/dashboard/problog/comments');
		$pbc->setAttribute($iak,'icon-comment');
		
		$pbs = SinglePage::add('/dashboard/problog/settings', $pkg);
		$pbs->update(array('cName'=>t('Settings')));
		$pbs = Page::getByPath('/dashboard/problog/settings');
		$pbs->setAttribute($iak,'icon-wrench');
		
		$pbl = SinglePage::add('/dashboard/problog/help', $pkg);
		$pbl->update(array('cName'=>t('Help')));
		$pbl = Page::getByPath('/dashboard/problog/help');
		$pbl->setAttribute($iak,'icon-question-sign');
		
		
		$tags = Page::getByPath('/blogsearch');
		if(!is_object($tags) || $tags->cID==null){
			$tags = SinglePage::add('/blogsearch', $pkg);
			$tags->setAttribute('exclude_nav',1);
		}

		$draft = Page::getByPath('/profile/problog_editor');
		if(!is_object($draft) || $draft->cID==null){
			$draft = SinglePage::add('/profile/problog_editor', $pkg);
			$draft->update(array('cName'=>t('Blog'), 'cDescription'=>t('Blog Management')));
		}
		
		$api = Page::getByPath('/problog/api/');
		if($api->cID < 1){
		
			$api = SinglePage::add('/problog/api/', $pkg);
			
			$api->setAttribute('exclude_nav',1);
			$api->setAttribute('exclude_page_list',1);
			$api->setAttribute('exclude_sitemapxml',1);
			
			$apib = Page::getByPath('/problog/');
			$db->Execute('update Pages set cIsSystemPage = 1 where cID = ?', array($apib->getCollectionID()));
		}
		/*
		$userBlogSettings = SinglePage::add('/dashboard/problog/user_blogs', $pkg);
		$userBlogSettings->update(array('cName' => t('User Blogs'), 'cDescription' => t('Manage user blogs.')));
		$userBlogSettings->setAttribute($iak,'icon-list-alt');
		*/
	}
  
	function install_pb_attributes($pkg) {
  
  	$eaku = AttributeKeyCategory::getByHandle('collection');
  	$eaku->setAllowAttributeSets(AttributeKeyCategory::ASET_ALLOW_SINGLE);
  	$evset = $eaku->addSet('problog', t('Pro Blog'),$pkg);
  	
  	
  	$bset = AttributeSet::getByHandle('problog_additional_attributes');
	if(!is_object($bset)){
		$bset = $eaku->addSet('problog_additional_attributes', t('ProBlog Additional Attributes'),$pkg);
	}
  	
  	
  	$userpicker = AttributeType::getByHandle('user_picker');
	if(!is_object($userpicker) || !intval($userpicker->getAttributeTypeID()) ) { 
		$userpicker = AttributeType::add('user_picker', t('User Picker'), $pkg);	
		$eaku->associateAttributeKeyType($userpicker);  
	} 
 
	$multiuser = AttributeType::getByHandle('multi_user_picker');
	if(!is_object($multiuser) || !intval($multiuser->getAttributeTypeID()) ) { 
		$multiuser = AttributeType::add('multi_user_picker', t('Multi User Picker'), $pkg);	 
		$eaku->associateAttributeKeyType($multiuser); 
	} 
  	
  	$blogauth=CollectionAttributeKey::getByHandle('blog_author'); 
	if( !is_object($blogauth) ) {
     	CollectionAttributeKey::add($userpicker, 
     	array('akHandle' => 'blog_author', 
     	'akName' => t('Blog Author')
     	),$pkg)->setAttributeSet($evset); 
  	}


    $checkn = AttributeType::getByHandle('boolean'); 
  	$blogsec=CollectionAttributeKey::getByHandle('blog_section'); 
	if( !is_object($blogsec) ) {
     	CollectionAttributeKey::add($checkn, 
     	array('akHandle' => 'blog_section', 
     	'akName' => t('Blog Section'),
     	'akIsSearchable' => 1, 
     	'akIsSearchableIndexed' => 1	
     	),$pkg)->setAttributeSet($evset); 
  	}
  	
  	
    $pulln = AttributeType::getByHandle('select'); 
  	$blogcat=CollectionAttributeKey::getByHandle('blog_category'); 
	if( !is_object($blogcat) ) {
     	CollectionAttributeKey::add($pulln, 
     	array('akHandle' => 'blog_category', 
     	'akName' => t('Blog Category'), 
     	'akIsSearchable' => 1, 
     	'akIsSearchableIndexed' => 1, 
		'akSelectAllowOtherValues' => true
     	),$pkg)->setAttributeSet($evset); 
  	}
  	
  	
  	$blogtag=CollectionAttributeKey::getByHandle('tags'); 
	if( !is_object($blogtag) ) {
     	CollectionAttributeKey::add($pulln, 
     	array('akHandle' => 'tags', 
     	'akName' => t('Tags'), 
     	'akIsSearchable' => 1, 
     	'akIsSearchableIndexed' => 1, 
		'akSelectAllowMultipleValues' => true, 
		'akSelectAllowOtherValues' => true
     	),$pkg)->setAttributeSet($evset); 
  	}else{
  		$blogtag->update(array('akHandle' => 'tags', 
     	'akName' => t('Tags'), 
     	'akIsSearchable' => 1, 
     	'akIsSearchableIndexed' => 1, 
		'akSelectAllowMultipleValues' => true, 
		'akSelectAllowOtherValues' => true
     	));
  	}
  	
  	
    $imagen = AttributeType::getByHandle('image_file'); 
  	$blogthum=CollectionAttributeKey::getByHandle('thumbnail'); 
	if( !is_object($blogthum) ) {
     	CollectionAttributeKey::add($imagen, 
     	array('akHandle' => 'thumbnail', 
     	'akName' => t('Thumbnail Image'), 
     	),$pkg);
  	}
  	
  	/*
  	** DEPRECATED **
  	$blogman=UserAttributeKey::getByHandle('blog_editor'); 
	if( !is_object($blogman) ) {
     	UserAttributeKey::add($checkn, 
     	array('akHandle' => 'blog_editor', 
     	'akName' => t('Blog Editor'),
     	'uakProfileEdit' => '1'
     	),$pkg); 
  	}
  	*/
  	
  	//$demoUser = UserInfo::getByID(2);
	//$demoUser->setAttribute('blog_editor','1');
  	
	$textt = AttributeType::getByHandle('text'); 
	$apikey = UserAttributeKey::getByHandle('c5_api_key'); 
	if( !is_object($apikey) ) {
	 	UserAttributeKey::add($textt, 
	 	array('akHandle' => 'c5_api_key', 
	 	'akName' => t('API Key'), 
	 	'akIsSearchable' => false, 
	 	'uakProfileEdit' => false, 
	 	'uakProfileEditRequired'=> false, 
	 	'uakRegisterEdit' => false, 
	 	'uakProfileEditRequired'=>false
	 	),$pkg);
	 }
	 
  	//////////
  	// additional blog attributes
  	//////////
  	$textn = AttributeType::getByHandle('text'); 
  	$eventurl=CollectionAttributeKey::getByHandle('post_location'); 
	if( !is_object($eventurl) ) {
     	CollectionAttributeKey::add($textn, 
     	array('akHandle' => 'post_location', 
     	'akName' => t('Post Geodata'), 
     	),$pkg)->setAttributeSet($evset); 
  	}
  	
  	
  	//////////
  	// other attributes
  	//////////  	
  	$users = CollectionAttributeKey::getByHandle('subscription'); 
  	if( !is_object($users) ) {
	 	$users = array(
			'akHandle' => 'subscription',
			'akName' => 'Subscribed Members',
			'akIsSearchable' => 0,
			'akIsSearchableIndexed' => 0,				
			'akIsAutoCreated' => 1,
			'akIsEditable' => 1
		);
		$users = CollectionAttributeKey::add($multiuser,$users,$pkg);
	}
  	
  	
  }
  
	function install_pb_pages($pkg) {
	
		$db = Loader::db();
		
		$blogPageType = CollectionType::getByHandle('pb_post');
		if(!is_object($blogPageType) || $blogPageType==false){  
	  		$blogPageType = array('ctHandle' => 'pb_post', 'ctName' => t('ProBlog Post'),'ctIcon'=>t('template3.png'));
      		CollectionType::add($blogPageType, $pkg);
      	}
	 

 		$pageType= CollectionType::getByHandle('left_sidebar');
     	if(!is_object($pageType) || $pageType==false){  
     		$pageType= CollectionType::getByHandle('right_sidebar');
    	 }
  		if(!is_object($pageType) || $pageType==false){  
     		$pageType = CollectionType::getByHandle('default');
    	 }
    	if(!is_object($pageType) || $pageType==false){  
     		$pageType = CollectionType::getByHandle('page');
    	 }
		
		$setblogAt = Page::getByPath('/blog');

		if(!is_object($setblogAt) || $setblogAt->cID==null){
    		$pageeventParent = Page::getByID(HOME_CID);    	
    		$setblogAt = $pageeventParent->add($pageType, array('cName' => 'Blog', 'cHandle' => 'blog', 'pkgID'=>$pkg->pkgID)); 
    		$setblogAt->setAttribute('blog_section',true);
   		}else{
   			$setblogAt->setAttribute('blog_section',true);
   		}
 
	    
	    //var_dump(Page::getByPath('/blog'));
	    $setblogAt = Page::getByPath('/blog');
	    
	    $block = $setblogAt->getBlocks('Main');
		foreach($block as $b) {
			$b->delete();
		}
		
		
		$block = $setblogAt->getBlocks('Sidebar');
		foreach($block as $b) {
			$b->delete();
		}
	    
	    $pageType = CollectionType::getByHandle('pb_post');
		$ctID = $pageType->getCollectionTypeID();
	    
	    $bt = BlockType::getByHandle('problog_list');
	    $cParentID = $setblogAt->getCollectionID();
			
		$data = array('num' => '10',
		'cParentID'=>$cParentID,
		'cThis'=>'0',
		'paginate'=>'1',
		'displayAliases'=>'1',
		'ctID'=> $ctID,
		'rss'=>'1',
		'rssTitle'=>t('Latest blog'),
		'orderBy'=>'chrono_desc',
		'rssDescription'=>t('Our latest blog feed'),
		'truncateSummaries'=>'0',
		'truncateChars'=>'128',
		'category'=>t('All Categories'),
		'title'=>t('Our Latest Blog Posts')
		);			
					
		$b = $setblogAt->addBlock($bt, 'Main', $data);
		$b->setCustomTemplate('templates/micro_blog');
		
		$i = 0;
		for($bb=1;$bb<=4;$bb+=1){	
			
			if($bb==1){
				$title=t('Category List');
			}elseif($bb==2){
				$title=t('Tag List');
			}elseif($bb==3){
				$title=t('Tag Cloud');
			}elseif($bb==4){
				$title=t('Archive');
			}
		
			$data = array('num' => '25',
			'cParentID'=>'0',
			'cThis'=>'0',
			'paginate'=>'0',
			'displayAliases'=>'0',
			'ctID'=>$ctID,
			'rss'=>'0',
			'rssTitle'=>'',
			'rssDescription'=>'',
			'truncateSummaries'=>'0',
			'truncateChars'=>'128',
			'category'=>t('All Categories'),
			'title'=>$title
			);			
						
			$b = $setblogAt->addBlock($bt, 'Sidebar', $data);
			
			$i++;
			if($i==1){
				$b->setCustomTemplate('categories');
			}elseif($i==2){
				$b->setCustomTemplate('tags');
			}elseif($i==3){
				$b->setCustomTemplate('tag_cloud');
			}elseif($i==4){
				$b->setCustomTemplate('archive');
			}
		}
		
		$setblogAt->reindex();
		
		
		/////////////////////////
	    //now we go add blocks to the /blogsearch singlepage
	    ////////////////////////
	    $setSearchAt = Page::getByPath('/blogsearch');
	    
	    $block = $setSearchAt->getBlocks('Main');
		foreach($block as $b) {
			$b->delete();
		}
		
		
		$block = $setSearchAt->getBlocks('Sidebar');
		foreach($block as $b) {
			$b->delete();
		}
	    
	    $bt = BlockType::getByHandle('search');
	    $searchPath = $setblogAt->getCollectionPath();
			
		$data = array('title' => t('Blog Search'),
		'buttonText'=>t('go'),
		'baseSearchPath'=>$searchPath,
		'resultsURL'=>''
		);			
					
		$setSearchAt->addBlock($bt, 'Main', $data);
		
		$block = $setSearchAt->getBlocks('Main');
		foreach($block as $b) {
			$b->setCustomTemplate('templates/blog_search');
		}
		
		
		$bt = BlockType::getByHandle('problog_list');
		$i = 0;
		for($bb=1;$bb<=4;$bb+=1){	
			
			if($bb==1){
				$title=t('Category List');
			}elseif($bb==2){
				$title=t('Tag List');
			}elseif($bb==3){
				$title=t('Tag Cloud');
			}elseif($bb==4){
				$title=t('Archive');
			}
		
			$data = array('num' => '25',
			'cParentID'=>'0',
			'cThis'=>'0',
			'paginate'=>'0',
			'displayAliases'=>'0',
			'ctID'=>$ctID,
			'rss'=>'0',
			'rssTitle'=>'',
			'rssDescription'=>'',
			'truncateSummaries'=>'0',
			'truncateChars'=>'128',
			'category'=>t('All Categories'),
			'title'=>$title
			);			
						
			$b = $setSearchAt->addBlock($bt, 'Sidebar', $data);
			
			$i++;
			if($i==1){
				$b->setCustomTemplate('categories');
			}elseif($i==2){
				$b->setCustomTemplate('tags');
			}elseif($i==3){
				$b->setCustomTemplate('tag_cloud');
			}elseif($i==4){
				$b->setCustomTemplate('archive');
			}
		}
		
		$setSearchAt->reindex();
		
  }
	
	function install_pb_page_defaults() {
	  
	    $blogPostCollectionTypeMT = CollectionType::getByHandle('pb_post')->getMasterTemplate();		
		$pageType = CollectionType::getByHandle('pb_post');
		$ctID = $pageType->getCollectionTypeID();
		$bt = BlockType::getByHandle('problog_list');
		
		$cIDn = Page::getByPath('/blog')->getCollectionID();
		
		$blocks = $blogPostCollectionTypeMT->getBlocks('Sidebar');
		foreach($blocks as $b) {
			$b->deleteBlock();
		}
		
		$i = 0;
		for($bb=1;$bb<=4;$bb+=1){	
			
			if($bb==1){
				$title=t('Category List');
			}elseif($bb==2){
				$title=t('Tag List');
			}elseif($bb==3){
				$title=t('Tag Cloud');
			}elseif($bb==4){
				$title=t('Archive');
			}
		
			$data = array('num' => '25',
			'cParentID'=>'0',
			'cThis'=>'0',
			'paginate'=>'0',
			'displayAliases'=>'0',
			'ctID'=>$ctID,
			'rss'=>'0',
			'rssTitle'=>'',
			'rssDescription'=>'',
			'truncateSummaries'=>'0',
			'truncateChars'=>'128',
			'category'=>t('All Categories'),
			'title'=>$title
			);			
						
			$b = $blogPostCollectionTypeMT->addBlock($bt, 'Sidebar', $data);
			$i++;
			if($i==1){
				$b->setCustomTemplate('categories');
			}elseif($i==2){
				$b->setCustomTemplate('tags');
			}elseif($i==3){
				$b->setCustomTemplate('tag_cloud');
			}elseif($i==4){
				$b->setCustomTemplate('archive');
			}
		}


		
		//install guestbook to page_type template
		$guestBookBT = BlockType::getByHandle('guestbook'); 
		$guestbookArray = array();	
		$guestbookArray['requireApproval'] = 1;
		$guestbookArray['title'] = t('Please add a comment');
		$guestbookArray['displayCaptcha'] = 1;
		$guestbookArray['authenticationRequired'] = 1;
		$guestbookArray['displayGuestBookForm'] = 1;
		$guestbookArray['notifyEmail'] = '';
		$blogPostCollectionTypeMT->addBlock($guestBookBT, 'Blog Post More', $guestbookArray);
		
		$block = $blogPostCollectionTypeMT->getBlocks('Blog Post More');
		foreach($block as $b) {
			if($b->getBlockTypeHandle()=='guestbook'){
				$b->setCustomTemplate('nuvo_guestbook');
			}
		}
		
		//install next/prev to page_type template
		$bt = BlockType::getByHandle('next_previous');
		if(is_object($bt)){
			$bt_array = array();
			$bt_array['linkStyle'] = 'next_previous';
		    $bt_array['nextLabel'] = t('next');
		    $bt_array['previousLabel'] = t('prev');                    
		    $bt_array['showArrows'] = '1';
		    $bt_array['loopSequence'] = '1';
		    $bt_array['excludeSystemPages'] = '1';
		    $blogPostCollectionTypeMT->addBlock($bt,'Blog Post Footer', $bt_array);                    
		}
		
		$bt = BlockType::getByHandle('trackback');
		if(is_object($bt)){
			$bt_array = array();
		    $blogPostCollectionTypeMT->addBlock($bt,'Blog Post Trackback', $bt_array);                    
		}
		
	}
  
	function install_pb_user_attributes($pkg) {
	
		$euku = AttributeKeyCategory::getByHandle('user');
			$euku->setAllowAttributeSets(AttributeKeyCategory::ASET_ALLOW_MULTIPLE);
			$uset = $euku->addSet('user_set', t('Author Info'),$pkg);
		
		$texta = AttributeType::getByHandle('textarea'); 
			$sbbio=UserAttributeKey::getByHandle('user_bio'); 
		if( !is_object($sbbio) ) {
		 	UserAttributeKey::add($texta, 
		 	array('akHandle' => 'user_bio', 
		 	'akName' => t('About the author'),
		 	'akIsSearchable' => false, 
		 	'uakProfileEdit' => true, 
		 	'uakProfileEditRequired'=> true, 
		 	'uakRegisterEdit' => true, 
		 	'uakProfileEditRequired'=>true,
		 	'akCheckedByDefault' => true,
		 	'displayOrder'=> '3'
		 	),$pkg)->setAttributeSet($uset); 
			}
			$textt = AttributeType::getByHandle('text'); 
			$sblname=UserAttributeKey::getByHandle('last_name'); 
		if( !is_object($sblname) ) {
		 	UserAttributeKey::add($textt, 
		 	array('akHandle' => 'last_name', 
		 	'akName' => t('Last Name'), 
		 	'akIsSearchable' => false, 
		 	'uakProfileEdit' => true, 
		 	'uakProfileEditRequired'=> true, 
		 	'uakRegisterEdit' => true, 
		 	'uakProfileEditRequired'=>true,
		 	'akCheckedByDefault' => true,
		 	'displayOrder'=> '2'
		 	),$pkg)->setAttributeSet($uset); 
			}
			$sbname=UserAttributeKey::getByHandle('first_name'); 
		if( !is_object($sbname) ) {
		 	UserAttributeKey::add($textt, 
		 	array('akHandle' => 'first_name', 
		 	'akName' => t('First Name'), 
		 	'akIsSearchable' => false, 
		 	'uakProfileEdit' => true, 
		 	'uakProfileEditRequired'=> true, 
		 	'uakRegisterEdit' => true, 
		 	'uakProfileEditRequired'=>true,
		 	'akCheckedByDefault' => true,
		 	'displayOrder'=> '1'
		 	),$pkg)->setAttributeSet($uset); 
		}

		
		$group = Group::getByName('ProBlog Editor');
		if(!$group || $group->getGroupID() < 1){
			$group = Group::add('ProBlog Editor','Can create and edit Blog posts');
		}
		
		$pk = PermissionKey::getByHandle('problog_post');
		if(!$pk || $pk->getPermissionKeyID() < 1){
			$pk = AdminPermissionKey::add('admin','problog_post',t('Create Blog Posts'),t('User can use ProBlog frontend features.'),true,false,$pkg);
		}
		
		$pe = GroupPermissionAccessEntity::getOrCreate($group);
		
		$pa = AdminPermissionAccess::create($pk);
		
		$pka = new PermissionAssignment();
		$pka->setPermissionKeyObject($pk);
		$pka->assignPermissionAccess($pa);
		
		$pa->addListItem($pe, false, 10);
		
		$agroup = Group::getByName('ProBlog Approver');
		if(!$agroup || $group->getGroupID() < 1){
			$agroup = Group::add('ProBlog Approver','Can Approve Blog posts');
		}
		
		$apk = PermissionKey::getByHandle('problog_approve');
		if(!$apk || $apk->getPermissionKeyID() < 1){
			$apk = AdminPermissionKey::add('admin','problog_approve',t('Approve Blog Posts'),t('User can Approve ProBlog posts.'),true,false,$pkg);
		}

		$ape = GroupPermissionAccessEntity::getOrCreate($agroup);
		
		$apa = AdminPermissionAccess::create($apk);
		
		$apka = new PermissionAssignment();
		$apka->setPermissionKeyObject($apk);
		$apka->assignPermissionAccess($apa);
		
		$apa->addListItem($ape, false, 10); //add approver
		$pa->addListItem($ape, false, 10); //append approver to edit 

	}
	
	function install_pb_api($pkg){
		Loader::model('single_page');
		$api = SinglePage::add('/problog/api/', $pkg);
		$api->setAttribute('exclude_nav',1);
		$api->setAttribute('exclude_page_list',1);
		$api->setAttribute('exclude_sitemapxml',1);
		
		$apib = Page::getByPath('/problog/');
		$apib->setAttribute('exclude_nav',1);
		$apib->setAttribute('exclude_page_list',1);
		$apib->setAttribute('exclude_sitemapxml',1);

        
		$textt = AttributeType::getByHandle('text'); 
		$apikey = UserAttributeKey::getByHandle('c5_api_key'); 
		if( !is_object($apikey) ) {
		 	UserAttributeKey::add($textt, 
		 	array('akHandle' => 'c5_api_key', 
		 	'akName' => t('API Key'), 
		 	'akIsSearchable' => false, 
		 	'uakProfileEdit' => false, 
		 	'uakProfileEditRequired'=> false, 
		 	'uakRegisterEdit' => false, 
		 	'uakProfileEditRequired'=>false
		 	),$pkg);
		 }
	}
	
	function install_pb_settings(){
	
		$pb_post= CollectionType::getByHandle('pb_post');
		$serch = Page::getByPath('/blogsearch');
		$args= array(
			'tweet'=>1,
			'fb_like'=>1,
			'google'=>0,
			'addthis'=>1,
			'author'=>0,
			'comments'=>1,
			'trackback'=>1,
			'canonical'=>1,
			'search_path'=>$serch->getCollectionID(),
			'icon_color'=>'brown',
			'thumb_width'=>'110',
			'thumb_height'=>'120',
			'ctID'=> $pb_post->ctID
		);
		
		$db= Loader::db();
		$db->execute("DELETE from btProBlogSettings");
		$s = ("INSERT INTO btProBlogSettings (tweet,fb_like,google,addthis,author,comments,trackback,canonical,search_path,icon_color,thumb_width,thumb_height,ctID) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
		
		$db->query($s,$args);
	
	}
  
	function load_required_models() {
	    Loader::model('single_page');
	    Loader::model('collection');
	    Loader::model('page');
	    loader::model('block');
	    Loader::model('collection_types');
	    Loader::model('/attribute/categories/collection');
	    Loader::model('/attribute/categories/user');
	    Loader::model('/permission/access/entity/types/group');
	    Loader::model('/permission/access/model');
	    Loader::model('/permission/access/categories/admin');
	    Loader::model('/permission/category');
	    Loader::model('/permission/keys/admin');
	    Loader::model('/permission/assignment');
	    Loader::model('/workflow/type');
	    Loader::model('groups');
	  }		
  
	public function on_start(){
	
	Events::extend('on_problog_submit', 'ProBlogSubscription', 'onSubmit', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/models/events/problog_submit.php');

  	if(version_compare(APP_VERSION,'5.4.1.1', '>')){
	  	$ihm = Loader::helper('concrete/interface/menu');
		//Loader::model('section', 'multilingual');		
		$uh = Loader::helper('concrete/urls');
		$u = new User();
		if(!is_array($_REQUEST['cID'])){
			$blog = Page::getByID($_REQUEST['cID']);
			$canonical_parent_id = Loader::helper('blogify','problog')->getCanonicalParent($blog->getCollectionDatePublic(),$blog);
			$parent = Page::getByID($canonical_parent_id);
			if($parent->getAttribute('blog_section') > 0){
				$title = t('Edit');
				if($u->isLoggedIn()){
					cache::flush();
				}
			}else{
				$title = t('Create');
			}
			
			$ihm->addPageHeaderMenuItem('problog', $title.t(' Blog Post'), 'right', array(
					'dialog-title' => t('ProBlog Post'),
				'href' => $uh->getToolsUrl('add_post', 'problog').'?blogID='.$_REQUEST['cID'],
				'dialog-on-open' => "$(\'#ccm-page-edit-nav-problog\').removeClass(\'ccm-nav-loading\')",
				'dialog-on-close' => "location.reload();",
				'dialog-width' => '700',
				'dialog-height' => "500",
				'dialog-modal' => "false",
				'class' => 'dialog-launch'
			), 'problog');
		}	

  	}
  }			
}