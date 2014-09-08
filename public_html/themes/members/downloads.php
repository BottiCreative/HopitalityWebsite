<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>
	

<div class="rowWide" >       
	<div class="grid-12 columns sectionNav">
            
        <h1><span><?php echo $c->getCollectionName() ?></span></h1>  

	</div>
</div>



<div class="rowWide">
	<main>
		<div class="grid-9 columns">
		<?php  
			$a = new Area('Bottom Full');
			$a->display($c);
			?>
	</div>
</main>
	<div class="grid-3 columns">
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
        
        
        
        
        
        <div class="rowWide">
           	<div class="grid-6 columns">
			<?php  
			$a = new Area('Downloads Left');
			$a->display($c);
			?>
			</div>
            	<div class="grid-6 columns">
			<?php  
			$a = new Area('Downloads Right');
			$a->display($c);
			?>
			</div>
            
            <div class="grid-12 columns">
	
			</div>
            
            
        
	</div>

	
<?php  $this->inc('elements/footer.php'); ?>