<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>


		
        
        <div class="row topRowPad">

		<div class="grid-12 columns">
        
        <h1>Resources: <span><?php echo $c->getCollectionName() ?></span></h1>
        
            </div>
		</div>
        
        
        <div class="row">
        <div class="grid-10 columns nopadRight">
                <?php  
        	$a = new GlobalArea('Resources Header');
        	$a->display();
         ?>
        </div>
        <div class="grid-2 columns nopadLeft">
        <a href="<?php echo DIR_REL; ?>/resources/" class="allResources">View All</a>
        </div>
        
        
        </div>
        
        
        
        <div class="row">
        <main>
        	<div class="grid-12 columns nopad">
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
            </div>
            </main>
        </div>
        
    
<div class="clearfix"></div>

         

        
<div class="fullwidthgreen">
	<div class="row Homeform">
		 <?php  
         $a = new GlobalArea(' Membership Full');
         $a->display();
         ?> 
    </div>
</div>        



<div class="clearfix"></div>

        
        
        

        
        
        
        

	
<?php  $this->inc('elements/footer.php'); ?>
