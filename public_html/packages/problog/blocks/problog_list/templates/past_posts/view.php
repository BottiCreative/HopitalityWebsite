<?php      
	defined('C5_EXECUTE') or die(_("Access Denied."));
	$textHelper = Loader::helper("text"); 
	$BASE_URL = BASE_URL;
	$blogify = Loader::helper('blogify','problog');
	$searchID = $blogify->getBlogSettings();
	$searchn= Page::getByID($searchID['search_path']);
	$search= $nh->getLinkToCollection($searchn);

	if($title!=''){
		echo '<h1>'.t($title).'</h1>';
	}

	if (count($cArray) > 0) { ?>
	<div class="ccm-page-list">
	<?php      
	for ($i = 0; $i < count($cArray); $i++ ) {
		$cobj = $cArray[$i]; 
		if ($cobj->getCollectionDatePublic() < date('Y-m-d H:i:s') ){
		$bDate[] = $cobj->getCollectionDatePublic();
		$year_list[date('Y',strtotime($cobj->getCollectionDatePublic()))][date('m',strtotime($cobj->getCollectionDatePublic()))][] = $cobj;
		}
	}

	foreach($year_list as $year=>$months){
		echo '<a onclick="javascript: $(\'#year_'.$year.'\').toggle(\'fast\');" style="cursor: pointer;"><h3>'.$year.'</h3></a>';
		echo '<div id="year_'.$year.'" class="arch_months" style="';
		if($year == date('Y')){echo 'display: block;">';}else{echo 'display: none;">';}

		foreach($months as $month=>$pages){
			echo '<a onClick="$(\'#month_'.$month.$year.'\').toggle(\'fast\')" style="cursor: pointer;">'.date('F',strtotime($year.'-'.$month.'-1')).'</a><br/>';
			echo '<div id="month_'.$month.$year.'"';
			if(date('Y-F')== $year.'-'.$month){
				echo 'style="display: block;">';
			}else{
				echo 'style="display: none;">';
			}
			foreach($pages as $page){
				$title = $page->getCollectionName();
				?>
				&nbsp;&nbsp;&nbsp;<a href="<?php      echo $nh->getLinkToCollection($page)?>"><?php      echo $title?></a><br/>
				<?php      
			}
			echo '</div>';
		}
		echo '</div>';
	}
	
	?>
	</div>
	<?php      
	
}
	

		