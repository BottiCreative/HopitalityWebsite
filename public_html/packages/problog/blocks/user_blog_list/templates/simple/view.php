<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

$blogify = Loader::helper('blogify','problog');
$html = Loader::helper('html');
$textHelper = Loader::helper("text"); 
$uh = Loader::helper('concrete/urls');
global $c;
$link = Loader::helper('navigation')->getLinkToCollection($c);
$blog_settings = $blogify->getBlogSettings();
$searchn= Page::getByID($blog_settings['search_path']);
$search= $nh->getLinkToCollection($searchn);
$bt = Blocktype::getByHandle('problog_list');
$uh = Loader::helper('concrete/urls');
$u = new User();
$user = UserInfo::getByID($u->uID);
if($user){
	$manager = $user->getUserBlogEditor();
	$user_blog_page = $user->getUserBlogLocation();
}
$BASE_URL = BASE_URL;
?>
<script type="text/javascript">
	blog_dialog = function() {
		jQuery.fn.dialog.open({
			width: 830,
			height: 500,
			modal: false,
			href: '<?php      echo BASE_URL.DIR_REL?>/index.php/tools/packages/problog/add_post/?return_url=<?php      echo $this->action('view')?>',
			title: '<?php      echo t('Add New Blog')?>',
			onClose: function() {
				$(window.location).attr('href', '<?php      echo $this->action('view')?>');
	      	}	
		});
	}
</script>
<div class="ccm-page-list ccm-ui">
	<?php      
	if($c->getCollectionPath() == '/profile/user_blog'){
		$bp = Page::getByPath('/create_user_blog_post');
		echo '<a href="/index.php?cID='.$bp->cID.'" id="go_post" class="btn info ccm-button-v2-right">Post A Blog Entry</a>';
	}
	
	if (count($cArray) > 0) { ?>
	
	<?php       
	for ($i = 0; $i < count($cArray); $i++ ) {
		$cobj = $cArray[$i]; 
		$title = $cobj->getCollectionName(); 
		$cCount = $blogify->getCommentCount($cobj->getCollectionID());
		$date = $cobj->getCollectionDatePublic();
		$imgHelper = Loader::helper('image'); 
		$imageF = $cobj->getAttribute('thumbnail');
		if (isset($imageF)) { 
    		$image = $imgHelper->getThumbnail($imageF, $blog_settings['thumb_width'],$blog_settings['thumb_height'])->src; 
		} 
		?>
		     <div id='content-sbBlog-wrap'>
		      	<div class="addthis_toolbox addthis_default_style">
					<?php      
					if($blog_settings['tweet']>0){
					?>
						<span class='st_twitter'></span>
					<?php      }
					if($blog_settings['fb_like']==1){
					?>
						<span class='st_facebook'></span>
					
					<?php     
					}
					if($blog_settings['google']==1){
					?>
						<span class='st_plusone'></span>
					<?php     
					}
					?>
				</div>

				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">stLight.options({publisher:'92751c74-6398-47ab-8f1f-4cf39c865f88'});</script>
	  			<div class="content-sbBlog-commentcount"><?php       echo $cCount;?> <?php     echo t('comment')?><?php       if($cCount!=1){echo 's';}?> </div>
	  			<div id='content-sbBlog-contain'>
	  				<div id='content-sbBlog-title'>
			    		<h3 class="ccm-page-list-title"><a href="<?php       echo $nh->getLinkToCollection($cobj)?>"><?php       echo $title?></a></h3>
			    		<div id='content-sbBlog-date'>
			    		<?php       echo date('M d, Y',strtotime($date));  ?>
			    		</div>
					</div>
					<div>
					<?php     
					$ak_g = CollectionAttributeKey::getByHandle('blog_category'); 
					$cat = $cobj->getCollectionAttributeValue($ak_g);
					echo t('Category').': '.$cat;
					?>
					<br/><br/>
					</div>
					<div id='content-sbBlog-post'>
					<?php       
						if($imageF!=''){
							echo '<div class="thumbnail">';
							echo '<img src="'.$image.'"/>';
							echo '</div>';
						}	
					?>
			  		<?php       
			  			$block = $cobj->getBlocks('Main');
						foreach($block as $b) {
							if($b->getBlockTypeHandle()=='content'){
								$content = $b->getInstance()->getContent();
							}
						}
			  			if(!$controller->truncateSummaries){
							echo $content;
						}else{
							echo $textHelper->shorten($content,$controller->truncateChars);
						}
			  		?>
			  		</div>
			  	</div>
			  	<a class="readmore" href="<?php       echo $nh->getLinkToCollection($cobj)?>"><?php     echo t('Read More')?></a>
			  	<div id="tags">
				  	<b><?php     echo t('Tags')?> : </b>
				  	<?php      
				  	$ak_t = CollectionAttributeKey::getByHandle('tags'); 
				  	$tag_list = $cobj->getCollectionAttributeValue($ak_t);
				  	$akc = $ak_t->getController();
					if(method_exists($akc, 'getOptionUsageArray')){
						//$tags == $tag_list->getOptions();
				
							foreach($tag_list as $akct){
								$qs = $akc->field('atSelectOptionID') . '[]=' . $akct->getSelectAttributeOptionID();
								echo '<a href="'.$BASE_URL.$search.'?'.$qs.'">'.$akct->getSelectAttributeOptionValue().'</a>';
									
							}
						
					}
					?>
				</div>
			</div>
			<br class="clearfloat" />
	<?php      		
	} 
	if(!$previewMode && $controller->rss) { 
			$rssUrl = $controller->getRssUrl($b);
			?>
			<div class="rssIcon">
				<?php     echo t('Get this feed')?> &nbsp;<a href="<?php       echo $rssUrl?>" target="_blank"><img src="<?php       echo $uh->getBlockTypeAssetsURL($bt, 'rss.png')?>" width="14" height="14" /></a>
				
			</div>
			<link href="<?php       echo $rssUrl?>" rel="alternate" type="application/rss+xml" title="<?php       echo $controller->rssTitle?>" />
	<?php        
	} 

} 
	
if ($paginate && $num > 0 && is_object($pl)) {
	$pl->displayPaging();
}	
?>
</div>