<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
	
	$isOtherPage = ($cParentID>0 && !$cThis);

?>

<div class="ccm-block-field-group">
    <h2><?php echo t('Location in Website')?></h2>
    <?php echo t('Select discussions to display')?>:<br/>
    <br/>
    <div>
      
      <div>
        <input type="radio" name="cThis" id="cThisPageField" value="1" <?php  if ($c->getCollectionID() == $cParentID || $cThis) { ?> checked<?php  } ?> />
        <?php echo t('Located beneath this page')?>
      </div>
      
      <div>
        <input type="radio" name="cThis" id="cOtherField" value="0" <?php  if ($isOtherPage) { ?> checked<?php  } ?> />
        <?php echo t('Located beneath another page')?>
        <div id="ccm-discussion-selected-page-wrapper" style=" <?php  if (!$isOtherPage) { ?>display: none;<?php  } ?> padding: 8px 0px 8px 24px">
          <?php  $form = Loader::helper('form/page_selector');
			if ($isOtherPage) {
				print $form->selectPage('cParentIDValue', $cParentID);
			} else {
				print $form->selectPage('cParentIDValue');
			}
			?>
        </div>
      </div>
      
    </div>
</div>

<?php  $form = Loader::helper('form'); ?>

<div class="ccm-block-field-group">
    <h2><?php echo t('Sort Mode')?></h2>
    <?php 

$options = array(
	'display_asc' => t('Display Order'),
	'date_desc' => t('Date of Activity (Descending)'),
	'date_asc' => t('Date of Activity (Ascending)')
);

?>
<div class="ccm-discussion-block-sort-options"><?php echo $form->select('sortMode', $options, $sortMode)?></div>

</div>