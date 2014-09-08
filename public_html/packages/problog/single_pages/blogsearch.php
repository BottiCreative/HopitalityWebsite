<?php       
defined('C5_EXECUTE') or die("Access Denied.");
$html = Loader::helper('html');
$this->addHeaderItem($html->css('page_types/pb_post.css', 'problog'));
?>
	
 <div class="topRowPad"></div>

<div class="grid-8 columns blogPostMain">
        <?php       
          	$a = new Area('Main');
          	$a->display($c);
        ?>
	
</div>

<div class="grid-4 columns blogPostMain">

        <div class="clearfix"></div>
        	
		<?php  
        	$a = new GlobalArea('BlogHeadPromo');
        	$a->display();
         ?>
         
         
        <div class="clearfix"></div>
        	
		<?php  
        	$a = new GlobalArea('Blog Categories');
        	$a->display();
         ?>

        
        	<?php       
			$as = new Area('Sidebar');
			$as->display($c);
		?>	
</div>
   
    