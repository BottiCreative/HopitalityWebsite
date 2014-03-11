<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php  $c = Page::getCurrentPage(); ?>

<h4 class="ccm-discussion-guestbook-title">
	<?php 
	$u = new User();
	Loader::model('discussion_track', 'discussion');
	$dTrack = new DiscussionTrack($c);
	if ($u->isRegistered()) {
	?>

	<a href="javascript:void(0)" onclick="ccmDiscussionTrack.viewTrackOverlay('<?php echo $this->action('track')?>','<?php echo $this->action('do_track')?>','<?php echo $this->action('remove_track')?>');" style="float: right"><?php echo  ($dTrack->userIsTracking($u->getUserID())?"Stop Monitoring":"Monitor") ?></a>

	<?php  } ?>
	<?php  if ($controller->title) { ?>
		<?php echo $controller->title?>
	<?php  } else { ?>
		<?php echo t("Comments:")?>
	<?php  } ?></h4>

<?php 
$u = new User();
$uh = Loader::helper('concrete/urls');
$pkg = Package::getByHandle('discussion');
$av = Loader::helper('concrete/avatar');
foreach($posts as $p) {
	$ui = $p->getUserObject();
	$uID = $ui->getUserID();
	$userDateAdded=($ui)?$ui->getUserDateAdded():time();

	$canEdit = $p->canEdit();
	$canDelete = $p->canDelete();
	?>
	<?php  if (defined("MOBILE_THEME_IS_ACTIVE") && MOBILE_THEME_IS_ACTIVE === true) { ?>
		<table border="0" cellspacing="0" cellpadding="0" class="ccm-discussion-guestbook">
		<tr class="ccm-discussion-guestbook-line ccm-discussion-comment-level-<?php echo $p->getReplyLevel()?>">
		<td>
			<div class="ccm-discussion-guestbook-poster">
				<a name="msg<?php echo $p->getCollectionID()?>"></a><a name="<?php echo $p->getCollectionID()?>"></a>
				<?php  if(ENABLE_USER_PROFILES) { ?>
					<a href="<?php echo View::url("/profile",$ui->getUserID())?>" rel="<?php echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php echo $uID?>" class="<?php  if ($pkg->config('ENABLE_BADGES_OVERLAY') && $uID > 0) { ?>ccm-show-badges-trigger<?php  } ?>" >
					<?php echo $av->outputUserAvatar($ui);	?>
					</a>
					<div><strong><a rel="<?php echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php echo $uID?>" href="<?php echo View::url("/profile",$ui->getUserID())?>"><?php echo $ui->getUserName()?></a></strong></div>
				<?php  } else {
					$uID=($ui)?$ui->getUserID():0;
					?>
					<a rel="<?php echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php echo $uID?>"
					   class="<?php  if ($pkg->config('ENABLE_BADGES_OVERLAY') && $uID > 0) { ?>ccm-show-badges-trigger<?php  } ?>" >
					   <?php echo $av->outputUserAvatar($ui);	?>
					</a>
					<div><strong><?php  if($ui) echo $ui->getUserName()?></strong></div>
				<?php  } ?>
			</div>
			<div class="ccm-discussion-message">
				<div class="contentByLine">
					<?php echo t('Posted on')?> <?php echo $p->getCollectionDatePublic('F d, Y')?> at <?php echo $p->getCollectionDatePublic("g:i A")?>
				</div>
				<?php echo $p->getBody()?>
				<div class="contentByLine">
					<?php  if($canEdit || $canDelete) { ?>
					<div class="ccm-discussion-guestbook-manage-links">
						<?php  if ($canEdit) { ?>
							<a href="<?php echo $this->action('loadEntry')."&entryID=".$p->getCollectionID();?>#ccm-discussion-guestbook-form-<?php echo $b->getBlockID()?>"><?php echo t('Edit')?></a>
						<?php  } ?>
						<?php  if ($canEdit && $canDelete) { ?>
						|
						<?php  } ?>
						<?php  if ($canDelete) { ?>
							<a href="<?php echo $this->action('removeEntry')."&entryID=".$p->getCollectionID();?>" onclick="return confirm('<?php echo t("Are you sure you would like to remove this comment?")?>');"><?php echo t('Remove')?></a>
						<?php  }

						$cp = new Permissions($p);
						if ($cp->canAdminPage()) {
							print ' | '; ?>

							<a href="javascript:void(0)" onclick="ccmDiscussion.changePostToPage('<?php echo $uh->getToolsURL('change_post_to_page', 'discussion')?>?cID=<?php echo $p->getCollectionID()?>')"><?php echo t('Promote to Page')?></a>
						<?php  }

						?>
					</div>
					<?php  } ?>
			  </div>
			</div>
		</td>
	</tr>
</table>
	<?php   }else{?>
<table border="0" cellspacing="0" cellpadding="0" class="ccm-discussion-guestbook">
	<tr class="ccm-discussion-guestbook-line ccm-discussion-comment-level-<?php echo $p->getReplyLevel()?>">
		<td class="ccm-discussion-guestbook-threaded"></td>
		<td valign="top" class="ccm-discussion-guestbook-poster">
			<a name="msg<?php echo $p->getCollectionID()?>"></a><a name="<?php echo $p->getCollectionID()?>"></a>
			<?php  if(ENABLE_USER_PROFILES) { ?>
				<a href="<?php echo View::url("/profile",$ui->getUserID())?>" rel="<?php echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php echo $uID?>" class="<?php  if ($pkg->config('ENABLE_BADGES_OVERLAY') && $uID > 0) { ?>ccm-show-badges-trigger<?php  } ?>" >
				<?php echo $av->outputUserAvatar($ui);	?>
				</a>
				<div><strong><a rel="<?php echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php echo $uID?>" href="<?php echo View::url("/profile",$ui->getUserID())?>"><?php echo $ui->getUserName()?></a></strong></div>
			<?php  } else {
				$uID=($ui)?$ui->getUserID():0;
				?>
				<a rel="<?php echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php echo $uID?>"
				   class="<?php  if ($pkg->config('ENABLE_BADGES_OVERLAY') && $uID > 0) { ?>ccm-show-badges-trigger<?php  } ?>" >
				   <?php echo $av->outputUserAvatar($ui);	?>
				</a>
				<div><strong><?php  if($ui) echo $ui->getUserName()?></strong></div>
			<?php  } ?>
		</td>
		<td valign="top" class="ccm-discussion-message">
			<?php echo $p->getBody()?>
			<div class="contentByLine">
			<?php echo t('Posted on')?> <?php echo $p->getCollectionDatePublic('F d, Y')?> at <?php echo $p->getCollectionDatePublic("g:i A")?>

			<?php  if($canEdit || $canDelete) { ?>
				<div class="ccm-discussion-guestbook-manage-links">
					<?php  if ($canEdit) { ?>
	                	<a href="<?php echo $this->action('loadEntry')."&entryID=".$p->getCollectionID();?>#ccm-discussion-guestbook-form-<?php echo $b->getBlockID()?>"><?php echo t('Edit')?></a>
	                <?php  } ?>
	                <?php  if ($canEdit && $canDelete) { ?>
	                |
	                <?php  } ?>
	                <?php  if ($canDelete) { ?>
						<a href="<?php echo $this->action('removeEntry')."&entryID=".$p->getCollectionID();?>" onclick="return confirm('<?php echo t("Are you sure you would like to remove this comment?")?>');"><?php echo t('Remove')?></a>
					<?php  }

					$cp = new Permissions($p);
					if ($cp->canAdminPage()) {
						print ' | '; ?>

						<a href="javascript:void(0)" onclick="ccmDiscussion.changePostToPage('<?php echo $uh->getToolsURL('change_post_to_page', 'discussion')?>?cID=<?php echo $p->getCollectionID()?>')"><?php echo t('Promote to Page')?></a>
					<?php  }


					?>
                </div>
			<?php  } ?>


			</div>

		</td>
	</tr>
</table>
<?php  } ?>
<?php  } ?>


<?php 

if (is_object($error) && $error->has()) {
	print $error->output();
}

 if ($_REQUEST['method'] == 'discussion_comment_posted') {
 	// display appropriate success message
 	if($u->isRegistered()) {
 		?><strong><?php echo t('Your comment has been posted.')?></strong><br/><?php 
 	} elseif($enableAnonymous) {
 		?><strong><?php echo t('Your comment has been saved and will be published after approval by the moderator.')?></strong><br/><?php 
 	}
} ?>

<?php  if($controller->displayGuestBookForm) { ?>
	<?php 
	if( !$u->isRegistered() && !$enableAnonymous ){ ?>
		<div><?php echo t('You must be logged in to leave a reply.')?> <a href="<?php echo View::url("/login","forward",$c->getCollectionID())?>"><?php echo t('Login')?> &raquo;</a></div>
	<?php  }else{ ?>
		<a name="ccm-discussion-guestbook-form-<?php echo $controller->bID?>"></a>
		<div id="ccm-discussion-guestbook-form-block-<?php echo $controller->bID?>" class="ccm-discussion-guestbook-form-block">
			<form method="post" action="<?php echo $this->action('form_save_entry', '#ccm-discussion-guestbook-form-block-'.$controller->bID)?>">
			<?php  if(isset($entryID)) { ?>
				<input type="hidden" name="entryID" value="<?php echo $entryID?>" />
			<?php  } ?>

         <?php  if ($u->isRegistered()) {
            $greeting = t('You are currently logged in as %s', $u->getUserName());
          } else {
            $greeting = t('Post anonymously or ').'<a href="'.View::url("/login","forward",$c->getCollectionID()).'">'.t('sign in').'</a>'.t(' first.');
          }
          echo $greeting;?>
			<br/>
			<h2><?php echo t('Leave a Reply')?></h2>
			<?php echo Loader::helper('form')->textarea('discussionGuestbookBody', $entryBody)?>
			<br/>

         <?php  if ($controller->captcha_enabled(!$u->isRegistered())) {
               $captcha = Loader::helper('validation/captcha');
               echo $captcha->display();
               echo '<br/><br/>';
               echo $captcha->showInput();
            }?>

			<input type="submit" name="Post Comment" value="<?php echo t('Post Comment')?>" />
			</form>
		</div>
	<?php  } ?>
<?php  } ?>
