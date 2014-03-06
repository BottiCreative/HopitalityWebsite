<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));
extract($blog_settings);
global $c;
if (count($cArray) > 0) { ?>
	<div class="ccm-page-list">
	
	<?php      
	for ($i = 0; $i < count($cArray); $i++ ) {
		$cobj = $cArray[$i]; 
		
		extract($blogify->getBlogVars($cobj));
		
		$content = $controller->getContent($cobj,$blog_settings);
		?>
		     <div class="grid-12 columns content-sbBlog-wrap nopad">
             

	  			<div class="content-sbBlog-contain">
                
                <div class="grid-3 columns content-sbBlog-date nopadLeft">
			    	<?php      echo date('M d, Y',strtotime($blogDate));  ?>
			    </div>
				<div class="grid-5 columns content-category">
			    	<?php     
					echo t('Category').': '.'<a href="'.BASE_URL.$search.'categories/'.str_replace(' ','_',$cat).'/">'.$cat.'</a>';;
					?>
                    </div>
                    <div class="grid-4 columns content-category">
                    
                 <?php      if($comments){ ?>
	  			<?php      echo $comment_count;?>
	  			<?php      } ?>
                    
                    
			    		</div>
                
                
                	<div class="grid-3 columns nopadLeft">
					<?php      
						if($thumb){
							echo '<div class="thumbnail">';
							echo '<img src="'.$image.'"/>';
							echo '</div>';
						}	
					?>
                    </div>
                    
              
              <div class="grid-9 columns nopadLeft">
              <h3 class="ccm-page-list-title"><a href="<?php      echo $url;?>"><?php      echo $blogTitle?></a></h3>
              	<?php      
			  			echo $blogify->closetags($content);
			  		?>
                    
                    <a class="readmore" href="<?php      echo $url?>"><?php     echo t('Read More')?></a>
                    
              
              </div>
                
                
		
        </div>
			  	
            
            
           
            
            
            
			</div>
			<br class="clearfloat" />
	<?php      		
	} 
	$u = new User();
	$subscribed = $c->getAttribute('subscription');
	if($subscribe && $u->isLoggedIn()){
		if($subscribed && in_array($u->getUserID(),$subscribed)){
			$subscribed_status = true;
		}
		?>
		<div id="subscribe_to_blog" class="ccm-ui">
			<a href="<?php     echo $subscribe_link; ?>?blog=<?php     echo $c->getCollectionID(); ?>&user=<?php     echo $u->getUserID(); ?>" onClick="javascript:;" class="subscribe_to_blog btn btn-mini" data-status="<?php     if($subscribed_status){ echo 'unsubscribe';}else{ echo 'subscribed';}?>"> <?php     if($subscribed_status){echo t('Unsubscribe from this Blog'); }else{ echo t('Subscribe to this Blog'); }?> </a>
		</div>
		<?php    
	}
	if(!$previewMode && $controller->rss) { 
			$rssUrl = $controller->getRssUrl($b);
			?>
			<div class="rssIcon">
				<?php     echo t('Get this feed')?> &nbsp;<a href="<?php      echo $rssUrl?>" target="_blank"><img src="<?php     echo $uh->getBlockTypeAssetsURL($bt, 'images/rss.png')?>" width="14" height="14" /></a>
			</div>
			<link href="<?php      echo $rssUrl?>" rel="alternate" type="application/rss+xml" title="<?php      echo $controller->rssTitle?>" />
	<?php      
	} 
	?>
</div>
<?php      } 
	
	if ($paginate && $num > 0 && is_object($pl)) {
		$pl->displayPaging();
	}
	
?>
<script type="text/javascript">
/*<![CDATA[*/
	$(document).ready(function(){
		prettyPrint();
		$('.subscribe_to_blog').live('click tap',function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			$.ajax(url,{
				error: function(r) {
					console.log(r);
				},
				success: function(r) {
					console.log(r);
					if($('.subscribe_to_blog').attr('data-status') == 'subscribed'){
						$('.subscribe_to_blog').html('<?php     echo t('Unsubscribe from this Blog'); ?>');
						$('.subscribe_to_blog').attr('data-status','unsubscribe');
					}else{
						$('.subscribe_to_blog').html('<?php     echo t('Subscribe to this Blog'); ?>');
						$('.subscribe_to_blog').attr('data-status','subscribed');
					}
				}
			});
		});
	});
/*]]>*/
</script>