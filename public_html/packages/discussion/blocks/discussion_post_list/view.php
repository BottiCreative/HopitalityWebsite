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

if (count($cArray) > 0) { ?>
	<div class="ccm-discussion-messages">
	
	<table border="0" cellspacing="0" cellpadding="0" class="ccm-discussion-message-list">
	<?php 
	$nh = Loader::helper("navigation");
	$av = Loader::helper('concrete/avatar');
	for ($i = 0; $i < count($cArray); $i++ ) {
		$cobj = $cArray[$i]; 
		$cat = DiscussionPostModel::load($cobj);
		$ui = $cat->getUserObject();
		$uID = $ui->getUserID();
		$pkg = Package::getByHandle('discussion');
		$userDateAdded=($ui)?$ui->getUserDateAdded():time();
		$post = $cat->getPost();
		
		?>
	<tr>
		<td valign="top" style="vertical-align: top !important" >
		<a name="msg<?php echo $cat->getCollectionID()?>"></a>
		<?php  if(ENABLE_USER_PROFILES && $ui->getUserID() > 0) { ?>
        	<h4><a href="<?php echo View::url("/profile",$ui->getUserID())?>"><?php echo $ui->getUserName()?></a></h4>
           <a href="<?php echo View::url("/profile",$ui->getUserID())?>" class="<?php  if ($pkg->config('ENABLE_BADGES_OVERLAY') && $ui->getUserID() > 0) { ?>ccm-show-badges-trigger<?php  } ?>" rel="<?php echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php echo $uID?>" >
			   		<?php echo ($av && $ui) ? $av->outputUserAvatar($ui) : '';	?>
			</a>
		<?php  } else { 
			$uID=($ui)?$ui->getUserID():0;
			?>
            <h4><?php  if($ui) echo $ui->getUserName()?></h4>
            <a rel="<?php echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php echo $uID?>" 
			   class="<?php  if ($pkg->config('ENABLE_BADGES_OVERLAY') && $uiD > 0) { ?>ccm-show-badges-trigger<?php  } ?>" >
			   <?php echo ($av && $ui) ? $av->outputUserAvatar($ui) : '';	?>
			</a>
		<?php  } ?>        
		<div><strong><?php echo t('Total Posts:')?></strong> <?php  if($ui) echo $ui->getUserDiscussionTotalPosts()?></div>
		<div><strong><?php echo t('Joined:')?></strong> <?php echo date(DATE_APP_GENERIC_MDY_FULL, strtotime($userDateAdded))?></div>
		</td>
		<td valign="top" style="vertical-align: top !important" class="ccm-discussion-message">
		
		<h3 class="ccm-discussion-post-list-title"><a href="<?php  echo $nh->getLinkToCollection($post)?>#msg<?php   echo $cobj->getCollectionID();?>"><?php  echo $cat->getSubject()?></a></h3>
		 
		<p>
		<?php  
			Loader::library('3rdparty/bbcode');
			$bb = new Simple_BB_Code(); 	
			if(!$controller->truncateSummaries){
				echo BbcodeBlockController::addEmoticons($bb->parse($cobj->getCollectionDescription()));
			}else{
				echo BbcodeBlockController::addEmoticons($bb->parse($textHelper->shorten($cobj->getCollectionDescription(),$controller->truncateChars)));
			}
			?>
		</p>
		
		<div class="ccm-discussion-message-info">
		Posted on <?php echo date(DATE_APP_GENERIC_MDY_FULL, strtotime($cat->getCollectionDatePublic())) . ' at ' . date(DATE_APP_GENERIC_T, strtotime($cat->getCollectionDatePublic()))?>
		</div>
		
		</td>

	</tr>	
	<?php  } ?>
	</table>
	</div>
<?php   }
if ($paginate && $num > 0 && is_object($pl)) {
	$pl->displayPaging();
}
?>
</div>