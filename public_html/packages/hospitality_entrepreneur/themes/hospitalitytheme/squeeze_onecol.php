<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/squeeze_header.php'); ?>



        
        <div class="row topRowPad">
		</div>
        
        
        
        <div class="rowNarrow squeezeForm">
        	<div class="grid-12 columns centered">
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
            </div>
            <div class="grid-12 columns buttonHolder">
			<?php  
			$a = new Area('ProductButton');
			$a->display($c);
			?>
            </div>
            
            
        </div>
        


        
        
        
        

	
<?php  $this->inc('elements/squeeze_footer.php'); ?>
