<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
$this->inc('elements/header.php');
?>
<div class="rowWide" >
		<div class="grid-10 columns sectionNav">           
            <h1>Resources: <span><?php echo $c->getCollectionName() ?></span></h1>          
        <?php  
        	$a = new GlobalArea('Resources Header');
        	$a->display();
         ?>
</div>    
<div class="grid-2 columns">          
         <?php  
         $a = new GlobalArea('Resource Nav');
         $a->display();
         ?>
</div>
</div>          
<div class="rowWide">
	<div class="grid-9 columns resourceContent">			
			<?php 			
			$a = new Area('Product');
			$a->display($c);

			$a = new Area('Main');
			$a->display($c);			
			?>
	</div>
	<div class="grid-3 columns">            
            <?php  
			$a = new Area('Sidebar');
			$a->display($c);
			?>                        
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
<div class="clearfix"></div>            
<?php  $this->inc('elements/members_footer.php'); ?>            