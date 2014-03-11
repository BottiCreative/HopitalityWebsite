<?php        
defined('C5_EXECUTE') or die("Access Denied."); 

$blogify = Loader::helper('blogify','problog');
$html = Loader::helper('html');
$nh = Loader::helper('navigation');
$texthelper = Loader::helper("text"); 
$uh = Loader::helper('concrete/urls');
global $c;
$link = Loader::helper('navigation')->getLinkToCollection($c);
$blog_settings = $blogify->getBlogSettings();
$searchn= Page::getByID($blog_settings['search_path']);
$search= $nh->getLinkToCollection($searchn);
$bt = Blocktype::getByHandle('problog_list');
$uh = Loader::helper('concrete/urls');

if($_REQUEST['akID']){ 
    foreach($_REQUEST['akID'] as $akID => $reqs) {
    	$fak = CollectionAttributeKey::getByID($akID);
		if (is_object($fak)) {
			$type = $fak->getAttributeType();
			$controller = $type->getController();
			$controller->setAttributeKey($fak);
			$items = $controller->getOptions();
			foreach($items as $item) {
				if($item->ID == $reqs['atSelectOptionID']){
					$val = $item->value;
				}
			}
    	}
    }
}
?> 

<?php        if (isset($error)) { ?>
	<?php       echo $error?><br/><br/>
<?php        } ?>

<form action="<?php       echo $this->url( $resultTargetURL )?>" method="get" class="ccm-search-block-form">

	<?php        if( strlen($title)>0){ ?><h3><?php       echo $title?></h3><?php        } ?>
	
	<?php        if(strlen($query)==0){ ?>
	<input name="search_paths[]" type="hidden" value="<?php       echo htmlentities($baseSearchPath, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php        } else if (is_array($_REQUEST['search_paths'])) { 
		foreach($_REQUEST['search_paths'] as $search_path){ ?>
			<input name="search_paths[]" type="hidden" value="<?php       echo htmlentities($search_path, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php         }
	} ?>
	
	<input name="query" type="text" value="<?php       echo $val?>" class="ccm-search-block-text" />
	
	<input name="submit" type="submit" value="<?php       echo $buttonText?>" class="ccm-search-block-submit" />
	<br/>
	<br/>
	<?php        
	$tt = Loader::helper('text');
	if ($do_search) {
		if(count($results)==0){ ?>
			<h4 style="margin-top:32px"><?php       echo t('There were no results found. Please try another keyword or phrase.')?></h4>	
		<?php        }else{ ?>
			<div id="searchResults">
				<?php        foreach($results as $r) {
				$cobj = Page::getByID($r->cID); 
				$title = $cobj->getCollectionName(); 
				$cCount = $blogify->getCommentCount($cobj->getCollectionID());
				$date = $cobj->getCollectionDatePublic();
				$imgHelper = Loader::helper('image'); 
				$imageF = $cobj->getAttribute('thumbnail');
				if (isset($imageF)) { 
		    		$image = $imgHelper->getThumbnail($imageF, $blog_settings['thumb_width'],$blog_settings['thumb_height'])->src; 
				} 
				?>	  	
			     <div class="content-sbBlog-wrap">
			       <div class="content-sbBlog-innerwrap">
			      	<div class="addthis_toolbox addthis_default_style">
					<?php      
					if($tweet){
					?>
					<span  class="st_twitter" st_url="<?php       echo BASE_URL.$nh->getLinkToCollection($cobj)?>" st_title="<?php       echo $title?>"></span>
					<?php      
					}
					if($fb_like){
					?>
					<span  class="st_facebook" st_url="<?php       echo BASE_URL.$nh->getLinkToCollection($cobj)?>" st_title="<?php       echo $title?>"></span>
					<?php      
					}
					if($google){
					?>
					<span  class="st_plusone" st_url="<?php       echo BASE_URL.$nh->getLinkToCollection($cobj)?>" st_title="<?php       echo $title?>"></span>
					<?php      
					}
					?>
					</div>
					<script type="text/javascript">var switchTo5x=true;</script>
					<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
					<?php       if($sharethis){ ?>
					<script type="text/javascript">stLight.options({publisher:'<?php       echo $sharethis;?>'});</script>
					<?php       } ?>
		  			<?php       if($comments){ ?>
		  			<div class="content-sbBlog-commentcount"><?php       echo $comment_count;?></div>
		  			<?php       } ?>
		  			<div id="content-sbBlog-contain">
		  				<div id="content-sbBlog-title">
				    		<h1 class="ccm-page-list-title"><a href="<?php       echo $nh->getLinkToCollection($cobj)?>"><?php       echo $title?></a></h1>
				    		<div id="content-sbBlog-date">
				    		<?php       echo date('M d, Y',strtotime($date));  ?>
				    		</div>
						</div>
						<br class="clearfloat" />
						<div class="categories" >
							<?php      
							$ak_g = CollectionAttributeKey::getByHandle('blog_category'); 
							$cat = $cobj->getCollectionAttributeValue($ak_g);
							echo t('Category').': '.$cat;
							?>
							<br/><br/>
						</div>
						<div id="content-sbBlog-post">
						<?php       
							if($thumb){
								echo '<div class="thumbnail">';
								print '<img src="'.$image.'" alt="mobile_photo" class="mobile_photo"/>';
								echo '</div>';
								print '<br style="clear: both;" />';
							}	
						?>
				  		<?php       
						$currentPageBody = $this->controller->highlightedExtendedMarkup($r->getBodyContent(), $query);?>
							<div class="searchResult">
								<p>
									<?php        echo ($currentPageBody ? $currentPageBody .'<br />' : '')?>
									<?php        echo $this->controller->highlightedMarkup($tt->shortText($r->getDescription()),$query)?>
									<a href="<?php        echo $r->getPath(); ?>" class="pageLink"><?php        echo $this->controller->highlightedMarkup($r->getPath(),$query)?></a>
								</p>
							</div>
				  		</div>
				  	</div>
				  	<br class="clearfloat" />
				  	<a class="readmore" href="<?php       echo $nh->getLinkToCollection($cobj)?>"><?php      echo t('View Post')?></a>
				  	<div class="tags">
				  	<?php      echo t('Tags')?> : 
					<?php       
					$ak_t = CollectionAttributeKey::getByHandle('tags'); 
					$tag_list = $cobj->getCollectionAttributeValue($ak_t);
					$akc = $ak_t->getController();
					//$tags == $tag_list->getOptions();
					if(!empty($tag_list)){
						$x = 0;
						foreach($tag_list as $akct){
							if($x){echo ', ';}
							$qs = $akc->field('atSelectOptionID') . '[]=' . $akct->getSelectAttributeOptionID();
							echo '<a href="'.BASE_URL.$search.'?'.$qs.'">'.$akct->getSelectAttributeOptionValue().'</a>';
							$x++;
								
						}
					}
					?>
	 				</div>
				  </div>
				</div>
				<div class="footer_shadow">
					<div class="shadow_right"></div>
				</div>
				<br class="clearfloat" />
			<?php     
			}
			?>
			</div> 
			<?php       
			if($paginator && strlen($paginator->getPages())>0){ ?>	
			<div class="ccm-pagination">	
				 <span class="ccm-page-left"><?php       echo $paginator->getPrevious()?></span>
				 <?php       echo $paginator->getPages()?>
				 <span class="ccm-page-right"><?php       echo $paginator->getNext()?></span>
			</div>	
			<?php        } ?>
	
		<?php       				
		} //results found
	} 
	?>
</form>