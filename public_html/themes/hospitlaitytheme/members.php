<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/members_header.php'); ?>






<div class="row topRowPad">
	
    	<div class="grid-8 columns">
        	<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
        </div>
        
        <div class="grid-4 columns membersNav">
        
        <aside> 
		 <?php  
         $a = new GlobalArea(' Members Sidenav');
         $a->display();
         ?>
         </aside>
         
        </div>
        

</div><!--row-->


<div class="fullwidthtest">
	<div class="row">
    	<div class="grid-8 columns">
        <?php  
			$a = new Area('testimonial');
			$a->display($c);
			?>
            </div>
            
        <div class="grid-4 columns blog">
        	<?php  
			$a = new Area('blog');
			$a->display($c);
			?>
        
        </div>
    </div>
</div>

<div class="row">
	<div class="grid-12 columns partners">
    	<?php  
			$a = new Area('partnersintro');
			$a->display($c);
			?>
        <?php  
			$a = new Area('partnersimages');
			$a->display($c);
			?>
    </div>
</div>


<div class="fullwidthmembers">
	<div class="row members">
    	<div class="grid-12 columns">
        	<?php  
			$a = new Area('packageintro');
			$a->display($c);
			?>

        </div>
    </div>
</div>

<?php  $this->inc('elements/members_footer.php'); ?>