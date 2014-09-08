<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>
	
<div class="mainContainer">
		<div class="rowWide topRowPad">
        
       	<div class="grid-10 columns">
        <h1>Partners: <span><?php echo $c->getCollectionName() ?></span></h1>
        
        </div>
        <div class="grid-2 columns">
         <?php  
         $a = new GlobalArea('Partners Nav');
         $a->display();
         ?>
        
        </div>
        
<div class="cleafix"></div>



<div class="grid-9 columns">
	<div class="grid-4 columns nopadLeft">

		<div class="partnerVideo">
    	<?php  
			$a = new Area('Partners Video');
			$a->display($c);
			?>
         </div>   

	<div class="panel">
		<aside>
			<div class="clearfix"></div>
         
         	
			<?php  
			$a = new Area('Sidebar');
			$a->display($c);
			?>
       
            
            <?php  
			$a = new Area('Partners Low');
			$a->display($c);
			?>
        

         </aside>
	</div>
</div>

<div class="grid-8 columns nopadRight partnersMain">
	<main role="main">
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
        </main>
</div>
	
    <div class="grid-12 columns nopad">       
            <?php  
			$a = new Area('Partners Quote');
			$a->display($c);
			?>
        </div>
        
</div>        
        
<div class="grid-3 columns ">
	<div class="cleafix"></div>
	<div class="partnersSideAd">
           <?php  
			$a = new Area('Partners Add');
			$a->display($c);
			?>
	</div> 
	<div class="panel">
		<?php  
        	$a = new GlobalArea('Members Partners Side');
        	$a->display();
         ?>
	</div>
</div>
        
<div class="partnerFull">
<div class="grid-12 columns ">
		<?php  
			$a = new Area('Full Wide');
			$a->display($c);
		?>
</div>
</div>	
<?php  $this->inc('elements/footer.php'); ?>