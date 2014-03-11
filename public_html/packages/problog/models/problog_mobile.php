<?php      
Loader::model('blogify','problog');


class MobileBlogList extends Model {

	var $posts;
	var $error_message;
	
	public function __construct(){
		
	}

	
	public function getList( $method='latest' ){
	    Loader::model('collection_types');
		
		$ct = CollectionType::getByHandle('pb_post');
		$ctID = $ct->getCollectionTypeID();
		
		Loader::model('page_list');
		$bl = New PageList();
		
		$bl->setItemsPerPage(8);
		

		switch($method) {
		
			case 'latest':
				$bl->sortByPublicDateDescending();
				break;
				
			case 'draft':
				$bl->includeInactivePages(true);
				$bl->filter('p1.cIsActive', 0);
				$bl->sortByPublicDateDescending();
				break;
		}
		
		$bl->filterByCollectionTypeID($ctID);
		//$bl->debug();
		$this->posts = $bl->get();
		//var_dump($posts);
	
		$posts = $this->posts;
		
		if(is_array($posts)){
		
			$html = '<ul data-role="listview" data-inset="true" id="post_list">';
			
			foreach($posts as $post){
				//get commenting and create unique keys
			    $i++;
			    $comment_count = 0;
			    
			    $comments = MobileBlogList::getCommentsByParentID($post->getCollectionID());
			    if(count($comments)>0){
			    	$comment_count = count($comments);
			    }else{
			    	$comment_count = 0;
			    }
			    
			    //if the first comment in the list belongs to the
			    // logged in user, then that reply is marked as "replied"
			    //and skipped in the list of latest comments.
			    if($comments[0]['uID']==$uID && $method =='comments'){
			    	$blog_posts['replied-'.date('Y/m/d',strtotime($comments[0]['entryDate'])).'-'.$comment_count.'-'.$i] = $post;
			    }else{
			    	$blog_posts[date('Y/m/d',strtotime($comments[0]['entryDate'])).'-'.$comment_count.'-'.$i] = $post;
			    }
			}
		}
	
		if(is_array($blog_posts)){
			if($method =='comments'){
				krsort($blog_posts);
			}
			foreach($blog_posts as $key=>$poster){
				$comment_count = explode('-',$key);
				$name = $poster->getCollectionName();
	
				if(($method =='comments' && $comment_count[1] > 0 && $comment_count[0]!='replied') || $method !='comments'){
				    $html .= '<li class="pb_post" alt="'.$poster->getCollectionID().'"><a href="#" alt="'.$poster->getCollectionID().'" class="ui-li-heading">'.$name;
				    if($method=='comments'){
				    	$html .= '  <span class="ui-li-descs">last comment: ';
				    	$html .= date('M jS',strtotime($comment_count[0]));
				    	$html .= '</span>';
				    }else{
				    	if($_REQUEST['method']!='draft'){
				    		$html .= '  <span class="ui-li-descs"> '.$poster->getCollectionDatePublic('M jS').'</span>';
				    	}
				    }
				    $html .= '</a>';
				    $html .= '<span class="ui-li-count">'.$comment_count[1].'</span>';
				    
				    $html .= '</li>';
				}
			}
			$html .= '</ul>';
		}
		
		return $html;
	}
	
    public function getCommentsByParentID($ID){
		$db = Loader::db();
		$r = $db->EXECUTE("SELECT * FROM btGuestBookEntries WHERE cID = $ID ORDER BY entryDate DESC");
		$comments = array();
		
		while($row=$r->fetchrow()){
			if($row['cID'] == $ID){
				$comments[] = $row;
			}
		}

		return $comments;
	}

}

class MobileBlogPost extends model {
	
	public function __construct(){
		
	}
	
	public function getPage($cID){
	
		$post = Page::getByID($cID);
		$post_name = $post->getCollectionName();
		$blocks = $post->getBlocks();
		foreach($blocks as $b){
			if($b->getBlockTypeHandle()=='content'){
				$controller = $b->getController();
				$post_content = $controller->getContent();
			}
		}
		
		Loader::model('attribute/categories/collection');
		$tag_array = $post->getAttribute('tags');
		if(is_array($tag_array)){
			foreach($tag_array as $tag){
			
				$tags[] = $tag->value;
			}
		}
		
		$thumb = $post->getAttribute('thumbnail');
		if($thumb){
			$fID = $thumb->getFileID();
			$thumbpath = BASE_URL.File::getRelativePathFromID($fID);
		}
		
		$image = $thumbpath;
		
		$comments = MobileBlogList::getCommentsByParentID($cID);

		$html .= '<div data-role="collapsible" id="content_collaps"  data-collapsed="false"> ';
		$html .= '<h3>'.$post_name.'</h3>';
		if(strlen($image) > 7){
			$html .= '<img style="display:block; max-width: 280px;" id="postImage" src="'.$image.'" />';
		}
		//$html .= wordwrap($image, 39,"<br />\n",true);
		$html .= '<div>'.$post_content.'</div>';
		$html .= '</div>';
		$html .= '<div data-role="collapsible" data-inset="true" id="comment_collaps">';
		$html .= '<h3>Comments</h3>';
		$html .= '	<ul class="	ui-listview " data-role="listview" data-inset="true">';
		if(is_array($comments)){
			//rsort($comments);
			for($cc = (count($comments)-5); $cc < count($comments); $cc++){
				$comment = $comments[$cc];
				if($comment['approved']==1){
					$html .= '<li class="ui-li ui-li-static ui-body-c">';
					$html .= '  <p class="ui-li-aside ui-li-desc" style="width: 50px!important;">'.date('M jS',strtotime($comment['entryDate'])).'</p>';
					$html .= '		<h3 class="ui-li-heading" style="margin-bottom: 12px;">'.$comment['user_email'].'</h3>';
					$html .= '	    <p class="ui-li-desc" style="white-space:normal">';	
					$html .= ' '.$comment['commentText'];	
					$html .= '	    </p>';
					$html .= '</li>';
				}
			}
		}
		$html .= '  </ul>';
		$html .= '<a href="#page5" data-role="button" data-icon="back" class="reply_post" socket="'.$cID.'">Reply</a>';
		$html .= '</div>';
		return $html;
	}
	
	public function getPostEdit($cID){

		$post = Page::getByID($cID);
		$post_name = $post->getCollectionName();
		$blocks = $post->getBlocks();
		foreach($blocks as $b){
			if($b->getBlockTypeHandle()=='content'){
				$controller = $b->getController();
				$post_content = $controller->getContent();
			}
		}
		
		Loader::model('attribute/categories/collection');
		$tag_array = $post->getAttribute('tags');
			if(!empty($tag_array)){
			foreach($tag_array as $tag){
				$tags[] = $tag->value;
			}
		}
		
		$thumb = $post->getAttribute('thumbnail');
		if($thumb){
			$fID = $thumb->getFileID();
			$thumbpath = BASE_URL.File::getRelativePathFromID($fID);
		}
		
		$image = $thumbpath;
		
		$data = array(
			'title' => $post_name,
			'image' => $image,
			'content' => $post_content,
			'tags' => $tags
		);
		
		return $data;
		
	}
	
	
	public function postReply($vars,$auth){
	
		$cID = $vars[0];
		$comment = $vars[1];
		
		$comment .= '<br/><br/><i style="font-size: 10px;">Posted via ProBlog Mobile App</i>';
	
		$p = Page::getByID($cID);
		$blocks = $p->getBlocks();
		foreach($blocks as $b){
			if($b->getBlockTypeHandle()=='guestbook'){
				$controller = $b->getController();
				$bID = $b->getBlockID();
			}
		}
		Loader::model('userinfo');
		$uID = $auth['id'];
		$ui = UserInfo::getByID($uID);
		
		$values = array(
			'bID' => $bID,
			'cID' => $cID,
			'uID' => $uID,
			'commentText' => $comment,
			'user_name' => $ui->getUserFirstName().' '.$ui->getUserLastName(),
			'user_email' => $ui->getUserEmail(),
			'entryDate' => date('Y-m-d H:i:s'),
			'approved' => 1
		);
		
		$db = Loader::db();
		$r = $db->EXECUTE("INSERT INTO btGuestBookEntries (bID,cID,uID,commentText,user_name,user_email,entryDate,approved) VALUES (?,?,?,?,?,?,?,?)",$values);
		
		return 'success';
	}
	
	public function removePost($cID){
		$post = Page::getByID($cID);
		$post->delete();
		return 'success';
	}
	
	
	public function postMobilePost($args,$auth){
		$args = json_decode($args);
		//$title,$tags,$comment,$tudes,$cID,$fileName,$draft=null
		$title = $args->title;
		$tags = $args->tags;
		$content = $args->content;
		$tudes = $args->lat.','.$args->lon;
		$fileName = $args->fileName;
		$cID = $args->cID;
		$type = $args->type;
		$twitter = $args->twitter;
		$uID = $auth['id'];
		
		if($cID){
			$p = Page::getByID($cID);			
			$data = array('cName' => $title, 'cDescription' => $comment, 'uID' => $uID);
			$p->update($data);		
		}else{
		
			$date = date('Y-m-d H:i:s');
			
			$blog_settings = Loader::helper('blogify','problog')->getBlogSettings();
			
			$mobilePathID = $blog_settings['mobile_path'];
			$parent = Page::getByID($mobilePathID);
			if(!$parent->cID){
				$parent = Page::getByPath('/mobile');
			}
	
			Loader::model("collection_types");
			$ct = CollectionType::getByHandle('pb_post');				
			$data = array('cName' => $title, 'cDescription' => $content, 'cDatePublic' => $date, 'uID' => $uID);
			$p = $parent->add($ct, $data);
		}
		
		$blocks = $p->getBlocks('Main');
		foreach($blocks as $b) {
			if($b->getBlockTypeHandle()=='content'){
				$b->deleteBlock();
			}
		}
		
		$bt = BlockType::getByHandle('content');
		$data = array('content' => $content);			
		$p->addBlock($bt, 'Main', $data);
		
		
		$block = $p->getBlocks('Main');
		foreach($block as $b) {
			if($b->getBlockTypeHandle()=='content'){
				$b->setCustomTemplate('mobile_post');
				$b->setBlockDisplayOrder('+1');
				$b->setBlockDisplayOrder('+1');
			}
		}
		
		$db = Loader::db();
		$cak = CollectionAttributeKey::getByHandle('tags');
		$akID = $cak->getAttributeKeyID();
		$tag_list = explode(',', $tags);
		foreach($tag_list as $tag){
			$tag = trim($tag);
			$_POST['akID'][$akID]['atSelectNewOption'][] = $tag;
		}
		//$cak->setAttribute($p,$data);
		$cak->saveAttributeForm($p);	
		
		
		$tude_exist = $p->getAttribute('post_location');
		if($tudes != $tude_exist && $tudes != ''){
			$cak = CollectionAttributeKey::getByHandle('post_location');
			$akID = $cak->getAttributeKeyID();
			$cak->setAttribute($p,$tudes);
		}
		
		//save post image
		$thumb = $p->getAttribute('thumbnail');
		if(is_object($thumb)){
			$thumb_name = $thumb->getFileName();
		}

		//android photos have not extension? So dumb!
	    if(substr($fileName,-4,-3) != '.'){
			$fileName = $fileName.'.jpg';
		}
		
		if($thumb_name != $fileName && $fileName != ''){
			Loader::library('file/importer');
			$fi = new FileImporter();
			Loader::model('file_list');
			$fl = new FileList();
			$fl->filterByKeywords($fileName);
			$fls = $fl->get();
			if(is_array($fls)){
				foreach($fls as $f){
					$fID = $f->getFileID();
				}
			}
			if(!$fID){
				$fv = $fi->import(DIR_FILES_UPLOADED_STANDARD.'/incoming/'.$fileName,$fileName);
				$fID = $fv->getFileID();
			}
			
			if($fID){
				$f = File::getByID($fID);
			
				$cak = CollectionAttributeKey::getByHandle('thumbnail');
				$cak->setAttribute($p,$f);
			}
		}
		
		if($type=='draft'){
			$p->deactivate();
		}else{
			$pa = $p->getVersionObject();
			$pa->approve();
			$p->activate();
		}

		if($twitter==1){
			MobileBlogPost::doTweet($p);
		}

		return 'success';	
	}
	
	private function doTweet($p){
		$nh = Loader::helper('navigation');
		$pkg = Package::getByHandle('problog');
		$PB_AUTH_TOKEN = $pkg->config('PB_AUTH_TOKEN');
		$PB_AUTH_SECRET = $pkg->config('PB_AUTH_SECRET');
		$PB_APP_KEY = $pkg->config('PB_APP_KEY');
		$PB_APP_SECRET = $pkg->config('PB_APP_SECRET');
		
		if($PB_AUTH_TOKEN){

			Loader::library('oAuth','problog');
			Loader::library('twitteroauth','problog');
			
			$connection = new TwitterOAuth($PB_APP_KEY,$PB_APP_SECRET,$PB_AUTH_TOKEN,$PB_AUTH_SECRET);

			$msg = t('New Blog Post').' - '.$p->getCollectionName().' : '.BASE_URL.$nh->getLinkToCollection($p);
			$update_status = $connection->post('statuses/update',array('status' => $msg));
			$temp = $update_status->response;
		}
	}

}

