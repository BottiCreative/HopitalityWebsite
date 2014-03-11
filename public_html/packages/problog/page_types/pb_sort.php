<?php       defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php       
$html = Loader::helper('html');
$this->addHeaderItem($html->css('page_types/pb_sort.css', 'problog'));
?>  
  
    <div>
        <?php       
          	$a = new Area('Main');
          	$a->setCustomTemplate('pb_blog_sort', 'results/view.php'); 
          	$a->display($c);
        ?>
    </div>