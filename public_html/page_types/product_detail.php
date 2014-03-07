<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
	
			
			
			
		<div class="row topRowPad">
			<div class="grid-12 columns">
            
        <?php  
        	$a = new GlobalArea('Resources Nav');
        	$a->display();
         ?>
            
            
            </div>
		</div>
            
            
            
            <div class="row">
            
            <div class="grid-8 columns">

			
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
            
            </div>
            
            <div class="grid-4 columns">
            
            <div class="login"><a href="/login">login detail</a></div>
            
            
            
         <?php  
         $a = new GlobalArea(' Membership Side');
         $a->display();
         ?>
            
            
            
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
