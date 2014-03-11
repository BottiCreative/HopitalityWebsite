<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));
?>
<h2><?php     echo t('Latest Comments')?></h2>
<?php     
if(is_array($entries)){
	$blogify = Loader::helper('blogify','problog');
	foreach($entries as $entry){
		//var_dump($entry);
		extract($entry);
		if($uID){
			Loader::model('userinfo');
			$ui = UserInfo::getByID($uID);
			$avatar = $blogify->getPosterAvatar($uID,32);
			echo '<p><div style="float: left; margin-right: 8px;">'.$avatar.'</div><a href="/profile/view/'.$uID.'/">'.$ui->getUserName().': </a> '.$commentText.'</p>';
		}else{
			echo '<p><div style="float: left; margin-right: 8px;" class="guest_avatar"></div>Guest: '.$commentText.'</p>';
		}
		$link = Loader::helper('navigation')->getLinkToCollection(Page::getByID($cID));
		echo '<a href="'.$link.'">'.$link.'</a>';
	}

}else{
	echo $entries;
}
?>