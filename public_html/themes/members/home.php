<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>






<script type="text/javascript">
<!--
window.location = "http://hospitalityentrepreneur.com/profile"
//-->
</script>


<div class="rowWide">
	
    	<div class="grid-12 columns">
        	<?php  
			$a = new Area('homeintro');
			$a->display($c);
			?>
        </div>

</div><!--row-->


<div class="fullwidthtest">
	<div class="rowWide">
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

<div class="rowWide">
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
	<div class="rowWide members">
    	<div class="grid-12 columns">
     
            <div class="row">
            
            <div class="grid-12 columns membersbox">

                        	<?php  
			$a = new Area('Package Info');
			$a->display($c);
			?>

     
                </div>
            </div>
        </div>
    </div>
</div>


<div class="rowWide members">
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



<?php  $this->inc('elements/footer.php'); ?>