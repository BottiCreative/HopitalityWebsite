<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));
	if($title!=''){
		echo '<h2>'.t($title).'</h2>';
	}
	?>
	<div class="ccm-page-list">
	
	<?php      
	$tagCounts = array();

	Loader::model('attribute/types/select/select_blog','problog');
	$ak = CollectionAttributeKey::getByHandle('tags');
	$akc = new SelectBlog(AttributeType::getByHandle('select'));
	$akc->setAttributeKey($ak);
	$ttags = $akc->getOptionUsageArray($pp);

	$tags = array();
	foreach($ttags as $t) {
		$tagCounts[] = $t->getSelectAttributeOptionUsageCount();
		$tags[] = $t;
	}
	shuffle($tags);

	for ($i = 0; $i < $ttags->count(); $i++) {
		$akct = $tags[$i];
		//$qs = $akc->field('atSelectOptionID') . '[]=' . $akct->getSelectAttributeOptionID();
		echo '<a href="'.BASE_URL.$search.rawurlencode(str_replace(' ','_',$akct->getSelectAttributeOptionValue())).'/">'.$akct->getSelectAttributeOptionValue().' ('.$akct->getSelectAttributeOptionUsageCount().')</a><br/>';
			
	}
	?>
	</div><br/><?php       

		