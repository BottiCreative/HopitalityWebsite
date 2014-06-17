<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 

$this->inc('elements/header.php');

?>
			<div class="row">
            
            <div class="grid-12 columns">
			
			<?php 
			
			$a = new Area('Product');
			$a->display($c);

			$a = new Area('Main');
			$a->display($c);
			
			?>
            
            </div>
            
            </div>
            
<?php  $this->inc('elements/members_footer.php'); ?>            
