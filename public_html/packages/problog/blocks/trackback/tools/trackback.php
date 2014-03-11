<?php      
include 'xmlrpc.inc';

$ch = curl_init();
$timeout = 25;
curl_setopt($ch,CURLOPT_URL,$_POST['post_url']);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
$postText = curl_exec($ch);
curl_close($ch); 

if($postText){
	preg_match_all('|<a[^>]*href="([^"]+)"|i',$postText,$matches);
	
	$success = false;
	$ping = false;
	foreach ($matches[1] as $link){
	  
	  if (preg_match('/^https{0,1}:/i', $link)){
	    // We've got an external link!	
			if(strpos($link,$_POST['trackback-uri']) >= 0){	
			
				$comment = urlencode($_POST['post_url']);
				
				$cID = $_POST['post_cID'];
				
				//set POST variables
				$url = $_POST['trackback-uri'].'?collectionID='.$cID.'&comment=Pingback_'.$comment;
				
				$ch = curl_init();
				$timeout = 25;
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
				curl_exec($ch);
				curl_close($ch); 
				
				$ping = true;
				break;
			}
	  	}
	  	
	}
	if (preg_match('/<link rel="pingback" href="([^"]+)"/',$postText,$server)){
	  	// It has the <LINK> tag!
	 	//Where PERMALINK is the url of the post
	    //print  $server[1]	;
		$client = new xmlrpc_client($server[1]);
		$msg = new xmlrpcmsg("pingback.ping", array(
		        new xmlrpcval($_POST['trackback-uri'], 'string'),
		        new xmlrpcval($_POST['post_url'], 'string')));
		$success = $client->send($msg);	
		//$success = 'success';	
	}
	if($success){
		if($success->errstr != ''){
			print $success->errstr;
			if($ping){
				print '<br/>'.t('However, our site recognizes your link to us on your blog!  A comment linking to your post has been made!');			
			}
		}else{
			print $success->val->me['string'];
			if($ping){
				print '<br/>'.t('Our site also recognized a link to us on your blog!  A comment linking to your post has been made here!');			
			}
		}
	}else{
		if($ping){
			print t('Our site recognized a link to us on your blog!  A comment linking to your post has been made here!');			
		}else{
			print t('Target url does not support pingback.');
		}
	}
}else{
	print t('this appears to be an invalid URL.');
}
exit;
?>