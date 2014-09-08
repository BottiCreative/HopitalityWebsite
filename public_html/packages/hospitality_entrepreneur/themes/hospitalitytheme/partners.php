<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>
	

<div class="topRowPad"></div>

<div class="mainContainer">
		<div class="row">
        
		<div class="grid-8 columns mainBody">
        <main role="main">
        
         <h1>Partners: <span><?php echo $c->getCollectionName() ?></span></h1>
        
        <div class="PartnerVideo">
		<?php  
			$a = new Area('Partners Video');
			$a->display($c);
			?>
        </div>
        
        
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
            
           <div class="partnersSideAd">
           <?php  
			$a = new Area('Partners Add');
			$a->display($c);
			?>
            </div> 
            
            <?php  
			$a = new Area('Partners Low');
			$a->display($c);
			?>
            
            
            

         </aside>
        
        
        

		
        </div>	

	</div>
    
    
     <div class="partnerFull">

        
		 <div class="row">
         	<div class="grid-12 columns"> 
		 <?php  
			$a = new Area('Partners Quote');
			$a->display($c);
			?>
       	</div>
       </div>

		</div>  
        
        <div class="row">
        <div class="grid-12 columns"> 
		 <?php  
			$a = new Area('Full Wide');
			$a->display($c);
			?>
            </div>
       </div>
    
    
    
    
    
    </div>
	
<?php  $this->inc('elements/footer.php'); ?>