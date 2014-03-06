<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>


		
        
        <div class="row">
			<div class="grid-12 columns">
            
        <?php  
        	$a = new GlobalArea('Resources Nav');
        	$a->display();
         ?>

            </div>
		</div>
        
        
        
        <div class="row">
        	<div class="grid-12 columns">
			<?php  
			$a = new Area('Main');
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
        

        
        
        
        

	
<?php  $this->inc('elements/footer.php'); ?>
