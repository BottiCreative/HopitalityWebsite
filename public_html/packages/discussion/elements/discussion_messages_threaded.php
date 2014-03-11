<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php   $textHelper = Loader::helper("text"); ?>
<?php   $u = new User(); ?>
<?php   $pkg = Package::getByHandle('discussion'); ?>
<?php   $uh = Loader::helper('concrete/urls');

$postOverlay = false;
if ($pkg->config('GLOBAL_POSTING_METHOD') == 'overlay') {
	$postOverlay = true;
}

?>
<div class="ccm-discussion-messages">

<?php   $ru = $topic->getUserObject(); ?>

<div class="ccm-discussion-main-message">
	
	<?php   if (is_object($ru)) { ?>
	<div class="u-avatar-box">
		<?php  if($ru->getUserID() > 0) { ?>
		<a href="<?php  echo View::url('/profile',$ru->getUserID())?>" 
		   rel="<?php  echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php  echo $ru->getUserID()?>" 
		   class="<?php   if ($pkg->config('ENABLE_BADGES_OVERLAY')) { ?>ccm-show-badges-trigger<?php   } ?>">
			<?php  echo  $av->outputUserAvatar($ru); ?>
		</a>
		<br />
		<a href="<?php  echo View::url('/profile',$ru->getUserID())?>"><?php  echo  $ru->getUserName(); ?></a>
		<?php  } else { 
			echo  $av->outputUserAvatar($ru);
			echo "<br />";
			echo  $ru->getUserName();
		} ?>
		<div class="spacer"></div>
	</div>
	<?php   } ?>
	
<h1><?php  echo $topic->getCollectionName()?></h1>
<div class="ccm-discussion-post-time">
	<?php  echo date(DATE_APP_GENERIC_MDY_FULL, strtotime($topic->getCollectionDatePublic()))?> at <?php  echo date(DATE_APP_GENERIC_T, strtotime($topic->getCollectionDatePublic()))?>
	<?php 
	if($topic->getAttribute('discussion_post_locale')) { 
		Loader::model('section','multilingual');
		$postLocale = $topic->getAttribute('discussion_post_locale');
		if(strlen($postLocale)) { 
			$s = MultilingualSection::getByLocale($postLocale);
			if($s instanceof MultilingualSection) { ?>
				<span class="ccm-discussion-message-locale"><?php  echo t('while using %s interface',$s->getLanguageText())?></span>
			<?php  }
		} 
	} ?>
</div>

<p><?php  echo $topic->getBody()?></p>

<?php   $a = new Area('Attachments'); 
$attachments = $a->getAreaBlocksArray($topic);
if (count($attachments) > 0) { ?>
<div class="ccm-discussion-message-attachments">
	<?php  echo t('Attachments')?>:
	<?php   $a->display($topic); ?>
</div>
<?php   } ?>
<?php  if(!$isReply) { ?>
	<div class="ccm-discussion-message-tags">
		<?php 
		$value = $topic->getAttribute(DISCUSSION_POST_TAG_HANDLE);
		if ($value instanceof Iterator && count($value)) { ?>
			<span><?php  echo t('Tags:') ?></span>
			<?php  
			$tlist = '';
			foreach($value as $tag) {
				$tlist .= $tag.", ";
			}
			echo substr($tlist,0,-2);
		}
		?>
	</div>
<?php  } ?>
<div class="ccm-spacer"></div>
<div class="ccm-discussion-message-info">		
<?php  
	$canPost = false;
	if($u->isRegistered()) {
		$canPost = true;
	} else { 
		$dc = Loader::helper('discussion_config','discussion');	
		$dpm = DiscussionPostModel::load($this->getCollectionObject());
		$d = $dpm->getDiscussion();
		$canPost = $dc->anonPostRepliesEnabled($d);
		/*
		$pkg = Package::getByHandle('discussion');
		if($pkg->config('ENABLE_ANON_POSTING_REPLIES')) { // add paackage config value here
			$canPost = true;
		}
		*/
	}
	if (!$canPost) {
		$startDiscussionAction = 'location.href=\'' . View::url('/login', 'forward', $this->getCollectionObject()->getCollectionID()) . '\';';
	} else {
		if ($postOverlay) {
			$uID = $u->isRegistered() ? $u->getUserID() : 0;
			$startDiscussionAction = 'ccmDiscussion.postOverlay(' . $topic->getCollectionID() . ', ' . $uID . ')';
		} else {
			$startDiscussionAction = 'ccmDiscussion.postForm(' . $topic->getCollectionID() . ')';
		}	
	}

?>
	<a href="javascript:void(0)" onclick="<?php  echo $startDiscussionAction?>"><?php echo t('Reply')?></a>

	<?php  
	if($topic->canEdit()){ ?>
		|
		<a href="javascript:void(0)" onclick="ccmDiscussion.editReply('<?php  echo $uh->getToolsURL('reply_form', 'discussion')?>?replyCID=<?php  echo $topic->getCollectionID()?>&pCID=<?php  echo $topic->getCollectionParentID()?>', <?php  echo $postOverlay ? 1 : 0?>)"><?php echo t('Edit')?></a>
	<?php   } 
	
	
	if($topic->canDelete()) { ?>
		|
		<a href="javascript:void(0)" onclick="ccmDiscussion.deletePost('<?php  echo $uh->getToolsURL('delete_post', 'discussion')?>?cID=<?php  echo $topic->getCollectionID()?>')"><?php echo t('Delete')?></a>
	<?php   }
	
	$cp = new Permissions($topic);
	if ($cp->canAdminPage() && !defined('MOBILE_THEME_IS_ACTIVE')) {
		print ' | '; ?>
		
		<a href="javascript:void(0)" onclick="ccmDiscussion.changePostToPage('<?php  echo $uh->getToolsURL('change_post_to_page', 'discussion')?>?cID=<?php  echo $topic->getCollectionID()?>')"><?php  echo t('Promote to Page')?></a>
	<?php   } 
	?>


</div>


</div>

<div class="ccm-discussion-replies">
<?php   Loader::packageElement('discussion_replies_bar', 'discussion', array('replies' => $topic->getTotalReplies(), 'mode' => 'threaded'));?>
<?php  
foreach($replies as $r) { 
	$ru = $r->getUserObject();
	?>
	<a name="msg<?php  echo $r->getCollectionID()?>"></a>
	<div class="ccm-discussion-threaded-comment">
		<div class="ccm-discussion-comment-wrapper ccm-discussion-comment-level-<?php  echo $r->getReplyLevel()?>">
			<div class="u-avatar-box">
				<?php  if($ru->getUserID() > 0) {?>
					<a href="<?php  echo View::url('/profile',$ru->getUserID())?>" 
					   rel="<?php  echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php  echo $ru->getUserID()?>" 
					   class="<?php   if ($pkg->config('ENABLE_BADGES_OVERLAY')) { ?>ccm-show-badges-trigger<?php   } ?>">
						<?php  echo  $av->outputUserAvatar($ru); ?>
					</a>
					<br />
					<a href="<?php  echo View::url('/profile',$ru->getUserID())?>"><?php  echo  $ru->getUserName(); ?></a>
				<?php  } else { // anonymous poster ?>
					<?php  echo  $av->outputUserAvatar($ru); ?>
					<br />
					<?php  echo  $ru->getUserName(); ?>
				<?php  } ?>
				<div class="ccm-spacer"></div>
			</div>
			<h3><?php  echo ($canAdmin?"<a href=\"".View::url($r->getCollectionPath())."\" class=\"command\">".$r->getSubject()."</a>":$r->getSubject());?></h3>
			<div class="ccm-discussion-post-time">
				<?php  echo date(DATE_APP_GENERIC_MDY_FULL, strtotime($r->getCollectionDatePublic()))?> at <?php  echo date(DATE_APP_GENERIC_T, strtotime($r->getCollectionDatePublic()))?>
				<?php 
				if($r->getAttribute('discussion_post_locale')) { 
					Loader::model('section','multilingual');
					$postLocale = $r->getAttribute('discussion_post_locale');
					if(strlen($postLocale)) { 
						$s = MultilingualSection::getByLocale($postLocale);
						if($s instanceof MultilingualSection) { ?>
							<span class="ccm-discussion-message-locale"><?php  echo t('while using %s interface',$s->getLanguageText())?></span>
						<?php  }
					} 
				} ?>
			</div>
			<div class="ccm-discussion-post-body"> 
				<?php  echo $r->getHTMLBody(); ?>
				<?php   $a = new Area('Attachments'); 
				$attachments = $a->getAreaBlocksArray($r);
				if (count($attachments) > 0) { ?>
				<div class="ccm-discussion-message-attachments">
					<?php  echo t('Attachments')?>:
					<?php   $a->display($r); ?>
				</div>
				<?php   } ?>

				<?php   //if ($u->isRegistered()) { 
				?>
					<div class="ccm-discussion-message-info">
						<?php  
							if (!$u->isRegistered()) {
								$startDiscussionAction = 'location.href=\'' . View::url('/login', 'forward', $this->getCollectionObject()->getCollectionID()) . '\';';
							} else {
								if ($postOverlay) {
									$uID = $u->isRegistered() ? $u->getUserID() : 0;
									$startDiscussionAction = 'ccmDiscussion.postOverlay(' . $r->getCollectionID() . ', ' . $uID . ')';
								} else {
									$startDiscussionAction = 'ccmDiscussion.postForm(' . $r->getCollectionID() . ')';
								}	
							}
						?>

						<a href="javascript:void(0)" onclick="<?php  echo $startDiscussionAction?>"><?php echo t('Reply')?></a>

						<?php  
						if($r->canEdit()){ ?>
							|
							<a href="javascript:void(0)" onclick="ccmDiscussion.editReply('<?php  echo $uh->getToolsURL('reply_form', 'discussion')?>?replyCID=<?php  echo $r->getCollectionID()?>&pCID=<?php  echo $r->getCollectionParentID()?>', <?php  echo $postOverlay ? 1 : 0?>)"><?php echo t('Edit')?></a>
						<?php   } 
						
						
						if($r->canDelete()) { ?>
							|
							<a href="javascript:void(0)" onclick="ccmDiscussion.deletePost('<?php  echo $uh->getToolsURL('delete_post', 'discussion')?>?cID=<?php  echo $r->getCollectionID()?>')"><?php echo t('Delete')?></a>
						<?php   }
						
						$cp = new Permissions($r);
						if ($cp->canAdminPage() && !defined('MOBILE_THEME_IS_ACTIVE')) {
							print ' | '; ?>
							
							<a href="javascript:void(0)" onclick="ccmDiscussion.changePostToPage('<?php  echo $uh->getToolsURL('change_post_to_page', 'discussion')?>?cID=<?php  echo $r->getCollectionID()?>')"><?php  echo t('Promote to Page')?></a>
						<?php   } 
						?>


					</div>
				<?php   //} 
				?>
			</div>
			<div class="ccm-spacer">&nbsp;</div>
		</div>
	</div>

<?php   } ?>		

</div>
</div>