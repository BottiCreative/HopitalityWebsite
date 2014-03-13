<?php      
defined('C5_EXECUTE') or die("Access Denied.");
global $c;
$u = new User();
$blogify = Loader::helper('blogify','problog');
$authorID = $blogify->getBlogAuthor($c);
$blog_settings = $blogify->getBlogSettings();
extract($blog_settings);


?>

 <div class="row mainContent topRowPad">
     
     	<div class="grid-8 columns">
        
        
        
       
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
        <div class="ccm-next-previous-wrapper">
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
     
     
	
   
