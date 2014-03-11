<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
header('Content-type: text/xml');
echo "<" . "?" . "xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<"."?"."xml-stylesheet type=\"text/css\" media=\"screen\" href=\"http://feeds.feedburner.com/~d/styles/itemcontent.css\"?>\n";

	//grab the list page
	$c = Page::getByID($_GET['cID']);
	//last modified
	$lastmodified = $c->getCollectionDateLastModified();
	
	//get this install's blog settings	
	$blogify = Loader::helper('blogify','problog');
	//extract settings to vars
	extract($blogify->getBlogSettings());
	
	//grab all blocks on a page and check
	//for blog list block for RSS feed.
	$blocks = $c->getBlocks();
	foreach($blocks as $bl) {
		if($bl->getBlockTypeHandle()=='problog_list'){
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

		$controller = new ProblogListBlockController($b);
	
			$cArray = $controller->getPages();
			$nh = Loader::helper('navigation');
		
			$feed .= '<rss version="2.0">';
			$feed .= '  <channel>';
			$feed .= '	<title>'.$controller->rssTitle.'</title>';
			$feed .= '	<link>'.BASE_URL.DIR_REL.htmlspecialchars($rssUrl).'</link>';
			$feed .= '	<description>'.$controller->rssDescription.'</description> ';
			$feed .= '	<lastBuildDate>'.date('D, j M Y',strtotime($lastmodified)).'</lastBuildDate>';
			for ($i = 0; $i < count($cArray); $i++ ) {
				$cobj = $cArray[$i]; 
				$title = $cobj->getCollectionName();
				$feed .= '  <item>';
				$feed .= '	  <title>'.htmlspecialchars($title).'</title>';
				$feed .= '	  <link>';
				$feed .= 		BASE_URL.$nh->getLinkToCollection($cobj);		  
				$feed .= '	  </link>';
				
				//are we using the content block?
				if($controller->use_content > 0){
					//grab page area 'Main'
					$block = $cobj->getBlocks('Main');
					//loop through all blocks
					foreach($block as $bi) {
						//find the content block
						if($bi->getBlockTypeHandle()=='content' || $bi->getBlockTypeHandle()=='sb_blog_post'){
							//assign content
							$content = $bi->getInstance()->getContent();
						}
					}
				}else{
					//use collection description
					$content = $cobj->getCollectionDescription();
				}
				//should we page break? 
				if($controller->PageBreak && $breakSyntax){
					//explode to array at page break
					$tempContent = explode($breakSyntax,$content);
					//assign new content var
					$content = $tempContent[0];
				}else{
					//strip page break tag
					$content = str_replace($breakSyntax,'',$content);
				}
				
				//clean up any truncated or broken tags
				$tidy = $blogify->closetags($content);
				// replaces html non-breaking space with an actual space
				$tidy = preg_replace("/\s| /"," ", $tidy);
				// removes other encoded chars
				$tidy = preg_replace("/&#?[a-z0-9]{2,8};/i","", $tidy);
	
				$feed .= '	  <description><![CDATA['.$tidy.']]></description>';
	
	            $tags = preg_split('/\n/', $cobj->getAttribute('tags'));
	            if ($tags) {
					foreach($tags as $tag) {
					  $feed .= "    <category>";
					  $feed .= $tag;
					  $feed .= "    </category>";
					}
				}
	
				//$feed .= '	  <pubDate>'.date( 'D, d M Y H:i:s T',strtotime($cobj->getCollectionDatePublic())).'</pubDate>
				$feed .= '    <pubDate>'.date( DATE_RFC822,strtotime($cobj->getCollectionDatePublic())).'</pubDate>';
				$feed .= '  </item>';
		   	} 
     	$feed .= '	 </channel>';
		$feed .= '</rss>';
			
		echo $feed;
	}
exit;






