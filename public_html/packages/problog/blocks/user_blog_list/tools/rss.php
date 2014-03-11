<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));

//Permissions Check
//if($_GET['bID']) {
	$c = Page::getByID($_GET['cID']);
		
	//edit survey mode
	//$b = Block::getByID($_GET['bID']);
	
	//grab all blocks on a page and check
	//for RSS feed.
	$blocks = $c->getBlocks();
	foreach($blocks as $bl) {
		if($bl->getBlockTypeHandle()=='user_blog_list'){
			$tb = $bl;
			$bc = $tb->getInstance();
			$show_rss = $bc->rss;
			if($show_rss > 0){
				$b = $bl;
			}
		}
	}
	
	//if we have a valid RSS block
	//loop through and process.
	if($b){
	
		$controller = new UserBlogListBlockController($b);
		
		//$bp = new Permissions($b);
		//if( $bp->canRead() && $controller->rss) {
	
			$cArray = $controller->getPages();
			$nh = Loader::helper('navigation');
	
			header('Content-type: text/xml');
			echo "<" . "?" . "xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	
	
			$feed .= '<rss version="2.0">';
			$feed .= '  <channel>';
			$feed .= '	<title>'.$controller->rssTitle.'</title>';
			$feed .= '	<link>'.BASE_URL.DIR_REL.htmlspecialchars($rssUrl).'</link>';
			$feed .= '	<description>'.$controller->rssDescription.'</description> ';
	 
			for ($i = 0; $i < count($cArray); $i++ ) {
				$cobj = $cArray[$i]; 
				$title = $cobj->getCollectionName();
			$feed .= '	<item>';
			$feed .= '	  <title>'.htmlspecialchars($title).'</title>';
			$feed .= '	  <link>';
			$feed .= 		BASE_URL.$nh->getLinkToCollection($cobj);		  
			$feed .= '	  </link>';
			$feed .= '	  <description>'.htmlspecialchars(strip_tags($cobj->getCollectionDescription())).'....</description>';
	
			$feed .= '	  <pubDate>'.date( 'D, d M Y H:i:s T',strtotime($cobj->getCollectionDatePublic())).'</pubDate>
				</item>';
	   		} 
	     	$feed .= '	 </channel>';
			$feed .= '</rss>';
			
		echo $feed;
	}
exit;






