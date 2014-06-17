<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">

<head>

<?php   Loader::element('header_required'); ?>

<!-- Site Header Content //-->


<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />
<link rel="stylesheet" href="<?php  echo $this->getThemePath(); ?>/css/foundation.css"/>
<link rel="stylesheet" href="<?php  echo $this->getThemePath(); ?>/css/reveal-modal.css"/>
<script src="<?php  echo $this->getThemePath(); ?>/js/modernizr.js"></script>

<link href='http://fonts.googleapis.com/css?family=Raleway:400,800' rel='stylesheet' type='text/css'>



</head>

<body class="fitvid">


<div class="fullwidthnav">
	<div class="row">
    	<div class="grid-2 columns logo">
        	<a href="<?php echo DIR_REL?>/"><img src="<?php  echo $this->getThemePath(); ?>/images/Hospitality Entrepreneur Logo.png" alt="Hospitality Entrepreneur"/></a>
        </div>
        <div class="grid-8 columns nopad">
        	<?php  
		$a = new GlobalArea('Header Nav');
		$a->display();
		?>
        </div>
        <div class="grid-2 columns nopad topLinks">
        
        <?php 
        
        $currentUser = new User();
        
       	if($currentUser->isLoggedIn())
		{
			//get the userinfo object for this user.
			$currentUserInfo = UserInfo::getByID($currentUser->getUserID());
			$welcomeName = 	$currentUserInfo->getAttribute('billing_first_name');
			if(!isset($welcomeName))
			{
				$welcomeName = $currentUser->getUserName();
			}
		
        
		?>
		<p class="welcome">Hi <?php echo $welcomeName; ?> </p>
		<a href="/profile" class="loginLink">View My Profile</a>
		
		<?php
		}
		else
		{
		
		?>	
		
		<a href="/login" class="loginLink">Login</a>
        <a href="/login" class="registerLink">Register</a>
		
		<?php
		}
		?>

        </div>
    </div>
</div>




