<?php      
$html = Loader::helper('html');
$this->addHeaderItem($html->css('page_types/pb_post.css', 'problog'));
$blogify = Loader::helper('blogify','problog');
$blog_settings = $blogify->getBlogSettings();
$showComments = $blog_settings['comments'];
?>
	<div id="pb_sidebar">
		<?php       
			$as = new Area('Sidebar');
			$as->display($c);
		?>		
	</div>
    <div id="pb_body">
		<?php       
	      	$a = new Area('FavBar');
	      	$a->display($c);
        ?>
        <?php       
          	$a = new Area('Main');
          	$a->display($c);
        ?>
        <?php       
          	$a = new Area('Blog Post More');
          	$a->display($c);
        ?>
        <div class="ccm-next-previous-wrapper">
        	<br/>
	        <?php        
	      	if($prev_link){
	      		?>
	      		<div class="ccm-next-previous-previouslink">
	      			<?php      echo '<a href="'.$prev_link.'" alt="prev_page">&laquo; '.t('Previous').'</a>';?>
			    </div>
			    <?php     
			}
			if($next_link){
	      		?>
	      		<div class="ccm-next-previous-nextlink">
	      			<?php      echo '<a href="'.$next_link.'" alt="next_page">'.t('Next').' &raquo;</a>';?>
			    </div>
			    <?php     
			}
			?>
			<div class="spacer"></div> 
        </div>
    </div>