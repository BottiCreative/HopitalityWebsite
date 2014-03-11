<?php   defined('C5_EXECUTE') or die(_("Access Denied."));
$ih = Loader::helper('image');

$i = 0;
foreach($categories as $cat) { 
	$p = new Permissions($cat);
	if ($p->canRead()) { 
	?>
	<div class="discussion-category-row">
		<div class="ccm-discussion-image"><?php  
			$im = $cat->getAttribute('discussion_image');
			if (is_object($im)) {
				//$ih->output($im);
				print $im->getThumbnail(1);
			}
			?>
		</div>
		<div class="discussion-category-summary">
			<div class="ccm-discussion-category-name">
				<h2><a href="<?php  echo $nav->getLinkToCollection($cat)?>"><?php  echo $cat->getCollectionName()?></a></h2>
				<div>
				<?php  $total = $cat->getTotalPosts(); ?>
					<div class="discussion-category-post-count"><?php  echo number_format($total)?> message<?php  echo ($total>1||$total==0?'s':'')?></div>
					<p><?php  echo $cat->getCollectionDescription()?></p>
					<?php  /* echo number_format($cat->getTotalTopics()) */?>
				</div>
				<div class="ccm-discussion-category-last-post"><?php  
				$post = $cat->getLastPost();		
				if (is_object($post)) { 
					$pu = $post->getUserObject();
					$topPost = $post->getPost();
					$postLink = $nav->getLinkToCollection($topPost)."#".$post->getCollectionID();
					?>
					<div class="ccm-discussion-post-time">
						<span><?php  echo date(DATE_APP_GENERIC_MDY_FULL, strtotime($post->getCollectionDatePublic()))?><br />
						<a href="<?php  echo $postLink?>"><?php  echo $post->getCollectionName()?></a>
						<?php echo t('By')?> <a href="<?php  echo View::url('/profile',$pu->getUserID())?>"><?php  echo $post->getUserName()?></a></span>
					</div>
			<?php   } ?>
			</div>
			</div>
			
		</div>
		<div class="spacer"></div>
	</div>
	<div class="spacer"></div>
<?php   
	$i++;
}

}
if ($i == 0) {  ?>
	<div class="discussion-category-row"><?php  echo t('No discussions available.')?></div>
<?php   } ?>