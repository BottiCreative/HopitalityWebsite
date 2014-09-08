<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="clearfix"></div>


<div class="row">
    	<?php  
			$a = new Area('Payment Info');
			$a->display($c);
			?>

</div>


</div>
</div>

<?php   Loader::element('footer_required'); ?>

</body>
</html>



