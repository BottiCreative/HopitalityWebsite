<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$textHelper = Loader::helper("text");

?>
<div class="ccm-discussion-post-list">
<?php 
if($postToCID > 0) { // show the post links + post form
	$discussionPage = Page::getByID($postToCID);
	?>
	<ul class="ccm-discussion-menu">
		<li><a href="<?php  echo View::url($discussionPage->getCollectionPath())?>"><?php echo t('View Discussion')?></a></li>
		<li><a href="<?php  echo View::url($discussionPage->getCollectionPath(),'preload',Page::getCurrentPage()->getCollectionID())?>" ><?php echo t('Start Discussion')?></a></li>
	</ul>
<?php  }

if (count($cArray) > 0) {
	for ($i = 0; $i < count($cArray); $i++ ) {
		$cobj = $cArray[$i];
		$title = $cobj->getCollectionName();
		$post = $cobj->getPost();
		?>

		<h3 class="ccm-discussion-post-list-title"><a href="<?php echo $nh->getLinkToCollection($post)?>#msg<?php  echo $cobj->getCollectionID();?>"><?php echo $title?></a></h3>
		<div class="ccm-discussion-post-list-description">
			<?php 
			Loader::library('3rdparty/bbcode');
			$bb = new Simple_BB_Code();
			if(!$controller->truncateSummaries){
				echo BbcodeBlockController::addEmoticons($bb->parse($cobj->getCollectionDescription()));
			}else{
				echo BbcodeBlockController::addEmoticons($bb->parse($textHelper->shorten($cobj->getCollectionDescription(),$controller->truncateChars)));
			}
			?>
		</div>
		<?php  if($controller->postInfo) {
			$ui = $cobj->getUserObject();
			?>
			<div class="ccm-discussion-message-info">
				Posted on <?php echo date(DATE_APP_GENERIC_MDY, strtotime($cobj->getCollectionDatePublic()))?> at <?php echo date(DATE_APP_GENERIC_T, strtotime($cobj->getCollectionDatePublic()))?>
				<br/>by:
				<?php  if(ENABLE_USER_PROFILES) { ?>
					<a href="<?php echo View::url("/profile",$ui->getUserID())?>"><?php echo $ui->getUserName()?></a>
            	<?php  } else {
					$uID=($ui)?$ui->getUserID():0;
					if($ui) {
						echo $ui->getUserName();
					}
            	} ?>
			</div>
	<?php  	}
	} ?>

<?php  } ?>
</div>
<?php 
if ($paginate && $num > 0 && is_object($pl)) {
	$pl->displayPaging();
}
?>