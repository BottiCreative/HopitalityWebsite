<?php       $av = Loader::helper('concrete/avatar'); ?>
<?php     
$nh = Loader::helper('navigation');
$txt = Loader::helper('text');
$co = new Config;
$pkg = Package::getByHandle('problog');
$co->setPackageObject($pkg);
$problog_root = Page::getByID($co->get("USER_BLOGS_PARENT_PAGE"));
$problog_format = $co->get("USER_BLOG_PAGE_PATH_FORMAT");
$u = new User();
if($u->isLoggedIn()){
	switch ($problog_format) {
		case 'username':
			$path_end = $profile->getUserName();
			break;
		case 'userid':
			$path_end = $profile->getUserID();
			break;
		case 'personname':
		default:
			$name = $profile->getUserFirstName() . " " . $profile->getUserLastName() ;
			$path_end = $txt->sanitizeFileSystem($name);
			break;
	}
	$user_blog_path = $nh->getLinkToCollection($problog_root).$path_end.'/';
	//var_dump($user_blog_path);
}
?>
<div id="ccm-profile-sidebar">
	<div class="ccm-profile-header">
		<a href="<?php      echo View::url('/profile',$profile->getUserID())?>"><?php      echo  $av->outputUserAvatar($profile)?></a><br />
		<a href="<?php      echo View::url('/profile',$profile->getUserID())?>"><?php      echo  $profile->getUsername()?></a>
	</div>
	<div style="margin-top:16px; padding-bottom:4px; margin-bottom:0px; font-weight:bold"><?php      echo t('Member Since')?></div>
	<?php      echo date(DATE_APP_GENERIC_MDY_FULL, strtotime($profile->getUserDateAdded('user')))?>
	
	<?php       
	$u = new User();
	if ($u->isRegistered() && $u->getUserID() != $profile->getUserID()) { ?>
	<div style="margin-top:16px;">
		<div>
		<?php       if( !UsersFriends::isFriend( $profile->getUserID(), $u->uID ) ){ ?>
			<a href="<?php      echo View::url('/profile/friends','add_friend', $profile->getUserID())?>">
				<?php      echo t('Add to My Friends') ?>
			</a>
		<?php       }else{ ?>
			<a href="<?php      echo View::url('/profile/friends','remove_friend', $profile->getUserID() )?>">
				<?php      echo t('Remove from My Friends') ?>
			</a>
		<?php       } ?>
		
		</div>
		<?php       if ($profile->getUserProfilePrivateMessagesEnabled() == 1) { ?>
			<a href="<?php      echo $this->url('/profile/messages', 'write', $profile->getUserID())?>"><?php      echo t('Send Private Message')?></a>	
		<?php       } ?>
		<a href="<?php     echo $user_blog_path?>" alt="view user's blog"><?php     echo t('View Blog')?></a>
	</div>
	<?php       } ?>

	<div>
	<?php       
	if($u->getUserID() == $profile->getUserID()) {
		$nc = Page::getByPath('/profile');
		$bt = BlockType::getByHandle('autonav');
		$bt->controller->displayPages = 'custom';
		$bt->controller->displayPagesCID = $nc->getCollectionID();
		$bt->controller->orderBy = 'display_asc';
		$bt->controller->displaySubPages = 'all';
		$bt->controller->displaySubPageLevels = '1';
		$bt->controller->displaySystemPages = true;
		$bt->render('view');
	}
	?>
	<?php    
	$tp = PermissionKey::getByHandle('problog_post');
	if ($u->isSuperUser() || $tp->can()){
		echo '<a href="'.BASE_URL.DIR_REL.'/problog_editor">'.t('Manage My Blog Posts').'</a>';
	}
	?>
	</div>

		<form method="get" action="<?php      echo $this->url('/members')?>">
		<h4><?php      echo t('Search Members')?></h4>
		<?php      
		$form = Loader::helper('form');
		print $form->text('keywords', array('style' => 'width: 80px'));
		print '&nbsp;&nbsp;';
		print $form->submit('submit', t('Search'));
		?>
		
		</form>

</div>