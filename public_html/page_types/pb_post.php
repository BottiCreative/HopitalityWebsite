<?php      
defined('C5_EXECUTE') or die("Access Denied.");
global $c;
$u = new User();
$blogify = Loader::helper('blogify','problog');
$authorID = $blogify->getBlogAuthor($c);
$blog_settings = $blogify->getBlogSettings();
extract($blog_settings);

?>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



	<div class="grid-8 columns blogPostMain">
        
        
        
       
	    <?php    
		if($u->isLoggedIn() && ($u->uID == $authorID) && ENABLE_USER_PROFILES > 0){
			echo '<a href="'.DIR_REL.'/index.php/profile/problog_editor/'.$c->getCollectionID().'/" rel="edit">'.t('Edit This Post').'</a>';	
		}
		?>
        
        <main role="main">
        <article>
        <?php      
          	$a = new Area('Main');
          	$a->display($c);
        ?>
        </article>
		</main>
        
        <?php      
        if($trackback>0){
          	$a = new Area('Blog Post Trackback');
          	$a->display($c);
        }
        ?>
        <?php      
        if($comments>0){
        	if($disqus){
        		Loader::PackageElement('disqus','problog',array('discus'=>$disqus));
        	}else{
          		$a = new Area('Blog Post More');
          		$a->display($c);
          	}
        }
        ?>
        <div class="ccm-next-previous-wrapper BlogNextPrevNav">
        	<br/>
	        <?php       
	      	if($prev_link){
	      		?>
	      		<div class="ccm-next-previous-previouslink">
	      			<?php     echo '<a href="'.$prev_link.'" alt="prev_page">&laquo; '.t('Previous').'</a>';?>
			    </div>
			    <?php    
			}
			if($next_link){
	      		?>
	      		<div class="ccm-next-previous-nextlink">
	      			<?php     echo '<a href="'.$next_link.'" alt="next_page">'.t('Next').' &raquo;</a>';?>
			    </div>
			    <?php    
			}
			?>
			<div class="spacer"></div> 
    
    </div>
            </div>
        
        
        <div class="grid-4 columns">
        
        <aside>
        		<?php  
			$a = new Area('Sidebar');
			$a->display($c);
			?>
            
        
        
        <div class="fbBox">
        <div class="fb-like-box" data-href="https://www.facebook.com/pages/Hospitality-Entrepreneur/449799375102971?ref=hl" data-width="307" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false">
        </div>
        

        
            <?php  
			$a = new Area('Sidebar Blog Extra');
			$a->display($c);
			?>   
            
            
            
       	</aside>     
        </div>
        
        
        
        
        <div class="row">
        	<div class="grid-12 columns">
            		<?php  
			$a = new Area('Full Content');
			$a->display($c);
			?>
            </div> 
     
     </div>
     
     
	
   
