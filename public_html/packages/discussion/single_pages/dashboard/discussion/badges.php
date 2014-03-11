<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php  
if($mode == 'form') { ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Discussion Badges'), false, false, false);?>
<div class="ccm-pane-body">
  <form method="post" id="add-badge-form" action="<?php echo $this->url('/dashboard/discussion/badges/','save')?>" enctype="multipart/form-data">
    <?php echo $validation_token->output('add_or_update_group')?>
    <?php  if($badge) {
    	echo $form->hidden('badgeGroupID',$badge->getBadgeGroupID());
    }?>
    <fieldset>
    	<legend><?php echo ($badge?t('Edit Badge'):t('Add Badge'));?></legend>
    	<div class="clearfix">
    		<label><?php echo t('Group')?></label>
    		<div class="input">
    			<?php  if($badge) {?>
    				<?php  echo $form->text('badgeName', $badge->getBadgeName(), array('disabled'=>'disabled'))?>
    			<?php  } else {?>
	    			<?php  echo $form->text('badgeName', $badgeName)?>
	            	<a id="groupSelector" href="<?php echo Loader::helper('concrete/urls')->getToolsURL('user_group_selector')?>?mode=groups" dialog-title="<?php echo t('Select Group')?>" dialog-modal="false"><?php echo t('Select Existing Group')?></a>	
    			<?php  } ?>
    		</div>
    	</div>
    	<div class="clearfix">
    		<label><?php echo t('Description')?></label>
    		<div class="input">
    			<?php  echo $form->text('badgeDescription',$badgeDescription, array('class'=>'span10'));?>
   			</div>
         </div>
		<div class="clearfix">
			<label><?php echo t('Image')?></label>
			<div class="input">
				<?php  if($badge) {?>
					<div style="padding:6px;"><?php echo $badge->getBadgeIcon()?></div>
				<?php  } ?>
				<input type="file" name="badgeImage">
			</div>
		</div>
       
   </fieldset>
</div>
<div class="ccm-pane-footer">
	<?php  echo $concrete_interface->submit(t('Save'), 'add-badge-form', 'right', 'primary')?>
	<?php  echo $concrete_interface->button(t('Cancel'), $this->url('/dashboard/discussion/badges'));?>
</div>
</form>

<script type="text/javascript">
$(function() {
	$("#groupSelector").dialog();
	ccm_triggerSelectGroup = function(gID, gName) {
		$('#badgeName').val(gName);
		/*
		var html = '<input type="checkbox" name="gID[]" value="' + gID + '" style="vertical-align: middle" checked /> ' + gName + '<br/>';
		$("#ccm-additional-groups").append(html);
		*/
	}
});
</script>
	
<?php  } else { ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Discussion Badges'), false, false, false);?>
<div class="ccm-pane-body">
<table>
<tr>
	<th><?php  echo t('Badges')?></th>
	<th><?php  echo $concrete_interface->button(t('Add Badge'), $this->url('/dashboard/discussion/badges','add'), 'right', 'primary')?></th>
</tr>
<?php  if (count($badges) > 0) { 
	
foreach ($badges as $b) { ?>
	<tr>
		<td>
		<div style="float:left; margin-right: 12px;">
			<?php echo  $b->getBadgeIcon();?>
        </div>
        <?php  echo t('Group')?>: <?php echo  $b->getBadgeName();?>
		<div class="ccm-group-description"><?php echo $b->getBadgeDescription()?></div>
    	
    	</td>
    	<td align='right' style='text-align:right'>
    		<?php  echo $concrete_interface->button(t('Edit'), $this->url('/dashboard/discussion/badges','edit',$b->getBadgeGroupID()), 'left');?>
    		<a href="<?php  echo  $this->url('/dashboard/discussion/badges','delete',$b->getBadgeGroupID());?>" 
    		onclick="return confirm('<?php  echo t('Are you sure you want to permanently remove this badge?') ?>');" 
    		class="btn ccm-button-v2 error"><?php  echo t('Delete')?></a>
   	</td>
   	</tr>

<?php  } 

} else { ?>
	<tr>
		<td><?php echo t('No groups found.')?></td>
		<td></td>
	</tr>
<?php  } ?>
</table>
  
  </div>
<div class="ccm-pane-footer"></div>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>         
<?php  
}
?>