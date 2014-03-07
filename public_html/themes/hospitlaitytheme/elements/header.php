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

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

</head>

<body class="fitvid">


<div class="fullwidthnav">
	<div class="row">
    	<div class="grid-2 columns logo">
        	<a href="<?php echo DIR_REL?>/"><img src="<?php  echo $this->getThemePath(); ?>/images/Hospitality Entrepreneur Logo.png" alt="Hospitality Entrepreneur"/></a>
        </div>
        <div class="grid-9 columns">
        	<?php  
		$a = new GlobalArea('Header Nav');
		$a->display();
		?>
        </div>
        <div class="grid-1 columns nopad">
        
        <a href="/login" class="loginLink">Login</a>

        </div>
    </div>
</div>




