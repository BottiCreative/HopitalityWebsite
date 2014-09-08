<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<div class="topRowPad"></div>

<div class="row">
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
        	<div class="grid-12 columns">
			<?php  
			$a = new Area('Resource Header');
			$a->display($c);
			?>
            </div>
         	</main>
            
            <div class="grid-7 columns">
			<?php  
			$a = new Area('Top Left');
			$a->display($c);
			?>
            </div>
            
            <div class="grid-5 columns">
			<?php  
			$a = new Area('Top Right');
			$a->display($c);
			?>
            </div>

<div class="clearfix"></div>
            
                        <div class="grid-12 columns">
			<?php  
			$a = new Area('Secondary Header');
			$a->display($c);
			?>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="grid-6 columns videoWrapper">
			<?php  
			$a = new Area('Video Left');
			$a->display($c);
			?>
            </div>
            <div class="grid-6 columns videoWrapper">
			<?php  
			$a = new Area('Video Right');
			$a->display($c);
			?>
            </div>
            
           
           <div class="grid-12 columns">
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
            
            <?php  
			$a = new Area('Main Low');
			$a->display($c);
			?>
            </div>
            
            
            
            
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
