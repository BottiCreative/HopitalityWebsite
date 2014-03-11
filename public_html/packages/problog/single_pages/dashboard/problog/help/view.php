<?php       defined('C5_EXECUTE') or die("Access Denied."); ?>
<style type="text/css">
	.support_frame{width: 100%!important; min-height: 600px!important; border: none!important;}
</style>
	<?php      echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Help'), false, false, false);?>
	<div class="ccm-pane-body">
		<h2><?php       echo t('Get Help')?></h2>
		<p><?php       echo t('ProBlog is working to improve the help and roadmap pages found on Concrete5.org.</p>
		<p>Please head over to <a href="http://www.concrete5.org/marketplace/addons/problog/documentation/" target="_blank">http://www.concrete5.org/marketplace/addons/problog/documentation/</a> for updated help and roadmaps.')?></p>
		
		<h2><?php       echo t('Get Support')?></h2>
		<p><?php       echo t('You can also report bugs and search previously posted bugs & solutions here: <a href="http://www.concrete5.org/marketplace/addons/problog/support/" target="_blank">http://www.concrete5.org/marketplace/addons/problog/support/</a>')?></p>

	</div>
    <div class="ccm-pane-footer">

    </div>