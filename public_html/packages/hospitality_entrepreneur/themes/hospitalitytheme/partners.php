<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>
	
<div class="mainContainer">
		<div class="row topRowPad">
        
		<div class="grid-8 columns mainBody nopadLeft">
        <main role="main">
        
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
        </main>
            
		</div>


		<div class="grid-4 columns">
        
        <aside>
         <?php  
         $a = new GlobalArea('Partners Nav');
         $a->display();
         ?>
         
         <div class="clearfix"></div>
         
         
         <?php  
			$a = new Area('Sidebar');
			$a->display($c);
			?>

         </aside>
        
        
        

		
        </div>	

	</div>
    
    
     <div class="partnerFull">

         
		 <div class="row">
		 <?php  
			$a = new Area('Partners Quote');
			$a->display($c);
			?>
       </div>

		</div>  
        
        <div class="row">
		 <?php  
			$a = new Area('Full Wide');
			$a->display($c);
			?>
       </div>
    
    
    
    
    
    </div>
	
<?php  $this->inc('elements/footer.php'); ?>