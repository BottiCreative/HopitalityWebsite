<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>
	

		<div class="rowWide topRowPad">
        
        <main>
        
            <div class="grid-9 columns">
            
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
			
<div class="clearfix"></div>
        
        <div class="grid-6 columns nopadLeft">        	
			<?php  
			$a = new Area('TestVid Left');
			$a->display($c);
			?>        
        </div>       
        <div class="grid-6 columns nopadRight">
        	<?php  
			$a = new Area('TestVid Right');
			$a->display($c);
			?>
        </div>        
        <div class="clearfix"></div>
			<?php  
			$a = new Area('Main Low');
			$a->display($c);
			?>      
        </div>
</main>

<div class="grid-3 columns">
	<div class="panel sideMembersNav">
        <?php  
        	$a = new GlobalArea('Resources Side Nav');
        	$a->display();
         ?>
	</div>
    
    <div class="MembersideAds">
        <?php  
        	$a = new GlobalArea('Resources Side Ads');
        	$a->display();
         ?>
    </div>
    
    
	<div class="panel">
            
         <?php  
        	$a = new GlobalArea('Members Partners Side');
        	$a->display();
         ?>
	</div>
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