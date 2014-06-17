<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<main>

<div class="homeHeader">

<div class="row">
	<div class="grid-8 columns">
        	<?php  
			$a = new Area('Home Vid');
			$a->display($c);
			?>

	</div>
	<div class="grid-4 columns homeText">
        	<?php  
			$a = new Area('Home Text');
			$a->display($c);
			?>

	</div>
</div><!--row-->

</div>



<div class="fullwidthform">
	<div class="row Homeform">

    	<?php  
			$a = new Area('wideform');
			$a->display($c);
			?>
    </div>
</div>

<div class="row">
	
    	<div class="grid-12 columns">
        	<?php  
			$a = new Area('homeintro');
			$a->display($c);
			?>
        </div>

</div><!--row-->




<div class="fullwidthtest">
	<div class="row">
      <div class="grid-12 columns">
        	<?php  
			$a = new Area('Content Title');
			$a->display($c);
			?>
        
        </div>
    
      <div class="grid-7 columns blog">
        	<?php  
			$a = new Area('blog');
			$a->display($c);
			?>
        
        </div>
        
          <div class="grid-5 columns videoContent">
        	<?php  
			$a = new Area('video');
			$a->display($c);
			?>
        
        </div>
    
    	<div class="grid-12 columns testimonial">
        <?php  
			$a = new Area('testimonial');
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

<div class="fullwidthgreen">
	<div class="row Homeform">
  
    	<?php  
			$a = new Area('Giveaway');
			$a->display($c);
			?>
    </div>
</div>



<div class="clearfix"></div>


</main>



<?php  $this->inc('elements/footer.php'); ?>