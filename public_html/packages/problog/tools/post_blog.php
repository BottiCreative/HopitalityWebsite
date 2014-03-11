<?php       	
	function action_add() {
		$posting_type = array('problog', 'problog_post', 'ProBlogPost', 'has posted a new Blog Entry %1$p', 1, 2);
		$_POST = $_REQUEST;
		if($_REQUEST['front_side']){
			$error = Loader::helper('validation/error');
			$error = validate($error);	
			if (!$error->has()) {
				
				Loader::model('collection_types');
				$parent = Page::getByID($_REQUEST['cParentID']);
				$date = Loader::helper('form/date_time')->translate('blogDate');
				$canonical = Loader::helper('blogify','problog')->getOrCreateCanonical($date,$parent);
				
				
				$ct = CollectionType::getByID($_REQUEST['ctID']);			
				$title = str_replace("\'","'",$_REQUEST['blogTitle']);
				$title = str_replace('\\','',$title);
				
				$data = array('ctID'=>$_REQUEST['ctID'],'cName' => $title, 'cDescription' => str_replace('\\','',$_REQUEST['blogDescription']), 'cDatePublic' => $date);
				
				if($_REQUEST['blogID']){
					
					$p = Page::getByID($_REQUEST['blogID']);
					
					$old_parent_id = Loader::helper('blogify','problog')->getCanonicalParent($date,$p);
					$olddate = $p->getCollectionDatePublic();
					
					$p->update($data);

					if ($old_parent_id != $canonical->getCollectionID() || $date != $olddate) {
						$p->move($canonical);
					}
				}else{
					$p = $canonical->add($ct, $data);	
				}
				
				$u = new User();
				$tp = PermissionKey::getByHandle('problog_approve');
				
				
				if(($_REQUEST['draft'] == 1 || $_REQUEST['draft'] == 2) || (!$tp->can() && !$u->isSuperUser())){
					$p->deactivate();
					$p->getVersionObject()->deny();
					if($_REQUEST['draft']==2){
						Loader::helper('blog_actions','problog')->send_publish_request($p);
					}
				}else{
					$p->activate();
					$p->getVersionObject()->approve();
				}
				
				saveData($p);
				
				// we try to load the lerteco_wall package and then check if it's available
				Loader::model('package');
				$wall = Package::getByHandle('lerteco_wall');
				if($wall && $wall->isPackageInstalled()){
						Loader::model('attribute/categories/collection');
						$ak = CollectionAttributeKey::getByHandle('blog_author');
						if($_REQUEST['user_pick_'.$ak->akID]>0){
							$uID = $_REQUEST['user_pick_'.$ak->akID];
						}else{
							$u = new User();
							$uID = $u->getUserID();
						}
					    //it's installed. now we call the single method which creates the posting and, if necessary, the posting type
					    $wall->postAndPossiblyRegister($uID, $p->getCollectionID(), $posting_type);
				}
				return 'success';
			}else{
				$errors = $error->getList();
				return $errors;
			}
		}
	}
	
	
	function validate($error) {
		$vt = Loader::helper('validation/strings');
		$vn = Loader::Helper('validation/numbers');
		$dt = Loader::helper("form/date_time");
		//$er = Loader::helper('validation/error');
		
		if (!$vn->integer($_REQUEST['cParentID'])) {
			$error->add(t('You must choose a parent page for this blog entry.'));
		}			
		if (!$vn->integer($_REQUEST['ctID'])) {
			$error->add(t('You must choose a page type for this blog entry.'));
		}			
		
		if (!$vt->notempty($_REQUEST['blogTitle'])) {
			$error->add(t('Title is required'));
		}
		
		Loader::model("attribute/categories/collection");

		
		$akct = CollectionAttributeKey::getByHandle('blog_category');
		$ctKey = $akct->getAttributeKeyID();
		foreach($_REQUEST['akID'] as $key => $value){
			if($key==$ctKey){
				foreach($value as $type => $values){	
					if($type=='atSelectNewOption'){
						foreach($values as $cat => $valued){
							if($valued==''){
								$error->add(t('Categories must have a value'));	
							}
						}
					}
				}
			}
		}
		
		return $error;
	}
	
	
	function saveData($p) {
		$blocks = $p->getBlocks('Main');
		foreach($blocks as $b) {
			if($b->getBlockTypeHandle()=='content'){
				$b->deleteBlock();
			}
		}
		
		$shareWith = $_REQUEST['share_with'];
		if($shareWith){
			if (strlen($shareWith)>0){
				$p->setAttribute('share_with', $shareWith);
			} else {
				$p->setAttribute('share_with', 'all');
			}
		}	

		Loader::model("attribute/categories/collection");
		$cak = CollectionAttributeKey::getByHandle('tags');
		$cak->saveAttributeForm($p);	
		
		$cck = CollectionAttributeKey::getByHandle('meta_title');
		$cck->saveAttributeForm($p);
		
		$cck = CollectionAttributeKey::getByHandle('meta_description');
		$cck->saveAttributeForm($p);
		
		$cck = CollectionAttributeKey::getByHandle('meta_keywords');
		$cck->saveAttributeForm($p);
		
		$cck = CollectionAttributeKey::getByHandle('blog_category');
		$cck->saveAttributeForm($p);
		
		$cnv = CollectionAttributeKey::getByHandle('exclude_nav');
		$cnv->saveAttributeForm($p);
		
		$ct = CollectionAttributeKey::getByHandle('thumbnail');
		$ct->saveAttributeForm($p);
		
		$ca = CollectionAttributeKey::getByHandle('blog_author');
		$ca->saveAttributeForm($p);
		
		$set = AttributeSet::getByHandle('problog_additional_attributes');
		$setAttribs = $set->getAttributeKeys();
		if($setAttribs){
			foreach ($setAttribs as $ak) {
				$aksv = CollectionAttributeKey::getByHandle($ak->akHandle);
				$aksv->saveAttributeForm($p);
			}	
		}
		
		$bt = BlockType::getByHandle('content');
		if(empty($_REQUEST['blogBody'])){
			$content = ' ';
		}else{
			$content = str_replace('\"','"',urldecode($_REQUEST['blogBody']));
			$content = str_replace("\'","'",$content);
		}
		$data = array('content' => $content);		
					
		$b = $p->addBlock($bt, 'Main', $data);
		$b->setCustomTemplate('blog_post');
		$b->setBlockDisplayOrder('+1');
		$b->setBlockDisplayOrder('+1');

		$ba = Loader::helper('blog_actions','problog');
		
		$ba->doScrape($p,$content);
		$ba->doTweet($p,$_REQUEST['twitter_hash']);
		$ba->doSubscription($p);
		
		Loader::library('events');
		Events::fire('on_problog_submit', $p);
		
		$p->reindex();
			
	}
	

	
	print json_encode(action_add());