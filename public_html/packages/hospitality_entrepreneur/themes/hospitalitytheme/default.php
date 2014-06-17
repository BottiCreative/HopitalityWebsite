<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>
	

		<div class="row topRowPad">
        
        <main>
        	<div class="grid-8 columns">
            
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
			</div>
</main>

		<div class="grid-4 columns">
			<?php  
			$a = new Area('Sidebar');
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
        
        
        
        
        
        <div class="row">
           	<div class="grid-6 columns">
			<?php  
			$a = new Area('Partners Left');
			$a->display($c);
			?>
			</div>
            	<div class="grid-6 columns">
			<?php  
			$a = new Area('Partners Right');
			$a->display($c);
			?>
			</div>
            
            <div class="grid-12 columns">
			<?php  
			$a = new Area('Bottom Full');
			$a->display($c);
			?>
			</div>
            
            
        
	</div>

	
<?php  $this->inc('elements/footer.php'); ?>