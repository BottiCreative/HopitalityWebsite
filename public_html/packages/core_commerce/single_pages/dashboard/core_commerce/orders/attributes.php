<?php  if (isset($key)) { ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Edit Attribute'), false, false, false)?>
<form method="post" action="<?php echo $this->action('edit')?>" id="ccm-attribute-key-form">

<?php  Loader::element("attribute/type_form_required", array('category' => $category, 'type' => $type, 'key' => $key)); ?>

</form>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>




<?php  } else if ($this->controller->getTask() == 'select_type' || $this->controller->getTask() == 'add' || $this->controller->getTask() == 'edit') { ?>

	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Order Attributes'), false, false, false)?>

	<?php  if (isset($type)) { ?>
		<form method="post" action="<?php echo $this->action('add')?>" id="ccm-attribute-key-form">
		<?php  Loader::element("attribute/type_form_required", array('category' => $category, 'type' => $type)); ?>
		</form>	
	<?php  } ?>
	
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>



<?php  } else { ?>

	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Order Attributes'), false, false, false)?>

	<?php 
	$attribs = CoreCommerceOrderAttributeKey::getList();
	Loader::element('dashboard/attributes_table', array('category' => $category, 'attribs'=> $attribs, 'editURL' => '/dashboard/core_commerce/orders/attributes')); ?>

	<div class="ccm-pane-body ccm-pane-body-footer" style="margin-top: -25px">
	
	<form method="get" class="form-stacked inline-form-fix" action="<?php echo $this->action('select_type')?>" id="ccm-attribute-type-form">
	<div class="clearfix">
	<?php echo $form->label('atID', t('Add Attribute'))?>
	<div class="input">
	
	<?php echo $form->select('atID', $types)?>
	<?php echo $form->submit('submit', t('Add'))?>
	
	</div>
	</div>
	
	</form>

	</div>

	
	<script type="text/javascript">
	$(function() {
		$("div.ccm-attributes-list").sortable({
			handle: 'img.ccm-attribute-icon',
			cursor: 'move',
			opacity: 0.5,
			stop: function() {
				var ualist = $(this).sortable('serialize');
				$.post('<?php echo $this->action("update_attributes")?>', ualist, function(r) {
	
				});
			}
		});
	});
	
	</script>
	
	<style type="text/css">
	div.ccm-attributes-list img.ccm-attribute-icon:hover {cursor: move}
	</style>

	
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>

<?php  } ?>