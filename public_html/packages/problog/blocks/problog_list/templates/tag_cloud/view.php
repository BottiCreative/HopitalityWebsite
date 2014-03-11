<?php       
	defined('C5_EXECUTE') or die(_("Access Denied."));

	if($title!=''){
		echo '<h2>'.t($title).'</h2>';
	}
	?>
	<div class="ccm-page-list tagC">
	<style>
		.ccm-page-list.tagC a {float: left; text-decoration: none; padding-right: 5px;}
	</style>
	<?php       
	$ak = CollectionAttributeKey::getByHandle('tags');
	$akc = $ak->getController();
	
	if(!function_exists('setFontPxy')){
		function setFontPxy($weight) {
			$tagMinFontPx = '10';
			$tagMaxFontPx = '24';
			
			$em = (($weight * ($tagMaxFontPx - $tagMinFontPx)) + $tagMinFontP);
			$em = round($em);
			return $em;
		}
	}
	
	$tagCounts = array();
	
	Loader::model('attribute/types/select/select_blog','problog');
	$ak = CollectionAttributeKey::getByHandle('tags');
	$akc = new SelectBlog(AttributeType::getByHandle('select'));
	$akc->setAttributeKey($ak);
	$ttags = $akc->getOptionUsageArray($pp);

	$tags = array();
	
	if(!empty($ttags)){
		foreach($ttags as $t) {
			$tagCounts[] = $t->getSelectAttributeOptionUsageCount();
			$tags[] = $t;
		}
		shuffle($tags);
		$tagSizes = array();
		$count = count($tagCounts);
		foreach($tagCounts as $tagCount => $pos) {
			$tagSizes[$pos] = setFontPxy(($pos + 1) / $count + 1);
		}
	
		for ($i = 0; $i < $ttags->count(); $i++) {
			$akct = $tags[$i];
			$qs = $akc->field('atSelectOptionID') . '[]=' . $akct->getSelectAttributeOptionID();
			echo '<a href="'.BASE_URL.$search.rawurlencode(str_replace(' ','_',$akct->getSelectAttributeOptionValue())).'/" style="font-size: '.$tagSizes[$akct->getSelectAttributeOptionUsageCount()].'px">'.$akct->getSelectAttributeOptionValue().'</a>';
	
		}
	}
	?></div><br style="clear: both;"/><br/><?php       

		