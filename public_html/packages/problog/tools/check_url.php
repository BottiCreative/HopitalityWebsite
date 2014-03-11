<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));

$nh = Loader::helper('navigation');
$uh = Loader::helper('concrete/urls');
Loader::library('xmlrpc.inc','problog');

$link = $_REQUEST['link'];
$file_headers = @get_headers($link);
if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $exists = false;
}
else {
    $exists = true;
}

$xmlrpc = false;

if($_REQUEST['xmlrpc']){

	$postText = null;
	$ch = curl_init();
	$timeout = 25;
	curl_setopt($ch,CURLOPT_URL,$link);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$postText = curl_exec($ch);
	curl_close($ch);
	
	if (preg_match('/<link rel="pingback" href="([^"]+)"/',$postText,$server)){
	  // It has the <LINK> tag!
	    //print  $server[1]	;
		$xmlrpc = true;
	}
}

print json_encode(array('valid_url'=>$exists,'xmlrpc'=>$xmlrpc));
