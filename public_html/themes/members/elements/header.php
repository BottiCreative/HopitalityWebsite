<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">

<head>

<?php   Loader::element('header_required'); ?>

<!-- Site Header Content //-->


<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />
<link rel="stylesheet" href="<?php  echo $this->getThemePath(); ?>/css/foundation.css"/>
<script src="<?php  echo $this->getThemePath(); ?>/js/modernizr.js"></script>

<link href='http://fonts.googleapis.com/css?family=Raleway:400,800' rel='stylesheet' type='text/css'>

</head>

<body class="fitvid">

		<div class="sideStripNav">
        
        
			<ul class="tt-wrapper">
				<li><a class="he-home" href="<?php echo DIR_REL; ?>/profile"><span>Home</span></a></li>
				<li><a class="he-resources" href="<?php echo DIR_REL; ?>/profile/resources/"><span>Resources</span></a></li>
				<li><a class="he-blog" href="<?php echo DIR_REL; ?>/profile/members-blog/"><span>Blog</span></a></li>
				<li><a class="he-forum" href="<?php echo DIR_REL; ?>/profil/forum/"><span>Forum</span></a></li>

			</ul>
            
       
            
            
            <div class="sideMemebersNav">
            <ul class="tt-wrapper footericonNav">
				<li><a class="he-logout" href="<?php echo DIR_REL; ?>/profile/support"><span>Support</span></a></li>
				<li><a class="he-support" href="<?php echo DIR_REL; ?>/login/logout/"><span>Log Out</span></a></li>
			</ul>
            </div>
            
            

        </div>






