<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
	
			
<div class="topRowPad"></div>
            
<div class="row topRowProd">
 
 <div class="grid-8 columns productInfo">
            

			<main>
			<?php 
			
			$a = new Area('Product');
			$a->display($c);

			$a = new Area('Main');
			$a->display($c);
			
			?>
            
           <?php  
			$a = new Area('Social Share');
			$a->display($c);
         ?>
            
            
            </main>
            
            

            
            </div>
            
<div class="grid-4 columns">
        <aside>
        
        <div class="fixedSide">
        
                <?php  
         $a = new GlobalArea('Resource Nav');
         $a->display();
         ?>
         
         <div class="clearfix"></div>

         
         <?php  
         $a = new GlobalArea('Side Trial');
         $a->display();
         ?>
         
         
		 <div class="PopularPosts">
         <h4>Latest Resources</h4>
		 <?php  
         $a = new GlobalArea('Popular Posts');
         $a->display();
         ?>
         </div>
         
         <?php  
			$a = new Area('Sidebar Low');
			$a->display($c);
			?>
            
            </div>
         
         </aside>
</div>

            </div>
            
            
         <div class="row">
			<div class="grid-12 columns">
            
        <?php  
        	$a = new GlobalArea('Resources Extra');
        	$a->display();
         ?>
            
            
            </div>
		</div>
