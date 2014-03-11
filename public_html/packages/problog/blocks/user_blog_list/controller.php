<?php       

	defined('C5_EXECUTE') or die(_("Access Denied."));
	class UserBlogListBlockController extends BlockController {

		protected $btTable = 'btUserBlogList';
		protected $btInterfaceWidth = "500";
		protected $btInterfaceHeight = "350";
		
		protected $btCacheBlockRecord = true;
		protected $btCacheBlockOutput = true;
		
		/** 
		 * Used for localization. If we want to localize the name/description we have to include this
		 */
		public function getBlockTypeDescription() {
			return t("List User Blog Items filtered by department.");
		}
		
		public function getBlockTypeName() {
			return t("User Blog List");
		}
		
		public function getJavaScriptStrings() {
			return array(
				'feed-name' => t('Please give your RSS Feed a name.')
			);
		}
		
		function getPages($query = null) {
			global $c;
			Loader::model('page_list');
			$db = Loader::db();
			$bID = $this->bID;
			if ($this->bID) {
				$q = "select * from btUserBlogList where bID = '$bID'";
				$r = $db->query($q);
				if ($r) {
					$row = $r->fetchRow();
				}
			} else {
				$row['num'] = $this->num;
				$row['cParentID'] = $this->cParentID;
				$row['cThis'] = $this->cThis;
				$row['orderBy'] = $this->orderBy;
				$row['ctID'] = $this->ctID;
				$row['rss'] = $this->rss;
				$row['category'] = $this->category;
				$row['title'] = $this->title;
			}
			
			$co = new Config;
			$pkg = Package::getByHandle('problog');
			$co->setPackageObject($pkg);
			$problog_root = Page::getByID($co->get("USER_BLOGS_PARENT_PAGE"));
			
			$pl = new PageList();
			$pl->setNameSpace('b' . $this->bID);
			$u = new User();
			
			$c = Page::getCurrentPage();
			if (is_object($c)) {
				$this->cID = $c->getCollectionID();
			}
			
			$parentParentID = $c->getCollectionParentIDFromChildID($c->getCollectionParentID());
			
			if ($c->getCollectionParentID() != $problog_root->cID && $parentParentID != $problog_root->cID && $c->getCollectionPath() != '/profile/user_blog'){
				$pl->filter(false,"(ak_share_with NOT LIKE '%me%')");
			}
			
			$cArray = array();

			switch($row['orderBy']) {
				case 'display_asc':
					$pl->sortByDisplayOrder();
					break;
				case 'display_desc':
					$pl->sortByDisplayOrderDescending();
					break;
				case 'chrono_asc':
					$pl->sortByPublicDate();
					break;
				case 'alpha_asc':
					$pl->sortByName();
					break;
				case 'alpha_desc':
					$pl->sortByNameDescending();
					break;
				default:
					$pl->sortByPublicDateDescending();
					break;
			}

			$num = (int) $row['num'];
			
			if ($num > 0) {
				$pl->setItemsPerPage($num);
			}

			$cParentID = ($row['cThis']) ? $this->cID : $row['cParentID'];
			
			
			$pl->filterByPublicDate(date('Y-m-d H:i:s'),'<=');
			
			if (!$row['displayAliases']) {
				$pl->filterByIsAlias(0);
			}
			$pl->filter('cvName', '', '!=');			
		
			if ($row['ctID']) {
				$pl->filterByCollectionTypeID($row['ctID']);
			}else{
				Loader::model('collection_types');
				$ct1 = CollectionType::getByHandle('pb_post');
				$ct2 = CollectionType::getByHandle('user_blog_post');
				$ctID1 = $ct1->ctID;
				$ctID2 = $ct2->ctID;
				$pl->filter(false,"(pt.ctID = $ctID1 OR pt.ctID = $ctID2)");
			}
			
			
			Loader::model('attribute/categories/collection');
			$columns = $db->MetaColumns(CollectionAttributeKey::getIndexedSearchTable());
			if (isset($columns['AK_EXCLUDE_PAGE_LIST'])) {
				$pl->filter(false, '(ak_exclude_page_list = 0 or ak_exclude_page_list is null)');
			}
			
			
			if($c->getCollectionPath() == '/profile/user_blog'){
				$u = new User();
				$user = UserInfo::getByID($u->uID);
				if($user){
					$user_blog_page = $user->getUserBlogLocation();
				}
				$pl->filterByParentID($user_blog_page);
				$this->set('pp',Page::getByID($user_blog_page));
			}elseif ( intval($cParentID) != 0) {
				$pl->filterByParentID($cParentID);
				$this->set('pp',$cParentID);
			}
			
			
			if ($this->category != 'All Categories') {
				$selected_cat = explode(', ',$this->category);
				$category_filter = '(';
				foreach($selected_cat as $cat){
					if($fi){$category_filter .= ' OR ';}
					$category_filter .= "ak_blog_category = '\n$cat\n'";
					$fi++;
				}
				$category_filter .= ')';
				$pl->filter(false,$category_filter);
				//$pl->filterByBlogCategory($category_filter);
			}else{
				if($c->getCollectionParentID() != $problog_root->cID && $parentParentID != $problog_root->cID && $c->getCollectionPath() != '/profile/user_blog'){
					$pl->filter(false,"(ak_share_with NOT LIKE '%selected%')");
				}
			}
			
			//$pl->debug();
			
			if ($num > 0) {
				$pages = $pl->getPage();
			} else {
				$pages = $pl->get();
			}
			$this->set('pl', $pl);
			
			return $pages;
		}
		
		
		public function updateParentID($cID){
			$db = Loader::db();
			$q = "update btUserBlogList set cParentID = ?, cThis = 0 where bID = ?";
			$b = $this->getBlockObject();
			$bID=$b->getBlockID();
			$v = array($cID, $bID);
			$res = $db->query($q, $v);
		}
		
		public function view() {
			$cArray = array();
			
			$b = Block::getByID($this->bID);
			$template = strtolower($b->getBlockFilename());
			if(
				substr_count($template,'categories') == 0 && 
				substr_count($template,'tag') == 0 
			){
				$cArray = $this->getPages();
			}
			$blogify = Loader::helper('blogify','problog');
			$blog_settings = $blogify->getBlogSettings();
			$this->set('blog_settings',$blog_settings);
			$searchn= Page::getByID($blog_settings['search_path']);
			$this->set('search',Loader::helper('navigation')->getLinkToCollection($searchn));
			$nh = Loader::helper('navigation');
			$this->set('nh', $nh);
			//$this->set('cArray', $cArray);
			$this->set('cArray', $cArray);
		}
		
		public function add() {
			Loader::model("collection_types");
			$c = Page::getCurrentPage();
			$uh = Loader::helper('concrete/urls');
			//	echo $rssUrl;
			$this->set('c', $c);
			$this->set('uh', $uh);
			$this->set('bt', BlockType::getByHandle('user_blog_list'));
			$this->set('displayAliases', true);
		}
	
		public function edit() {
			$b = $this->getBlockObject();
			$bCID = $b->getBlockCollectionID();
			$bID=$b->getBlockID();
			$this->set('bID', $bID);
			$c = Page::getCurrentPage();
			if ($c->getCollectionID() != $this->cParentID && (!$this->cThis) && ($this->cParentID != 0)) { 
				$isOtherPage = true;
				$this->set('isOtherPage', true);
			}
			$uh = Loader::helper('concrete/urls');
			$this->set('uh', $uh);
			$this->set('bt', BlockType::getByHandle('user_blog_list'));
		}
		
		
		function deletethis($cIDd,$name) {
			$c= Page::getByID($cIDd);
			$c->delete();
			$this->set('message', t('"'.$name.'" has been deleted')); 
			$this->view();
		}
		
		function save($args) {
			// If we've gotten to the process() function for this class, we assume that we're in
			// the clear, as far as permissions are concerned (since we check permissions at several
			// points within the dispatcher)
			$db = Loader::db();

			$bID = $this->bID;
			$c = $this->getCollectionObject();
			if (is_object($c)) {
				$this->cID = $c->getCollectionID();
			}
			
			if(!$args['category'] || !is_array($args['category'])){ $args['category']=array();}
			
			if(!in_array('All Categories', $args['category']) && !empty($args['category'])){
				if(count($args['category'])>1){
					$blogCat = implode(', ',$args['category']);
				}else{
					$blogCat = $args['category'][0];
				}
			}else{
				$blogCat = 'All Categories';
			}
			
			$args['num'] = ($args['num'] > 0) ? $args['num'] : 0;
			$args['cThis'] = (intval($args['cThis'])>0) ? '1' : '0';
			$args['ctID'] = $args['ctID'];
			$args['cParentID'] = ($args['cParentID'] == 'OTHER') ? $args['cParentIDValue'] : $args['cParentID'];
			$args['truncateSummaries'] = ($args['truncateSummaries']) ? '1' : '0';
			$args['displayFeaturedOnly'] = ($args['displayFeaturedOnly']) ? '1' : '0';
			$args['displayAliases'] = ($args['displayAliases']) ? '1' : '0';
			$args['truncateChars'] = intval($args['truncateChars']); 
			$args['paginate'] = intval($args['paginate']); 
			$args['category'] = $blogCat;
			$args['title'] = isset($args['title']) ? $args['title'] : '';

			parent::save($args);
		
		}
		
		function getBlockPath($path){
			$db = Loader::db();
			$r = $db->Execute("SELECT cPath FROM PagePaths WHERE cID = '$path' ");
			while ($row = $r->FetchRow()) {
				$pIDp = $row['cPath'];
				return $pIDp ;
			}
		}

		public function getRssUrl($b=null){
			$uh = Loader::helper('concrete/urls');
			$b = Block::getByID($this->bID);
			$btID = $b->getBlockTypeID();
			$bt = BlockType::getByID($btID);
			global $c;			
			$rssUrl = $uh->getBlockTypeToolsURL($bt)."/rss?cID=".$c->getCollectionID();
			return $rssUrl;
		}
	}

?>