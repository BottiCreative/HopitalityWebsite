<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
	
$isUserPage = ($byUserID>0?1:0);
$isOtherPage = ($cParentID>0 && !$byUserID?1:0);
$cThis = 1;
$c = Page::getCurrentPage();
$form = Loader::helper('form');
?>
<div class="form-stacked">
<fieldset>
    <div class="clearfix">
		<label><?php  echo t('Display Discussions')?></label>
			<ul class="inputs-list">
				<li>
					<label><input type="radio" name="cThis" id="cThisPageField" value="1" <?php  if ($c->getCollectionID() == $cParentID || $cThis) { ?> checked<?php  } ?> />
					<span><?php  echo t('Located beneath this page.')?></span></label>
				</li>
				<li>
					<label><input type="radio" name="cThis" id="cOtherField" value="0" <?php  if ($isOtherPage) { ?> checked<?php  } ?> />
					<span><?php  echo t('Located beneath another page.')?></span></label>
					<div id="ccm-discussion-selected-page-wrapper" style=" <?php  if (!$isOtherPage) { ?>display: none;<?php  } ?> padding: 8px 0px 8px 24px">
					<?php  
					if ($isOtherPage) {
						print Loader::helper('form/page_selector')->selectPage('cParentIDValue', $cParentID);
					} else {
						print Loader::helper('form/page_selector')->selectPage('cParentIDValue');
					}
					?>
					</div>
				</li>
			</ul>
	</div>
	<div class="clearfix">
    <label><?php  echo t('Sort Mode')?></label>
    <ul class="inputs-list">
		<li>
    		<label><input type="radio" name="sortModeOverrideGlobal" value="0" <?php  if ($sortModeOverrideGlobal == 0) { ?> checked <?php  } ?> /> <span><?php echo t("Inherit from global settings.")?></span></label>
    	</li>
    	<li>
    		<label><input type="radio" name="sortModeOverrideGlobal" value="1" <?php  if ($sortModeOverrideGlobal == 1) { ?> checked <?php  } ?> /> <span><?php echo t("Override global settings.")?></span></label>
    	</li>
    </ul>
    </div>
    <?php 

$options = array(
	'cvName' => t('Topic Name'),
	'cvDatePublic' => t('Topic Date'),
	'cvDatePublicLastPost' => t('Latest Reply'),
	'totalViews' => t('Views'),
	'totalPosts' => t('Replies')
);

if ($sortModeOverrideGlobal == 0) {
	$pkg = Package::getByHandle('discussion');
	$sortMode = $pkg->config('GLOBAL_TOPIC_SORT_MODE');
	$sortModeDir = $pkg->config('GLOBAL_TOPIC_SORT_MODE_DIR');
}
?>
<div class="ccm-discussion-block-sort-options"><?php echo $form->select('sortMode', $options, $sortMode)?> <?php echo $form->select('sortModeDir', array('asc' => t('Ascending'), 'desc' => t('Descending')), $sortModeDir)?></div>

</fieldset>
</div>
<script type="text/javascript">
$("input[name=sortModeOverrideGlobal]").click(function() {
	if ($(this).val() == 1) { 
		$("div.ccm-discussion-block-sort-options select").attr('disabled', false);
	} else {
		$("div.ccm-discussion-block-sort-options select").attr('disabled', true);
	}
});
<?php  if ($sortModeOverrideGlobal == 0) { ?>
	$("div.ccm-discussion-block-sort-options select").attr('disabled', 'true');
<?php  } ?>
</script>