<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>



<div class="mainContainer">
<div class="fullwidthheader">
	<div class="rowWide header">
    <div class="grid-12 columns nopad">

    	<?php  
			$a = new Area('HomeSlider');
			$a->display($c);
			?>

    </div>
    </div>
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
    	<div class="grid-7 columns testimonial">
        <?php  
			$a = new Area('testimonial');
			$a->display($c);
			?>
            </div>
            
        <div class="grid-5 columns blog">
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

                     	<?php  
			$a = new Area('Full Wide');
			$a->display($c);
			?>

</div>



<div class="row members">
    	<div class="grid-4 columns">
        Test 1
        </div>
            	<div class="grid-4 columns">
        Test 1
        </div>
            	<div class="grid-4 columns">
        Test 1
        </div>
        </div>
</div>


<?php  $this->inc('elements/footer.php'); ?>