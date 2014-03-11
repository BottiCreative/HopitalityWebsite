<?php  defined('C5_EXECUTE') or die(_('Access Denied.'));

// Configuration
$use_advanced_group_selection = true;

// Models
Loader::model('product/set', 'core_commerce');
Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
Loader::model('search/group');

// helpers
$form = Loader::helper('form');
$mlh = Loader::helper('multilingual', 'core_commerce');

// various arrays
$sets = CoreCommerceProductSet::getList(); // - product sets
$groupList = new GroupSearch(); // - user group list
if ($groupList->getTotal() < 1000) { $groupList->setItemsPerPage(1000); }
if (!isset($gIDs)) { $gIDs = $_POST['gID'];	}
$attribs = CoreCommerceProductAttributeKey::getList(); // product attributes

// tinymce
$this->addHeaderItem(Loader::helper('html')->javascript('tiny_mce/tiny_mce.js'));

// load all of the product data
if (is_object($product)) { 
	$prName = $product->getProductName();
	$prDescription = $product->getProductDescription();
	$prStatus = $product->getProductStatus();
	$prPrice = $product->getProductPrice();
	$prSpecialPrice = $product->getProductSpecialPrice(false);
	if ($prSpecialPrice == 0) {
		$prSpecialPrice = '';
	}
	$prQuantity = $product->getProductQuantity();
	$prMinimumPurchaseQuantity = $product->getMinimumPurchaseQuantity();
	$prQuantityUnlimited = $product->productHasUnlimitedQuantity();
	$prQuantityAllowNegative = $product->getProductNegativeQuantitySetting();
	$prPhysicalGood = $product->productIsPhysicalGood();
	$prRequiresShipping = $product->productRequiresShipping();
	
	$prWeight = $product->getProductWeight();
	$prWeightUnits = $product->getProductWeightUnits();
	$prDimL = $product->getProductDimensionLength();
	$prDimW = $product->getProductDimensionWidth();
	$prDimH = $product->getProductDimensionHeight();
	$prDimUnits = $product->getProductDimensionUnits();

	$productID = $product->getProductID();
	$prRequiresTax = $product->productRequiresSalesTax();
	$prShippingModifier = $product->getProductShippingModifier();
	$gIDs = $product->getProductPurchaseGroupIDArray();
	$cID = $product->getProductCollectionID();
	$prRequiresLoginToPurchase = $product->productRequiresLoginToPurchase();
	$prUseTieredPricing = $product->productUsesTieredPricing();
	
	$tiers = array();
	if ($prUseTieredPricing) {
		Loader::model('product/tiered_price', 'core_commerce');
		$tiers = CoreCommerceProductTieredPrice::getTiers($product);
	}
}


// setup the tabs array to use the interface helper
$tabs = array(
	array('base-information',     t('Base Information'), true),
	array('purchase-stock',       t('Purchase & Stock')),
	array('price-cost',           t('Price & Cost')),
	array('shipping-information', t('Shipping Information')),
	array('groups-sets',          t('Groups & Sets')),
	array('product-attributes',   t('Product Attributes'))
);

if ($mlh->isEnabled()) { $tabs[] = array('multilingual-setup', t('Multilingual Setup')); }

?>
<?php 
/**
 * Output our navigawtion tabs
 */
?>
<?php  echo Loader::helper('concrete/interface')->tabs($tabs); ?>
<?php  echo $form->hidden('productID', $productID); ?>

<?php 
/*******************************
 * START Tab Panes
 * -----------------------------
 * 
 * Base Information Tab
 * - Name
 * - Description
 * - Page Selector
 */
?>
<div class="tab-pane active" id="ccm-tab-content-base-information">
	<fieldset>

		<div class="control-group">
			<?php  echo $form->label('prName', t('Name') . '	<span class="ccm-required">*</span>'); ?>
			<div class="controls">
				<?php  echo $form->text('prName', $prName, array('class' => 'span7')); ?>
			</div>
		</div>

		<div class="control-group">
			<?php  echo $form->label('prDescription', t('Description') . '	<span class="ccm-required">*</span>'); ?>
			<div class="controls">
				<?php  Loader::element('editor_init'); ?>
				<?php  Loader::element('editor_config'); ?>
				<?php  Loader::element('editor_controls', array('mode'=>'full')); ?>
				<?php  echo $form->textarea('prDescription', $prDescription, array('class' => 'ccm-advanced-editor span6')); ?>
			</div>
		</div>

		<?php  if (is_object($product)): ?>
		<div class="control-group">
			<label class="control-group"><?php  echo t('Product Page'); ?></label>
			<div class="controls">
				<?php  echo Loader::helper('form/page_selector')->selectPage('cID', $cID); ?>
			</div>
		</div>
		<?php  endif; // is_object $product ?>

	</fieldset>
</div><!-- /#ccm-tab-content-base-information.tab-pane -->

<?php 
/**
 * Purchase & Stock
 * - Status
 * - Quantity
 * - Physical Good
 * - Requires Login
 */
?>
<div class="tab-pane" id="ccm-tab-content-purchase-stock">
	<fieldset>

		<div class="control-group">
			<?php  echo $form->label('prStatus', t('Status') . '	<span class="ccm-required">*</span>'); ?>
			<div class="controls">
				<?php  echo $form->select('prStatus', array(
						'1' => t('Enabled'), 
						'0' => t('Disabled')
					), $prStatus,array('class'=>'input-medium'));?>
			</div>
		</div>

		<div class="control-group">
			<?php  echo $form->label('prQuantity', t('Quantity In Stock')); ?>
			<div class="controls">
				<?php  echo $form->text('prQuantity', $prQuantity, array('style' => 'width: 50px')); ?>
				<label for="prQuantityUnlimited" class="checkbox inline">
					<?php  echo $form->checkbox('prQuantityUnlimited', 1, $prQuantityUnlimited); ?>
					<?php  echo t('Unlimited'); ?>
				</label>
			</div>
		</div>

		<div class="control-group">
			<?php  echo $form->label('prQuantityAllowNegative', t('Allow Negative Quantity')); ?>
			<div class="controls">
				<?php  echo $form->select('prQuantityAllowNegative', array(
						(string)CoreCommerceProduct::NEGATIVE_QUANTITY_YES => 'Yes',
						(string)CoreCommerceProduct::NEGATIVE_QUANTITY_NO => 'No',
						(string)CoreCommerceProduct::NEGATIVE_QUANTITY_SYSTEM => 'System default'
					), $prQuantityAllowNegative,array('class'=>'input-medium')); ?>
			</div>
		</div>

		<div class="control-group">
			<?php  echo $form->label('prMinimumPurchaseQuantity', t('Min. Units To Buy')); ?>
			<div class="controls">
				<?php  echo $form->text('prMinimumPurchaseQuantity',$prMinimumPurchaseQuantity, array('style' => 'width: 50px')); ?>
			</div>
		</div>

		<div class="control-group">
			<?php  echo $form->label('prPhysicalGood', t('Physical Good')); ?>
			<div class="controls">
				<?php  echo $form->select('prPhysicalGood', array(
						'1' => t('Yes'),
						'0' => t('No')
					), $prPhysicalGood,array('class'=>'input-medium'));?>
			</div>
		</div>

		<div class="control-group">
			<?php  echo $form->label('prRequiresLoginToPurchase', t('Requires Login')); ?>
			<div class="controls">
				<?php  echo $form->select('prRequiresLoginToPurchase', array(
						'1' => t('Yes'), 
						'0' => t('No')
					), $prRequiresLoginToPurchase,array('class'=>'input-medium'));?>
			</div>
		</div>

	</fieldset>
</div><!-- /#ccm-tab-content-purchase-stock.tab-pane -->

<?php 
/**
 * Price & Cost
 * - Price
 * - Sale Price
 * - Sales Tax
 * - Tiered Pricing
 */
?>
<div class="tab-pane" id="ccm-tab-content-price-cost">
	<fieldset>

		<div class="control-group">
			<?php  echo $form->label('prPrice', t('Price')); ?>
			<div class="controls">
				<?php  echo $form->text('prPrice', $prPrice, array('class' => 'input-mini')); ?>
			</div>
		</div>

		<div class="control-group">
			<label for="prHasSpecialPrice" class="control-label"><?php  echo t('Special/Sale Price'); ?></label>
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on"><?php  echo $form->checkbox('prHasSpecialPrice', 1, $prSpecialPrice != '', array('class'=>'inline')); ?></span>
					<?php  echo $form->text('prSpecialPrice', $prSpecialPrice, array('class' => 'input-mini')); ?>
				</div>
			</div>
		</div>

		<div class="control-group">
			<?php  echo $form->label('prRequiresTax', t('Charge Sales Tax')); ?>
			<div class="controls ccm-core-commerce-product-requires-tax">
				<?php  echo $form->select('prRequiresTax', array(
					'1' => t('Yes'),
					'0' => t('No')
				), $prRequiresTax, array('class' => 'input-medium')); ?>
			</div>
		</div>

		<div class="control-group">
			<label for="prUseTieredPricing" class="control-label"><?php  echo t('Tiered Pricing'); ?></label>
			<div class="controls">
				<ul class="inputs-list">
					<li>
						<label>
							<?php  echo $form->checkbox('prUseTieredPricing', 1, $prUseTieredPricing); ?> 
							<span><?php  echo t('Enable Tiered Pricing'); ?></span>
						</label>
						<div id="ccm-core-commerce-product-tiered-pricing-fields-wrapper">
							<?php  
							$pkg = Package::getByHandle('core_commerce');
							$currency = $pkg->config('CURRENCY_SYMBOL'); if (empty($currency)) { $currency = '$'; } ?>
							<?php  if (Controller::isPost()): ?>
								<?php  for ($i = 0; $i < count($_POST['prTieredPricing']['tierStart']); $i++): ?>
									<div class="ccm-core-commerce-product-tiered-pricing-fields" <?php  if ($i == 0): ?>id="ccm-core-commerce-product-tiered-pricing-fields-base" <?php  endif; ?>>
										<input type="text" class="ccm-input-text" name="prTieredPricing[tierStart][]" value="<?php  echo htmlentities($_POST['prTieredPricing']['tierStart'][$i], ENT_QUOTES, APP_CHARSET); ?>" style="width: 30px" />
										<?php  echo t('to'); ?>
										<input type="text" class="ccm-input-text" name="prTieredPricing[tierEnd][]" value="<?php  echo htmlentities($_POST['prTieredPricing']['tierEnd'][$i], ENT_QUOTES, APP_CHARSET); ?>" style="width: 30px" />
										&nbsp;&nbsp;
										<?php  echo $currency; ?>
										<input type="text" class="ccm-input-text" name="prTieredPricing[tierPrice][]" value="<?php  echo htmlentities($_POST['prTieredPricing']['tierPrice'][$i], ENT_QUOTES, APP_CHARSET); ?>" style="width: 80px" />
										<a href="javascript:void(0)" onclick="ccm_coreCommerceRemovePricingTier(this)"><img src="<?php  echo ASSETS_URL_IMAGES?>/icons/remove_minus.png" style="vertical-align: middle"  width="16" height="16" /></a>
									</div>
								<?php  endfor; // tierStart ?>
							<?php  elseif (count($tiers) > 0): ?>
								<?php  for ($i = 0; $i < count($tiers); $i++): $t = $tiers[$i]; ?>
								<div class="ccm-core-commerce-product-tiered-pricing-fields" <?php  if ($i == 0): ?>id="ccm-core-commerce-product-tiered-pricing-fields-base" <?php  endif; ?>>
									<input type="text" class="ccm-input-text" name="prTieredPricing[tierStart][]" value="<?php  echo $t->getTierStart(); ?>" style="width: 30px" />
									<?php  echo t('to'); ?>
									<input type="text" class="ccm-input-text" name="prTieredPricing[tierEnd][]" value="<?php  echo $t->getTierEnd(); ?>" style="width: 30px" />
									&nbsp;&nbsp;
									<?php  echo $currency; ?>
									<input type="text" class="ccm-input-text" name="prTieredPricing[tierPrice][]" value="<?php  echo $t->getTierPrice(); ?>" style="width: 80px" />
									<a href="javascript:void(0)" onclick="ccm_coreCommerceRemovePricingTier(this)"><img src="<?php  echo ASSETS_URL_IMAGES?>/icons/remove_minus.png" style="vertical-align: middle"  width="16" height="16" /></a>
								</div>
								
								<?php  endfor; // $tiers ?>	
							<?php  else: ?>
							<div class="ccm-core-commerce-product-tiered-pricing-fields" id="ccm-core-commerce-product-tiered-pricing-fields-base">
								<input type="text" class="ccm-input-text" name="prTieredPricing[tierStart][]" value="1" style="width: 30px" />
								<?php  echo t('to'); ?>
								<input type="text" class="ccm-input-text" name="prTieredPricing[tierEnd][]" value="" style="width: 30px" />
								&nbsp;&nbsp;
								<?php  echo $currency?>
								<input type="text" class="ccm-input-text" name="prTieredPricing[tierPrice][]" value="" style="width: 80px" />
								<a href="javascript:void(0)" onclick="ccm_coreCommerceRemovePricingTier(this)"><img src="<?php  echo ASSETS_URL_IMAGES?>/icons/remove_minus.png" style="vertical-align: middle"  width="16" height="16" /></a>
							</div>
							<?php  endif; // ispost || count($tiers) || else ?>
						</div><!-- /#ccm-core-commerce-product-tiered-pricing-fields-wrapper -->
			
					<br/>
					<a class="btn" style="<?php  if (!$prUseTieredPricing): ?> display: none<?php  endif; ?>" id="ccm-core-commerce-product-tiered-pricing-add-tier" href="javascript:void(0)" onclick="ccm_coreCommerceAddPricingTier()">
						<?php  echo t('Add Tier'); ?>
					</a>
				</li>
			</ul>
		</div>
	</div>

	</fieldset>
</div><!-- /#ccm-tab-content-price-cost.tab-pane -->

<?php 
/**
 * Shipping Information
 * - Requires Shipping
 * - Weight
 * - Dimensions
 * - Modifier
 */
?>
<div class="tab-pane" id="ccm-tab-content-shipping-information">
	<fieldset>

		<div class="control-group">
			<?php  echo $form->label('prRequiresShipping', t('Requires Shipping')); ?>
			<div class="input ccm-core-commerce-product-requires-shipping"><?php  echo $form->select('prRequiresShipping', array(
					'1' => t('Yes'),
					'0' => t('No')
				), $prRequiresShipping,array('class'=>'input-medium'));?>
			</div>
		</div>

		<div class="control-group">
		<?php  echo $form->label('prWeight', t('Weight')); ?>
			<div class="input ccm-core-commerce-product-weight">
					<?php  echo $form->text('prWeight', $prWeight, array('class' => 'input-mini')); ?>
					<?php  echo $form->select('prWeightUnits', array(
						'lb' => t('lb'),
						'g' => t('g'),
						'kg' => t('kg'),
						'oz' => t('oz'),
					), $prWeightUnits, array('class' => 'input-mini'));?>		
			</div>
		</div>

		<div class="control-group">
			<?php  echo $form->label('prDimL', t('Dimensions (LxWxH)')); ?>
			<div class="input ccm-core-commerce-product-dimensions">
				<?php  echo $form->text('prDimL', $prDimL, array('style' => 'width: 20px')); ?>
				<?php  echo $form->text('prDimW', $prDimW, array('style' => 'width: 20px')); ?>
				<?php  echo $form->text('prDimH', $prDimH, array('style' => 'width: 20px')); ?>
				<?php  echo $form->select('prDimUnits', array(
					'in' => t('in'),
					'mm' => t('mm'),
					'cm' => t('cm')
				), $prDimUnits, array('class' => 'input-mini'));?>
			</div>
		</div>

		<div class="control-group">
			<?php  echo $form->label('prShippingModifier', t('Shipping Modifier')); ?>
			<div class="input ccm-core-commerce-product-shipping-modifier">
				<?php  echo $form->text('prShippingModifier', $prShippingModifier, array('class'=>'input-mini')); ?>
			</div>
		</div>

	</fieldset>
</div><!-- /#ccm-tab-content-shipping-information.tab-pane -->

<?php 
/**
 * Groups & Sets
 */
?>
<div class="tab-pane" id="ccm-tab-content-groups-sets">
	<fieldset>

		<?php  
		/**
		 * Add Users into Group on Purchase
		 */
		?>
		<?php  if (TaskPermission::getByHandle('access_user_search')->can()): ?>
		<div class="control-group">
			<label class="control-label">
				<?php  echo t('Place customers in user groups:'); ?>
				<strong class="help-block muted"><?php  echo t('Requires login or registration before checkout.'); ?></strong>
			</label>
			<div class="controls">

				<?php  // use chosen() for the selection of groups ?>
				<?php  if ($use_advanced_group_selection): ?>
				<select class="ccm-chosen-select" name="gID[]" multiple="multiple" placeholder="Choose groups...">
					<?php  foreach ($groupList->getPage() as $group): if($group['gID'] != ADMIN_GROUP_ID): ?>
					<option value="<?php  echo $group['gID']; ?>"<?php  if (is_array($gIDs) && in_array($group['gID'], $gIDs)): ?>selected="selected"<?php  endif; ?>><?php  echo $group['gName']; ?></option>
					<?php  endif; endforeach; ?>
				</select>

				<?php  // standard ul > li > input[type="checkbox"] ?>
				<?php  else: ?>
				<ul class="inputs-list">
					<?php  foreach ($groupList->getPage() as $group): if($group['gID'] != ADMIN_GROUP_ID): ?> 
					<li>
						<label class="checkbox">
							<input type="checkbox" name="gID[]" value="<?php  echo $group['gID']; ?>"<?php  if (is_array($gIDs) && in_array($group['gID'], $gIDs)): ?>checked="checked"<?php  endif; ?> />
							<span><?php  echo $group['gName']; ?></span>
						</label>
					</li>
					<?php  endif; endforeach; ?>
				</ul>
				<?php  endif; // $advanced_group_selection || else ?>

			</div>
		</div>
		<?php  endif; // task: can search users ?>

		<?php  
		/**
		 * Product Sets
		 */
		?>
		<?php  if (count($sets) > 0): ?>
		<div class="control-group">
			<label class="control-label"><?php  echo t('Place this product in the following sets: '); ?></label>
			<div class="controls">

				<?php  // use chosen() for the selection of groups ?>
				<?php  if ($use_advanced_group_selection): ?>
				<select class="ccm-chosen-select" name="prsID[]" multiple="multiple" placeholder="Choose sets...">
					<?php  foreach ($sets as $prs): $isChecked = (is_object($product)) ? $prs->contains($product) : 0; ?>
						<option value="<?php  echo $prs->getProductSetID(); ?>"<?php  if ($isChecked): ?>selected="selected"<?php  endif; ?>><?php  echo $prs->getProductSetName(); ?></option>
					<?php  endforeach; // $sets ?>
				</select>

				<?php  // standard ul > li > input[type="checkbox"] ?>
				<?php  else: ?>
				<ul class="inputs-list">
					<?php  foreach ($sets as $prs): ?>
						<?php  $isChecked = (is_object($product)) ? $prs->contains($product) : 0; ?>
						<li>
							<label class="checkbox">
								<?php  echo $form->checkbox('prsID[]', $prs->getProductSetID(), $isChecked); ?>
								<span><?php  echo $prs->getProductSetName(); ?></span>
							</label>
						</li>
					<?php  endforeach; // $sets ?>
				</ul>
				<?php  endif; // $advanced_group_selection || else ?>

			</div>
		</div>
		<?php  endif; // (count($sets)) ?>

	</fieldset>
</div><!-- /#ccm-tab-content-groups-sets.tab-pane -->

<?php 
/**
 * Product Attributes
 */
?>
<div class="tab-pane" id="ccm-tab-content-product-attributes">
	<fieldset>

	<?php  if (count($attribs) > 0): ?>
		<?php  foreach($attribs as $ak): ?>
			<?php  if (is_object($product)): $caValue = $product->getAttributeValueObject($ak); ?>
			<div class="control-group">
				<?php  echo $ak->render('label'); ?>
				<div class="controls">
					<?php  echo $ak->render('composer', $caValue, true); ?>
				</div>
			</div>
			<?php  else: ?>
			<div class="control-group">
				<div class="controls">
					<em><?php  echo t('This product has no additional attributes'); ?></em>
				</div>
			</div>
			<?php  endif; // is_object($product) || else ?>
		<?php  endforeach; // $attrib ?>
	<?php  endif; // count($attribs); ?>

	</fieldset>
</div><!-- /#ccm-tab-content-product-attributes.tab-pane -->



<?php 
/**
 * Multilingual Setup
 */
?>
<?php  if($mlh->isEnabled()): ?>
<div class="tab-pane" id="ccm-tab-content-multilingual-setup">

		<fieldset>
			<div class="control-group">
			<?php  echo $form->label('prLanguage', t('Select a Language')); ?>
				<div class="input">
					<?php  
					$sections = $mlh->getSectionSelectArray();
					if (is_object($product)) {
						$lang = $product->getProductLanguage();
					}
					if(is_array($sections) && count($sections)) {
						echo $form->select('prLanguage', $sections, $lang);
					} else {?>
						<select disabled="disabled"><option><?php  echo t('No languages enabled'); ?></option></select>
					<?php  
					}
					?>
				</div>
			</div>
		</fieldset>
</div><!-- /#ccm-tab-content-multilingual-setup.tab-pane -->
<?php  endif; // multilingual enabled ?>

<?php 
/*****************************
 * END Tab Panes
 */
?>

<script type="text/javascript">
ccm_coreCommerceAddPricingTier = function() {
	var wrap = $('#ccm-core-commerce-product-tiered-pricing-fields-wrapper');
	var base = $('#ccm-core-commerce-product-tiered-pricing-fields-base');
	wrap.append('<div class="ccm-core-commerce-product-tiered-pricing-fields">' + base.html() + '</div>');
}

ccm_coreCommerceRemovePricingTier = function(row) {
	var wrap = $(row).parent();
	wrap.remove();
}

ccmCoreCommerceProductCheckSelectors = function(s) {
	if ($('select[name=prPhysicalGood]').val() == '1') {
		if (s && s.attr('name') != 'prRequiresShipping') {
			$('select[name=prRequiresShipping]').val(1);
		}
		$('td.ccm-core-commerce-product-requires-shipping select').attr('disabled', false);
	} else {
		$('select[name=prRequiresShipping]').val(0);
		$('td.ccm-core-commerce-product-requires-shipping select').attr('disabled', true);
	}

	if ($('select[name=prRequiresShipping]').val() == '1') {
		$('td.ccm-core-commerce-product-dimensions input').attr('disabled', false);
		$('td.ccm-core-commerce-product-dimensions select').attr('disabled', false);
		$('td.ccm-core-commerce-product-weight input').attr('disabled', false);
		$('td.ccm-core-commerce-product-weight select').attr('disabled', false);
		$('td.ccm-core-commerce-product-shipping-modifier input').attr('disabled', false);
	} else {
		$('td.ccm-core-commerce-product-dimensions input').attr('disabled', true);
		$('td.ccm-core-commerce-product-dimensions select').attr('disabled', true);
		$('td.ccm-core-commerce-product-weight input').attr('disabled', true);
		$('td.ccm-core-commerce-product-weight select').attr('disabled', true);
		$('td.ccm-core-commerce-product-shipping-modifier input').attr('disabled', true);

	}


	if ($('input[name=prQuantityUnlimited]').attr('checked')) {
		$('input[name=prQuantity]').val('');
		$('input[name=prQuantity]').attr('disabled', true);
	} else {
		$('input[name=prQuantity]').attr('disabled', false);
		if (s && s.attr('name') == 'prQuantityUnlimited') {
			$('input[name=prQuantity]').get(0).focus();
		}
	}

	if ($('input[name=prUseTieredPricing]').attr('checked')) {
		$('input[name=prPrice]').val('');
		$('input[name=prPrice]').attr('disabled', true);
		$('#ccm-core-commerce-product-tiered-pricing-add-tier').show();
		$('#ccm-core-commerce-product-tiered-pricing-fields-wrapper').show();
	} else {
		$('input[name=prPrice]').attr('disabled', false);
		$('#ccm-core-commerce-product-tiered-pricing-add-tier').hide();
		$('#ccm-core-commerce-product-tiered-pricing-fields-wrapper').hide();
	}

	if ($('input[name=prHasSpecialPrice]').attr('checked')) {
		$('input[name=prSpecialPrice]').attr('disabled', false);
		if (s && s.attr('name') == 'prHasSpecialPrice') {
			$('input[name=prSpecialPrice]').get(0).focus();
		}
	} else {
		$('input[name=prSpecialPrice]').val('');
		$('input[name=prSpecialPrice]').attr('disabled', true);

	}

}

$(function() {
	ccm_activateFileSelectors();
	$('input[name=prUseTieredPricing]').click(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
		
	$('input[name=prQuantityUnlimited]').click(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
	$('select[name=prRequiresShipping]').change(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
	$('input[name=prHasSpecialPrice]').click(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
	$('select[name=prPhysicalGood]').change(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
	
	ccmCoreCommerceProductCheckSelectors();
	$('.page-selector').click( 
		function (e) {
			$.fn.dialog.open({
				 href: "<?php  echo Loader::helper('concrete/urls')->getToolsURL('create_page', 'core_commerce'); ?>",
				 title: "<?php  echo t('Create a Product Page?'); ?>",
				 width: 550,
				 modal: true,
				 onOpen:function(){},
				 onClose: function(e){},
				 height: 480
			});
		  e.preventDefault(); 
		}
	);

	$('.ccm-chosen-select').chosen();
	
});
</script>

<style type="text/css">
#ccm-core-commerce-product-edit-form td {vertical-align: top;}
#ccm-core-commerce-product-update-form .nav-tabs {margin-bottom: 36px;}
#ccm-core-commerce-product-update-form .tab-pane {display: none;}
#ccm-core-commerce-product-update-form #ccm-tab-content-groups-sets .control-label {width: 240px;}
#ccm-core-commerce-product-update-form #ccm-tab-content-groups-sets .controls {margin-left: 260px;}
#ccm-core-commerce-product-update-form #ccm-tab-content-groups-sets .radio input[type="radio"],
#ccm-core-commerce-product-update-form #ccm-tab-content-groups-sets .checkbox input[type="checkbox"] { margin-left: 0; margin-right: 4px; }
.ccm-core-commerce-product-tiered-pricing-fields {padding-bottom: 5px;}
#ccm-core-commerce-product-tiered-pricing-fields-base a {display: none;}
</style>