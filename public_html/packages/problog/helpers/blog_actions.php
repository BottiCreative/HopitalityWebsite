<?php    
defined('C5_EXECUTE') or die("Access Denied.");
class BlogActionsHelper {

	public function __construct() {

	}
	
	function send_publish_request($p){
		Loader::model('groups');
		$approver_group = Group::getByName('ProBlog Approver');
		$users = $approver_group->getGroupMembers();
		$emails = array();
		if($users){
			foreach($users as $ui){
				$email = $ui->getUserEmail();
				$name = $ui->getUserFirstName().' '.$ui->getUserLastName();
				$emails[$email] = $name;
			}
			
			foreach($emails as $email=>$name){
				$mh = Loader::helper('mail');
				$mh->from('approval_request@'.substr(BASE_URL,7));
				$mh->to($email,$name);
				$mh->addParameter('url', BASE_URL.DIR_REL.Loader::helper('navigation')->getLinkToCollection($p));
				$mh->addParameter('description', $p->getCollectionDescription());
				$mh->load('approval_request', 'problog');
				$mh->setSubject(t('A request for Blog Approval has been made'));
				$mh->sendMail();
				$mh->reset();
			}
		}
	}	
	
	public function doSubscription($p){
		Loader::model("attribute/categories/collection");
		Loader::model('userinfo');
		$parentID = Loader::helper('blogify')->getCanonicalParent(null,$p);
		$parent = Page::getByID($parentID);
		$subscription = $parent->getAttribute('subscription');
		if($_REQUEST['send_to_subscribers'] == 1){
			if(is_array($subscription)){
				foreach($subscription as $uID){
					$ui = UserInfo::getByID($uID);
					
					$mh = Loader::helper('mail');
					$mh->from('subscriptions@'.str_replace('www', '',$_SERVER['SERVER_NAME']));
					$mh->to($ui->getUserEmail(),$ui->getUserFirstName().' '.$ui->getUserLastName());
					
					$mh->addParameter('url', BASE_URL.Loader::helper('navigation')->getLinkToCollection($p));
					$mh->addParameter('name', $p->getCollectionName());
					$mh->addParameter('description', $p->getCollectionDescription());
					$mh->addParameter('parent', BASE_URL.Loader::helper('navigation')->getLinkToCollection($parent));
					
					$mh->load('new_blog_post', 'problog');
					
					$mh->setSubject('New Blog Post @'.str_replace('www', '',$_SERVER['SERVER_NAME']).'!');
					$mh->sendMail();
				}
				$sent = true;
			}
		}
		
		$parent = Page::getByPath('/blog');
		if($parent && !$sent){
			$subscription = $parent->getAttribute('subscription');
			if($_REQUEST['send_to_subscribers'] == 1){
				if(is_array($subscription)){
					foreach($subscription as $uID){
						$ui = UserInfo::getByID($uID);
						
						$mh = Loader::helper('mail');
						$mh->from('subscriptions@'.str_replace('www', '',$_SERVER['SERVER_NAME']));
						$mh->to($ui->getUserEmail(),$ui->getUserFirstName().' '.$ui->getUserLastName());
						
						$mh->addParameter('url', BASE_URL.Loader::helper('navigation')->getLinkToCollection($p));
						$mh->addParameter('name', $p->getCollectionName());
						$mh->addParameter('description', $p->getCollectionDescription());
						$mh->addParameter('parent', BASE_URL.Loader::helper('navigation')->getLinkToCollection($parent));
						
						$mh->load('new_blog_post', 'problog');
						
						$mh->setSubject('New Blog Post @'.str_replace('www', '',$_SERVER['SERVER_NAME']).'!');
						$mh->sendMail();
					}
				}
			}
		}
	}
	
	public function doScrape($p,$content=null){
		$bt = BlockType::getByHandle('trackback');
		$nh = Loader::helper('navigation');
		$uh = Loader::helper('concrete/urls');
		Loader::library('xmlrpc.inc','problog');
		if($content && $_POST['post_ping']==1){
			preg_match_all('|<a[^>]*href="([^"]+)"|i',$content,$matches);

			foreach ($matches[1] as $link){
			
			  if (preg_match('/^https{0,1}:/i', $link)){
			    // We've got an external link!
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
					$client = new xmlrpc_client($server[1]);
					$msg = new xmlrpcmsg("pingback.ping", array(
					        new xmlrpcval(BASE_URL.$nh->getLinktoCollection($p), 'string'),
					        new xmlrpcval($link, 'string')));
					$success = $client->send($msg);	
				}
  
			  }
		   }
		}
	}
	
	
	function doTweet($p,$hash){
		$nh = Loader::helper('navigation');
		$pkg = Package::getByHandle('problog');
		$PB_AUTH_TOKEN = $pkg->config('PB_AUTH_TOKEN');
		$PB_AUTH_SECRET = $pkg->config('PB_AUTH_SECRET');
		$PB_APP_KEY = $pkg->config('PB_APP_KEY');
		$PB_APP_SECRET = $pkg->config('PB_APP_SECRET');
		
		if($_POST['post_twitter']==1 && $PB_AUTH_TOKEN){

			Loader::library('oAuth','problog');
			Loader::library('twitteroauth','problog');
			
			$connection = new TwitterOAuth($PB_APP_KEY,$PB_APP_SECRET,$PB_AUTH_TOKEN,$PB_AUTH_SECRET);

			$msg = t('New Blog Post!').' - '.$p->getCollectionName().' : '.BASE_URL.$nh->getLinkToCollection($p).' '.$hash;
			$update_status = $connection->post('statuses/update',array('status' => $msg));
			$temp = $update_status->response;
		}
	}
	
}