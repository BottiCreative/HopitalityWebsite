<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>




        
       
     <div class="rowWide" >
      
      <div class="grid-12 columns">
      
        <?php  
        	$a = new GlobalArea('Members Top Nav');
        	$a->display();
         ?>
      
      </div>

      
      </div>
        
     <div class="rowWide membersAreaWrapper">
     
     
        	<div class="grid-12 columns">
			<?php  print $innerContent; ?>
            

		</div>






	
	<!-- end full width content area -->
	
<?php  $this->inc('elements/footer.php'); ?>
