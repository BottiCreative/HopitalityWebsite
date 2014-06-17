<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>


		
       <div class="rowWide" >
        
        
			<div class="grid-12 columns sectionNav">
            
            <h1>Resources: <span><?php echo $c->getCollectionName() ?></span></h1>
            
        <?php  
        	$a = new GlobalArea('Resources Header');
        	$a->display();
         ?>
            
            
            </div>
            </div>
	
        
        
        
        <div class="rowWide">
        	<div class="grid-12 columns">
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
            </div>
        </div>
        
        
        

        
        
        
        

	
<?php  $this->inc('elements/footer.php'); ?>
