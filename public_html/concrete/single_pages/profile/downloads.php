<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>





<h1>Members Resources</h1>

		<div class="grid-6 columns">

			<?php  
			$a = new Area('Downloads LeftTop');
			$a->display($c);
			?>
		</div>
        
        <div class="grid-6 columns">

			<?php  
			$a = new Area('Downloads RightTop');
			$a->display($c);
			?>
		</div>
        
        <div class="clearfix"></div>
        
        <div class="grid-6 columns">

			<?php  
			$a = new Area('Downloads LeftBottom');
			$a->display($c);
			?>
		</div>
        
        <div class="grid-6 columns">

			<?php  
			$a = new Area('Downloads RightBottom');
			$a->display($c);
			?>
		</div>