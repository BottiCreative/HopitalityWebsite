<?php      	
include 'xmlrpc.inc';
include 'xmlrpcs.inc';

function validate_url($url) {
	$handle = curl_init($url);
	curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
	
	/* Get the HTML or whatever is linked in $url. */
	$response = curl_exec($handle);
	
	/* Check for 404 (file not found). */
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	curl_close($handle);
	
	/* If the document has loaded successfully without any redirection or error */
	if ($httpCode >= 200 && $httpCode < 300) {
	    return false;
	} else {
	    return true;
	}
}

$s = new xmlrpc_server(array("pingback.ping" => array("function" => "ping")));

function ping($xmlrpcmsg){

	$from = $xmlrpcmsg->getParam(0)->scalarVal();
	$to = $xmlrpcmsg->getParam(1)->scalarVal();
	
	$linked = false;
	$ping = false;
	

	if(validate_url($from)==true){
		//From doesn’t actually link to To:
		return new xmlrpcresp(0, 17, "Source uri (".$from.") is not valid");
		exit;
	}elseif(validate_url($to)==true){
		//To URL doesn’t exist:
		return new xmlrpcresp(0, 32, "Target uri does not exist");
		exit;
	}else{
		
		$ch = curl_init();
		$timeout = 25;
		curl_setopt($ch,CURLOPT_URL,$from);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$postText = curl_exec($ch);
		curl_close($ch); 
		
		$server = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		
		$server_array = explode('xmlrpc',$server);
		
		if($postText){
			preg_match_all('|<a[^>]*href="([^"]+)"|i',$postText,$matches);
	
			$success = false;
			$ping = false;
			foreach ($matches[1] as $link){
			  if (preg_match('/^https{0,1}:/i', $link)){
			    // We've got an external link!
			    if(strpos($link,$to) >= 0){		
					$linked = true;
				}
				if (preg_match('/<LINK REL="pingback" HREF="([^"]+)">/',$postText)){
					$ping = true;
				}
			  }
			}
		}
		
		if(!$linked){
			return new xmlrpcresp(0, 17, "No valid link in source page to requested URL.");
			exit;
		}
		
		if($ping){
			$comment = urlencode($from);
			
			$cID = $_GET['cID'];
			
			//set POST variables
			$url = $to.'?collectionID='.$cID.'&comment=Pingback_'.$comment;
			
			$ch = curl_init();
			$timeout = 25;
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			$postText = curl_exec($ch);
			$error = curl_error($ch);
			curl_close($ch); 
			
			if(strlen($error) < 1){
				//comment has been successfully added
				return new xmlrpcresp(new xmlrpcval("Hey, good news! The target URL saw your link and and auto-posted! ", "string"));
				exit;
			}else{
				return new xmlrpcresp(0, 17, "$error");
				exit;
			}
		}else{
			return new xmlrpcresp(0, 33, "Target uri does not support trackbacks");
			exit;
		}
	}
}


?>