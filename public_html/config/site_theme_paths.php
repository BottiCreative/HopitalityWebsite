<?php    

defined('C5_EXECUTE') or die("Access Denied.");


/* 
	you can override system layouts here  - but we're not going to by default 
	
	For example: if you would like to theme your login page with the Green Salad theme,
	you would uncomment the lines below and change the second argument of setThemeByPath 
	to be the handle of the the Green Salad theme "greensalad" 

*/


$v = View::getInstance();

//get user
$user = new User();


if($user->isLoggedIn())
{
	//$v->setThemeByPath('/about','members');
	//$v->setThemeByPath('','members');
	//$path =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$path = $_SERVER['REQUEST_URI'];
	

	//echo $path;
	$excludePages = array('/about/','/partners/','/membership/','/dashboard/');
	
	$excludePage = false;
	
	foreach($excludePages as $page)
	{
		if($excludePage)
			continue;	
			
		if(strpos($path,$page) !== false)
		{
			
			$excludePage = true;
			
		}
		
	}
	
	if(!$excludePage)
	{
			
		$v->setThemeByPath(rtrim($path,'/'),'members');
	
	}
	
/*	$v->setThemeByPath('/resources/','members');
	$v->setThemeByPath('/resources','members');
*/
 	
}


$v->setThemeByPath('/login', "login");
$v->setThemeByPath('/page_forbidden', "login");
$v->setThemeByPath('/page_not_found', "login");
$v->setThemeByPath('/register', "login");
/*
*/