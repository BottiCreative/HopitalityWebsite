<?php 
ini_set('display_errors', 1); 
ini_set('error_reporting', 1);
error_reporting(E_ALL ^ E_NOTICE); 
 
Loader::model('discussion_badge', 'discussion');
Loader::model('userinfo');
$ih = Loader::helper('concrete/interface');
 
$ui = UserInfo::getByID( intval($_REQUEST['uID']) ); 
$u=$ui->getUserObject();
$availablebadges=DiscussionBadge::getAvailableBadges(); 
 
if( $_POST['badges_submitted'] && $ui && DiscussionBadge::canAdminBadges() ){ 
	foreach($availablebadges as $badge){
		$gID=$badge->getBadgeGroupID();
		
		$g = Group::getByID($gID);
		if(!$g) continue;
		
		$key = 'badgeID_'.$g->getGroupID();
		if( $_POST[$key]==1 ){  
			$u->enterGroup($g);
		}else{  
			$u->exitGroup($g);
		}
	}
	$u->refreshUserGroups();
	$badgesSaved=1;
} 

$usersBadges=DiscussionBadge::getBadges($u); 
?>
<h2 style="font-size:18px"><?php echo t("User's Badges")?></h2>
<div class="ccm-spacer"></div>

<?php  if($badgesSaved){ ?>
<div style="background:#FFFF99; border:1px solid #ccc; padding:4px; margin:16px;">
	<?php echo t('Badges saved!  Refreshing page.') ?>
</div>
<?php  } ?>

<form id="edit-users-badges" onsubmit="return ccmDiscussionBadges.saveBadges(this)" action="<?php echo Loader::helper('concrete/urls')->getToolsURL('manage_badges','discussion')?>">
	<input name="uID" type="hidden" value="<?php echo intval($_REQUEST['uID'])?>" />
	<input name="badges_submitted" type="hidden" value="1" />
	<?php 
	foreach($availablebadges as $badge) {
		$badgeFound=0;
		if(in_array($badge,$usersBadges))
			$badgeFound=1;
		echo '<div style="margin-bottom:16px;">';
			echo '<div style="float:left; margin-right:8px; width:40px; ">'.$badge->getBadgeIcon().'</div>';
			echo '<div style="float:left; width:300px;">';
				echo '<input name="badgeID_'.$badge->getBadgeGroupID().'" type="checkbox" value="1" '.($badgeFound?'checked':'').' />';
				//echo '<strong>'.$badge->getBadgeName().'</strong>';			
				echo ''.$badge->getBadgeDescription().'';		
			echo '</div>';
			echo '<div class="ccm-spacer"></div>';
		echo '</div>';
	}
	?>
	
	<div style="margin-top:16px; margin:auto; text-align:center; width:110px;"> 
		<?php echo $ih->button_js(t('Save Changes'), "ccmDiscussionBadges.saveBadges($('#edit-users-badges').get(0))", 'left')?>
	</div>
</form>