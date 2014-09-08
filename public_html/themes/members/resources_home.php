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
        	<div class="grid-9 columns">
            
            
           <?php  
			$a = new Area('Main');
			$a->display($c);
			?>

            
            <?php  
			$a = new Area('Main Low');
			$a->display($c);
			?>

            </div>
            
            
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
			
			<div class="panel sideMembersNav"> 
         <?php  
        	$a = new GlobalArea('Members Partners Side');
        	$a->display();
         ?>
            
            
            </div>
            </div>
            
            
            
            
        </div>
        
        
        

        
        
        
        

	
<?php  $this->inc('elements/footer.php'); ?>
