<?php  defined( 'C5_EXECUTE' ) or die( _( "Access Denied." ) ); ?>
<?php  $textHelper = Loader::helper( "text" ); ?>
<div class="ccm-discussion-messages">

<table border="0" cellspacing="0" cellpadding="0" class="ccm-discussion-message-list">
<tr>
	<th colspan="2" style="white-space: normal">
	<?php  echo $messageList->displaySummary()?>
	<?php  echo $topic->getCollectionName()?>
	</th>
</tr>
<?php 
$pkg = Package::getByHandle( 'discussion' );
$uh = Loader::helper( 'concrete/urls' );
$messages = $messageList->getPage();
$av = Loader::helper( 'concrete/avatar' );
$postOverlay = false;
if ( $pkg->config( 'GLOBAL_POSTING_METHOD' ) == 'overlay' ) {
	$postOverlay = true;
}
$i = 1;
foreach ( $messages as $cat ) {
	$ui = $cat->getUserObject();
	$userDateAdded=( $ui )?$ui->getUserDateAdded():time();
	if ( is_object( $ui ) ) {
		$uID = $ui->getUserID();
	}
	$isReply = ( $cat->getCollectionID() == $topic->getCollectionID()?false:true );
?>
	<tr <?php  if ( $cat->getCollectionID() == $topic->getCollectionID() ) { ?> class="ccm-discussion-topic" <?php  } ?>>
		<td valign="top">
		<?php  if ( is_object( $ui ) ) { ?>

		<a name="msg<?php  echo $cat->getCollectionID()?>"></a>
		<a name="<?php  echo $cat->getCollectionID()?>"></a>
		<?php  if ( ENABLE_USER_PROFILES && $ui->getUserID() > 0 ) { ?>
			<h4><a href="<?php  echo View::url( "/profile", $ui->getUserID() )?>"><?php  echo $ui->getUserName()?></a></h4>
			<a href="<?php  echo View::url( "/profile", $ui->getUserID() )?>" class="<?php  if ( $pkg->config( 'ENABLE_BADGES_OVERLAY' )  && $ui->getUserID()>0 ) { ?>ccm-show-badges-trigger<?php  } ?>" rel="<?php  echo Loader::helper( 'concrete/urls' )->getToolsURL( 'get_badges_content', 'discussion' )?>?uID=<?php  echo $uID?>" >
			   	<?php  echo ( $av && $ui ) ? $av->outputUserAvatar( $ui ) : ''; ?>
			</a>
		<?php  } else {
			$uID=( $ui )?$ui->getUserID():0;
?>
			<h4><?php  if ( $ui ) echo $ui->getUserName()?></h4>
			<a rel="<?php  echo Loader::helper( 'concrete/urls' )->getToolsURL( 'get_badges_content', 'discussion' )?>?uID=<?php  echo $uID?>"
			   class="<?php  if ( $pkg->config( 'ENABLE_BADGES_OVERLAY' )  && $ui->getUserID()>0 ) { ?>ccm-show-badges-trigger<?php  } ?>" >
			   <?php  echo ( $av && $ui ) ? $av->outputUserAvatar( $ui ) : ''; ?>
			</a>
		<?php  } ?>
		<div><strong><?php  echo t( 'Total Posts:' )?></strong> <?php  if ( $ui ) echo $ui->getUserDiscussionTotalPosts()?></div>
		<div><strong><?php  echo t( 'Joined:' )?></strong> <?php  echo date( DATE_APP_GENERIC_MDY_FULL, strtotime( $userDateAdded ) )?></div>
		<?php  } ?>

		</td>
		<td valign="top" class="ccm-discussion-message">
		<?php  if ( $cat->getCollectionID() != $topic->getCollectionID() ) { ?>
			<h3><?php  echo $cat->getCollectionName()?></h3>
		<?php  } ?>

		<p><?php  echo $cat->getBody()?></p>
		<?php  if ( !$isReply ) { ?>
		<div class="ccm-discussion-message-tags">
			<?php 
		$value = $topic->getAttribute( DISCUSSION_POST_TAG_HANDLE );
		if ( $value instanceof Iterator && count( $value ) ) { ?>
				<span><?php  echo t( 'Tags:' ) ?></span>
				<?php 
			$tlist = '';
			foreach ( $value as $tag ) {
				$tlist .= $tag.", ";
			}
			echo substr( $tlist, 0, -2 );
		}
?>
		</div>
		<?php  } ?>
		<div class="ccm-discussion-message-attachments">
		<?php  $a = new Area( 'Attachments' );
	$attachments = $a->getAreaBlocksArray( $cat );
	if ( count( $attachments ) > 0 ) { ?>
			<?php  echo t( 'Attachments' )?>:
		<?php  }
	$a->display( $cat ); ?>
		</div>

		<div class="ccm-discussion-message-info">
		<?php  echo t( 'Posted on %s at %s', date( DATE_APP_GENERIC_MDY_FULL, strtotime( $cat->getCollectionDatePublic() ) ), date( DATE_APP_GENERIC_T, strtotime( $cat->getCollectionDatePublic() ) ) )?>

		<?php 
	if ( $cat->getAttribute( 'discussion_post_locale' ) ) {
		Loader::model( 'section', 'multilingual' );
		$postLocale = $cat->getAttribute( 'discussion_post_locale' );
		if ( strlen( $postLocale ) ) {
			$s = MultilingualSection::getByLocale( $postLocale );
			if ( $s instanceof MultilingualSection ) { ?>
					<span class="ccm-discussion-message-locale"><?php  echo t( 'while using %s interface', $s->getLanguageText() )?></span>
				<?php  }
		}
	} ?>

		<?php 
	if ( $cat->canEdit() ) { ?>
			<a href="javascript:void(0)" onclick="ccmDiscussion.editReply('<?php  echo $uh->getToolsURL( 'reply_form', 'discussion' )?>?isReply=<?php  echo $isReply?1:0?>&replyCID=<?php  echo $cat->getCollectionID()?>&pCID=<?php  echo $cat->getCollectionParentID()?>', <?php  echo $postOverlay ? 1 : 0?>)"><?php  echo t( 'Edit' )?></a>
		<?php  }

	if ( $cat->canEdit() && $cat->canDelete() ) {
		print ' | ';
	}

	if ( $cat->canDelete() ) { ?>
			<a href="javascript:void(0)" onclick="ccmDiscussion.deletePost('<?php  echo $uh->getToolsURL( 'delete_post', 'discussion' )?>?cID=<?php  echo $cat->getCollectionID()?>')"><?php  echo t( 'Delete' )?></a>
		<?php  }

	$cp = new Permissions( $cat );
	if ( $cp->canAdminPage() ) {
		print ' | '; ?>
			<a href="javascript:void(0)" onclick="ccmDiscussion.changePostToPage('<?php  echo $uh->getToolsURL( 'change_post_to_page', 'discussion' )?>?cID=<?php  echo $cat->getCollectionID()?>')"><?php  echo t( 'Promote to Page' )?></a>
			<?php 
	} ?>

		</div>
		</td>

	</tr>
	<?php  if ( $cat->getCollectionID() == $topic->getCollectionID() ) { ?>
	<tr>
		<td class="ccm-discussion-replies" colspan="2">
			<?php  Loader::packageElement( 'discussion_replies_bar', 'discussion', array( 'mode' => 'flat', 'replies' => $topic->getTotalReplies() ) );?>
		</td>
	</tr>
	<?php  } ?>
<?php  } ?>
</table>

<?php  $messageList->displayPaging()?>

</div>
