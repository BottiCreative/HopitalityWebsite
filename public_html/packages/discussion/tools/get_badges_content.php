<?php 
$t = Loader::helper('text');
Loader::model('discussion_badge', 'discussion');
Loader::model('userinfo');
Loader::model('anonymous_user','discussion');

$userID=intval($_REQUEST['uID']);
if($userID > 0) {
	$profile = UserInfo::getByID($userID); 
	$u = $profile->getUserObject();
} else {
	$profile = new AnonymousUserInfo();
	$u = $profile->getUserObject();
}
?>
<h2><?php echo $profile->getUserName();?></h2>

<div class="profile-preview-badges">
	<?php echo DiscussionBadge::getBadgesHTML( $u , 1 ) ?>
</div>

<div class="profile-preview-info">
	<div><label><?php echo t('Date Joined')?>:</label> <?php echo date("m/d/y",strtotime($profile->getUserDateAdded()));?>  </div> 
	<?php 
	$bio=$t->shortText($t->makenice($profile->getUserBio()), 55);
	if( strlen($bio) ){ ?>
		<div><label><?php echo t('Bio')?>:</label> <?php echo $bio ?></div>
	<?php  } ?>
</div>

<?php  if(ENABLE_USER_PROFILES) { ?>
<div class="profile-preview-links"> 
	<a href="<?php echo View::url("/profile",$userID)?>"><?php echo t('View Profile')?> &gt;</a>
</div>
<?php  } ?>

<div class="spacer"></div>