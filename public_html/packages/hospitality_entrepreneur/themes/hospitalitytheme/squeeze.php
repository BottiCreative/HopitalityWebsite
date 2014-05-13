<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/squeeze_header.php'); ?>


		<div class="mainContainer">
        
        <div class="row topRowPad">
	
        	<div class="grid-8 columns">
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
            </div>
            
              	<div class="grid-4 columns">
			<?php  
			$a = new Area('Sidebar');
			$a->display($c);
			?>
            </div>
    
        
   <div class="fullwidthmembers">

                     	<?php  
			$a = new Area('Full Wide');
			$a->display($c);
			?>

</div>     
       </div> 

        
        
        
        

	
<?php  $this->inc('elements/squeeze_footer.php'); ?>
