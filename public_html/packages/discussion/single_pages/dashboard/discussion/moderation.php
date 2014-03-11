<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Discussion Moderated Posts'), false, false, false);?>
<div class="ccm-pane-body">
<script language="javascript">
var confirm_action = '<?php  echo t('Are you sure?')?>';
</script>
	<form action="<?php  echo $this->action('moderate_posts');?>" id="ccm-discussion-moderation" method="post">
	<div id="ccm-search-results">					
		<?php  Loader::packageElement('moderation/search_results', 'discussion', array('posts' => $posts, 'postList' => $postList, 'pagination' => $pagination)); ?>
	</div>
	</form>	
	<div class="ccm-spacer">&nbsp;</div>		
</div>
<div class="ccm-pane-footer"></div>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>