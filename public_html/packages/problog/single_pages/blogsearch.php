<?php       
defined('C5_EXECUTE') or die("Access Denied.");
$html = Loader::helper('html');
$this->addHeaderItem($html->css('page_types/pb_post.css', 'problog'));
?>
	<div id="pb_sidebar">
		<?php       
			$as = new Area('Sidebar');
			$as->display($c);
		?>		
	</div>
    <div id="pb_body">
        <?php       
          	$a = new Area('Main');
          	$a->display($c);
        ?>
    </div>