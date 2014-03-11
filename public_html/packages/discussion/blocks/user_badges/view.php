<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
if (is_object($this->area) && $this->area->getAttribute('profile')) {
	$profile = $this->area->getAttribute('profile');
} else {
	$profile = UserInfo::getByID($byUserID);
}

if($profile instanceof UserInfo) {
	$badges = $this->controller->getBadges($profile);
} else {
	$badges = array();
}
?>

<h2><?php echo t('Badges')?></h2>

<?php 

if (count($badges) == 0) { ?>
	<?php echo t("This user hasn't earned any badges yet.")?>
<?php  } else { ?>
<table class="ccm-discussion-message-list" border="0" cellspacing="0" cellpadding="0">
<?php 
foreach($badges as $badge) { ?>
<tr>
	<td><?php echo $badge->getBadgeIcon();?></td>
	<td style="white-space: nowrap"><strong><?php echo $badge->getBadgeName()?></strong></td>
	<td class="ccm-discussion-message"><?php echo $badge->getBadgeDescription()?></td>
</tr>
<?php  } ?>
</table>
<?php  } ?>
