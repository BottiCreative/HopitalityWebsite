<?php    
defined('C5_EXECUTE') or die("Access Denied.");
/**
	* @ concrete5 package AutonavPro
	* @copyright  Copyright (c) 2013 Hostco. (http://www.hostco.com)  	
*/
$info = $controller->getContent();
$bt->inc('form.php', array('info' => $info, 'c' => $c, 'b' => $b));
?>