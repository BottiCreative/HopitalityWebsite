<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 

$this->inc('elements/header.php');

?>
			
            
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
            
            <div class="grid-8 columns resourceContent">
			
			<?php 
			
			$a = new Area('Product');
			$a->display($c);

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
            
            </div>
            
            <div class="clearfix"></div>
            
<?php  $this->inc('elements/members_footer.php'); ?>            
