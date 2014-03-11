<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>
	
<div class="mainContainer">
		<div class="row topRowPad">
        
        	<div class="grid-8 columns">
			<?php  
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
        
          <div class="grid-12 columns partnerFull">

                     	<?php  
			$a = new Area('Full Wide');
			$a->display($c);
			?>

		</div>     
        
	</div>
    </div>
	
<?php  $this->inc('elements/footer.php'); ?>