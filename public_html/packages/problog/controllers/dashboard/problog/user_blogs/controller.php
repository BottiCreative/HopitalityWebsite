<?php        

defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardProblogUserBlogsController extends Controller {

     public function on_start() {
          $co = new Config;
          $pkg = Package::getByHandle('problog');
          $co->setPackageObject($pkg);
          $cID = $co->get("USER_BLOGS_PARENT_PAGE");
          $this->set("cID", $cID);
          $name_format = $co->get("USER_BLOG_PAGE_PATH_FORMAT");
          $this->set("name_format", $name_format);
          $attribute_handle_share = $co->get("USER_BLOG_SHARE_ATTRIBUTE");
          $this->set("attribute_handle_share", $attribute_handle_share);
     }

     public function save_config_new(){
          $co = new Config;
		$pkg = Package::getByHandle('problog');
		$co->setPackageObject($pkg);
		$co->save("USER_BLOGS_PARENT_PAGE", $_REQUEST['user_blog_page']);
         $co->save("USER_BLOG_PAGE_PATH_FORMAT", $_REQUEST['name_format']);
         $co->save("USER_BLOG_SHARE_ATTRIBUTE", $_REQUEST['attribute_handle_share']);
          $this->set("message", t("Config Saved Successfully"));
     }
     
     public function install_userblogs(){
     	if($_REQUEST['enable_user_blogs']==1){
			Config::save('ENABLE_USER_PROFILES', true);
			$pkg = Package::getByHandle('problog');

			$this->load_required_models();
			$this->install_ub_elements($pkg);
			$this->install_ub_blocks($pkg);
			$this->install_ub_singlepages($pkg);
			$this->install_ub_attributes($pkg);
			$this->install_ub_pages($pkg);
			
			$this->redirect('/dashboard/problog/user_blogs/user_blogs_installed');
		}
     }
     
    public function user_blogs_installed(){
	     $this->set('message',t('UserBlogs has been successfully installed!'));
     }
     
	function install_ub_elements($pkg){
	
			$eventsFile = DIR_BASE."/config/site_events.php";
			if(is_file($eventsFile)){
				if(is_writable($eventsFile)) {
					$fp = fopen($eventsFile,'a');
					fwrite($fp, "<?php       
	Events::extendPageType('user_blog_post', 'on_page_add');
	Events::extendPageType('user_blog_list', 'on_page_add'); 
	?>");
					fclose($fp);
				} else {
					throw new Exception(t("Your site_events.php file is not writeable by the webserver, please add this to your config/site.php: 
	
	Events::extendPageType('user_blog_post', 'on_page_add');
	Events::extendPageType('user_blog_list', 'on_page_add');"));
				}
			}else{
				//copy eventfile to root
				$fh = Loader::helper('file');
				$source = DIR_BASE . '/packages/problog/config';
				$target = DIR_BASE . '/config';
				$fh->copyAll($source, $target);
			}
			
			if(!ENABLE_APPLICATION_EVENTS){
				$configFile = DIR_BASE."/config/site.php";
				if(is_writable($configFile)) {
					$fp = fopen($configFile,'a');
					fwrite($fp, "<?php       define('ENABLE_APPLICATION_EVENTS', true); ?>");
					fclose($fp);
				} else {
					throw new Exception(t("Your site.php file is not writeable by the webserver, please add this to your config/site.php: define('ENABLE_APPLICATION_EVENTS', true);"));
				}
			}
			
			$sidebarFile = DIR_BASE."/elements/profile/sidebar.php";
			if(!is_file($sidebarFile)){
				//copy over root level override for profile menu
				$fh = Loader::helper('file');
				$source = DIR_BASE . '/packages/problog/elements/profile';
				$target = DIR_BASE . '/elements/profile';
				$fh->copyAll($source, $target);
			}
	}
	
	function install_ub_blocks($pkg){
		BlockType::installBlockTypeFromPackage('user_blog_list', $pkg);
	}
	
	function install_ub_singlepages($pkg){
		
		$user_blog_list = SinglePage::add('/dashboard/problog/list/show_user_blogs', $pkg);
		
		$usrblog = SinglePage::add('/profile/user_blog', $pkg);
		
		$usrbloghelp = SinglePage::add('/dashboard/problog/help/user_blogs', $pkg);
		
		$userBlogPost = SinglePage::add('/create_user_blog_post', $pkg);
		$userBlogPost->update(array('cName' => t('Create User Blog Post'), 'cDescription' => t('Create and publish user blog posts.')));
		$userBlogPost->setAttribute('exclude_nav', 1);
	}

	function install_ub_attributes($pkg){
	
			$col = AttributeKeyCategory::getByHandle('collection');
			$pageselector = AttributeType::add('page_selector', t('Page Selector'), $pkg);
			$col->associateAttributeKeyType(AttributeType::getByHandle('page_selector'));
	
			$checkn = AttributeType::getByHandle('boolean'); 
			$pageselectort = AttributeType::getByHandle('page_selector');
			$selectt = AttributeType::getByHandle('select');
			
		  	$blogsec=CollectionAttributeKey::getByHandle('user_blog_section'); 
			if( !is_object($blogsec) ) {
		     	CollectionAttributeKey::add($checkn, 
		     	array('akHandle' => 'user_blog_section', 
		     	'akName' => t('User Blog Section')
		     	),$pkg); 
		  	}

			$share_with = CollectionAttributeKey::getByHandle('share_with');
			if (!$share_with instanceof CollectionAttributeKey) {
				$share_with = CollectionAttributeKey::add($selectt, array(
						'akHandle' => 'share_with',
						'akName' => t('Share With'),
						'akIsSearchable' => true,
						'akIsSearchableIndexed' => 1,
						'akSelectAllowMultipleValues' => false,
						'akSelectAllowOtherValues' => true,
						'akSelectOptionDisplayOrder' => 'alpha_asc'), $pkg);
						$ak=CollectionAttributeKey::getByHandle('share_with');
						SelectAttributeTypeOption::add($ak,'all');
						SelectAttributeTypeOption::add($ak,'me');
     					SelectAttributeTypeOption::add($ak,'selected ');
			}

			$department = UserAttributeKey::getByHandle("blog_group");
			if (!$department instanceof UserAttributeKey) {
				$department = UserAttributeKey::add($selectt, array(
						'akHandle' => 'blog_group',
						'akName' => t('Blog Group'),
						'akIsSearchable' => true,
						'akIsSearchableIndexed' => 1,
						'akSelectAllowMultipleValues' => false,
						'akSelectAllowOtherValues' => false,
						'akSelectOptionDisplayOrder' => 'alpha_asc',
						'uakProfileDisplay' => 1,
						'uakMemberListDisplay' => 0,
						'uakProfileEdit' => 1,
						'uakProfileEditRequired' => 0,
						'uakRegisterEdit' => 1,
						'uakRegisterEditRequired' => 0), $pkg);
			}

			$blocation = UserAttributeKey::getByHandle("blog_location");
			if (!$blocation instanceof UserAttributeKey) {
				$blocation = UserAttributeKey::add($pageselectort, array(
						'akHandle' => 'blog_location',
						'akName' => t('Page Redirect'),
						'akIsSearchable' => false,
						'uakProfileDisplay' => 0,
						'uakMemberListDisplay' => 0,
						'uakProfileEdit' => 0,
						'uakProfileEditRequired' => 0,
						'uakRegisterEdit' => 0,
						'uakRegisterEditRequired' => 0
						), $pkg);
			}
	}

	function install_ub_pages($pkg){

		$userBlogList = CollectionType::getByHandle('user_blog_list');
		if (!is_object($userBlogList)) {
			$data = array('ctHandle' => 'user_blog_list', 'ctName' => t('User Blog List Page'));
			$userBlogList = CollectionType::add($data, $pkg);
		}
		$userBlogList = CollectionType::getByHandle('user_blog_list');


		$userBlogPost = CollectionType::getByHandle('user_blog_post');
		if (!is_object($userBlogPost)) {
			$data = array('ctHandle' => 'user_blog_post', 'ctName' => t('User Blog Post Page'));
			$userBlogPost = CollectionType::add($data, $pkg);
		}
		$userBlogPost = CollectionType::getByHandle('user_blog_post');
		
		
		$userBlogPostCTID = $userBlogPost->getCollectionTypeID();
			
		$user_blog_profile_page = Page::getByPath('/profile/user_blog'); 
    	
    	$ubList = BlockType::getByHandle('user_blog_list');
    	
    	if (is_object($userBlogPost)){
			$userblog_master = $userBlogPost->getMasterTemplate();
			
			$blocks = $userblog_master->getBlocks('Sidebar');
			foreach ($blocks as $b) {
				$b->deleteBlock();
			}
			
			$i=0;
			for ($bb = 1; $bb <= 4; $bb+=1) {

				if ($bb == 1) {
					$title = 'Category List';
				} elseif ($bb == 2) {
					$title = 'Tag List';
				} elseif ($bb == 3) {
					$title = 'Tag Cloud';
				} elseif ($bb == 4) {
					$title = 'Archive';
				}

				$data = array('num' => '9999',
					'cParentID' => '0',
					'cThis' => '0',
					'paginate' => '0',
					'displayAliases' => '0',
					'ctID' => $userBlogPostCTID,
					'rss' => '0',
					'rssTitle' => '',
					'rssDescription' => '',
					'truncateSummaries' => '0',
					'truncateChars' => '128',
					'category' => 'All Categories',
					'title' => $title
				);

				$b = $userblog_master->addBlock($ubList, 'Sidebar', $data);
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
		
    	if (is_object($userBlogList)){
			$userbloglist_master = $userBlogList->getMasterTemplate();
			
			$data1 = array('num' => '10',
				'cParentID' => '0',
				'cThis' => '1',
				'paginate' => '1',
				'displayAliases' => '1',
				'ctID' => $userBlogPostCTID,
				'rss' => '1',
				'rssTitle' => 'Latest blog',
				'orderBy' => 'chrono_desc',
				'rssDescription' => 'Our latest blog feed',
				'truncateSummaries' => '0',
				'truncateChars' => '128',
				'category' => 'All Categories',
				'title' => 'Our Latest Blog Posts'
			);
			
			$data = array('num' => '10',
				'cParentID' => '0',
				'cThis' => '0',
				'paginate' => '1',
				'displayAliases' => '1',
				'ctID' => $userBlogPostCTID,
				'rss' => '1',
				'rssTitle' => 'Latest blog',
				'orderBy' => 'chrono_desc',
				'rssDescription' => 'Our latest blog feed',
				'truncateSummaries' => '0',
				'truncateChars' => '128',
				'category' => 'All Categories',
				'title' => 'Our Latest Blog Posts'
			);
			
			$b = $userbloglist_master->addBlock($ubList, 'Main', $data);
			$b->setCustomTemplate('templates/simple');
			$b = $user_blog_profile_page->addBlock($ubList, 'Main', $data1);
			$b->setCustomTemplate('templates/simple');
			
			$i=0;
			for ($bb = 1; $bb <= 4; $bb+=1) {

				if ($bb == 1) {
					$title = 'Category List';
				} elseif ($bb == 2) {
					$title = 'Tag List';
				} elseif ($bb == 3) {
					$title = 'Tag Cloud';
				} elseif ($bb == 4) {
					$title = 'Archive';
				}

				$data = array('num' => '9999',
					'cParentID' => '0',
					'cThis' => '0',
					'paginate' => '0',
					'displayAliases' => '0',
					'ctID' => $userBlogPostCTID,
					'rss' => '0',
					'rssTitle' => '',
					'rssDescription' => '',
					'truncateSummaries' => '0',
					'truncateChars' => '128',
					'category' => 'All Categories',
					'title' => $title
				);

				$b = $userbloglist_master->addBlock($ubList, 'Sidebar', $data);
				
				$i++;
				if ($i == 1) {
					$b->setCustomTemplate('categories');
				} elseif ($i == 2) {
					$b->setCustomTemplate('tags');
				} elseif ($i == 3) {
					$b->setCustomTemplate('tag_cloud');
				} elseif ($i == 4) {
					$b->setCustomTemplate('archive');
				}
			}
			
			$userBlogList = CollectionType::getByHandle('user_blog_list');
			$user_blog_page = Page::getByPath('/user_blogs');  
			
			if(!is_object($user_blog_page) || $user_blog_page->cID==null){
	    		$userBlogParent = Page::getByID(HOME_CID);    	
	    		$user_blog_page = $userBlogParent->add($userBlogList, array('cName' => 'User Blogs', 'cHandle' => 'user_blogs'),$pkg); 
	    		$user_blog_page->setAttribute('exclude_nav','1');
	    	}
			
			$blocks = $user_blog_page->getBlocks('Main');
			foreach ($blocks as $b) {
				$b->setCustomTemplate('templates/simple');
			}
			
			$blocks = $user_blog_page->getBlocks('Sidebar');
			$i=0;
			foreach ($blocks as $b) {
				$i++;
				if ($i == 1) {
					$b->setCustomTemplate('categories');
				} elseif ($i == 2) {
					$b->setCustomTemplate('tags');
				} elseif ($i == 3) {
					$b->setCustomTemplate('tag_cloud');
				} elseif ($i == 4) {
					$b->setCustomTemplate('archive');
				}
			}
		}
		
		$co = new Config();
		$co->setPackageObject($pkg);
		$user_blog_page_location = Page::getByPath('/user_blogs');
		$ublID = $user_blog_page_location->getCollectionID();
		$co->save("USER_BLOGS_PARENT_PAGE", $ublID);
		$co->save("USER_BLOG_PAGE_PATH_FORMAT", 'username');
		$co->save("USER_BLOG_SHARE_ATTRIBUTE", 'blog_category');
	}  
  
	function load_required_models() {
	    Loader::model('single_page');
	    Loader::model('collection');
	    Loader::model('page');
	    loader::model('block');
	    Loader::model('collection_types');
	    Loader::model('/attribute/categories/collection');
	    Loader::model('/attribute/categories/user');
	  }	

}