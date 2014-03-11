<?php      
$html = Loader::helper('html');
$this->addHeaderItem($html->css('page_types/pb_post.css', 'problog'));
?>
<div id="ccm-profile-wrapper">

    <?php       Loader::element('profile/sidebar', array('profile'=> $profile)); ?> 	
	
    <div class="ubp_body" class="ccm-ui">	
		<?php      
		  $a = new Area('main');
		  $a->display($c);
		 ?>
    </div>
	<div class="ccm-spacer"></div>
</div>