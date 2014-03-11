<?php  
$nh = Loader::helper('navigation');
global $c;

// How this works: We display all levels until we get to a page that is NOT 
// a discussion or discussion_post 
$trail = $nh->getTrailToCollection($c);
$pages = array();
foreach($trail as $p) {
	$pages[] = $p;
	if (!in_array($p->getCollectionTypeHandle(), array('discussion_post', 'discussion'))) {
		break;
	}
}
$pages = array_reverse($pages);
?>
<ul class="ccm-discussion-breadcrumb">
<?php  for ($i = 0; $i < count($pages); $i++) {
	$p = $pages[$i]; ?>
	<li><a href="<?php echo $nh->getLinkToCollection($p)?>"><?php echo $p->getCollectionName()?></a></li>
	<?php  if (($i+1) < count($pages)) { ?>
		<li>&raquo;</li>
	<?php  } ?>
<?php  } ?>

	<li>&raquo;</li>
	<li><?php echo $c->getCollectionName()?></li>
</ul>