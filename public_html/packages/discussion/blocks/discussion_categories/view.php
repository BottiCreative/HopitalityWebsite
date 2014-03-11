<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$ih = Loader::helper('image');
?>
<table border="0" cellspacing="0" cellpadding="0" class="ccm-discussion-category-list">
<tr>
	<th>&nbsp;</th>
	<th><?php echo t('Categories')?></th>
	<th><?php echo t('Last Post')?></th>
	<th><?php echo t('Topics')?></th>
	<th><?php echo t('Messages')?></th>
</tr>
<?php  
$i = 0;
foreach($categories as $cat) { 
	$p = new Permissions($cat);
	if ($p->canRead()) { 
	?>
	<tr>
		<td class="ccm-discussion-image"><?php 
			
			$im = $cat->getAttribute('discussion_image');
			if (is_object($im)) {
				//$ih->output($im);
				print $im->getThumbnail(1);
			}		
		?></td>
		<td class="ccm-discussion-category-name">
		<h2><a href="<?php echo $nav->getLinkToCollection($cat)?>"><?php echo $cat->getCollectionName()?></a></h2>
		<p><?php echo $cat->getCollectionDescription()?></p> 
		</td>
		<td class="ccm-discussion-category-last-post"><?php 
			$post = $cat->getLastPost();		
			if (is_object($post)) { 
				$pu = $post->getUserObject();
				$topPost = $post->getPost();
				$postLink = $nav->getLinkToCollection($topPost)."#".$post->getCollectionID();
				?><a href="<?php echo $postLink?>"><?php echo $post->getCollectionName()?></a>
				<div class="ccm-discussion-post-time">
					<?php   
					if(ENABLE_USER_PROFILES && $pu->getUserID() > 0) {
						echo t('By')."  <a href=\"".View::url('/profile',$pu->getUserID())."\">".$post->getUserName()."</a>";
					} else {
						echo t('By')." ".$post->getUserName();
					}
					echo " ";
					echo t('on')." ".date(DATE_APP_GENERIC_MDY_FULL, strtotime($post->getCollectionDatePublic()));
					?>
				</div>
		<?php  } ?>
		</td>
		<td><?php echo number_format($cat->getTotalTopics())?></td>
		<td><?php echo number_format($cat->getTotalPosts())?></td>
	</tr>
<?php  
	$i++;
}

}

if ($i == 0) {  ?>
	<tr>
		<td colspan="5"><?php echo t('No discussions available.')?></td>
	</tr>
<?php  } ?>
</table>
