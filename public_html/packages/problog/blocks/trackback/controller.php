<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));
class TrackbackBlockController extends BlockController {

	protected $btTable = 'btTrackback';
	protected $btInterfaceWidth = "300";
	protected $btInterfaceHeight = "100";
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	
	/** 
	 * Used for localization. If we want to localize the name/description we have to include this
	 */
	public function getBlockTypeDescription() {
		return t("Trackback URLs");
	}
	
	public function getBlockTypeName() {
		return t("Trackback");
	}
	
	public function on_page_view(){
		if($_REQUEST['collectionID']){
			$blogify = Loader::helper('blogify','problog');
			/*
			/ we need to validate one more time via screen scrape
			*/
			/* first get the page */
			$page = Page::getByID($_REQUEST['collectionID']);
			/* then get the link to the page */
			$page_link = Loader::helper('navigation')->getLinkToCollection($page);
			/* next strip the formatted source URL sent from our xmlrpc output */
			$source_url = urldecode(str_replace('Pingback_','',$_REQUEST['comment']));
			/* confirm this is a URL */
			if(substr($source_url,0,4)=='http'){
				/* CURL to the source page one more time to re-validate via screen-scrape
				/ this is necisarry to prevent formatted tritiarry source URL comment posts */
				$ch = curl_init();
				$timeout = 25;
				curl_setopt($ch,CURLOPT_URL,$source_url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
				$postText = curl_exec($ch);
				curl_close($ch); 
				if($postText){
					/* grab all the links in the page */
					preg_match_all('|<a[^>]*href="([^"]+)"|i',$postText,$matches);
					foreach ($matches[1] as $link){
						/* confirm the link is external */
						if (preg_match('/^https{0,1}:/i', $link)){
						    /* match the link to our intended page link */
						    if(strpos($link,$page_link) >= 0){	
						    	/* yup.  we're good here. */	
						    	/* send original source URL and cID to model to process commenting */
								$blogify->post_trackback($_REQUEST['collectionID'],$_REQUEST['comment']);
							}
						}
					}
				}
			}
		}
	}
	
	public function view(){
		$uh = Loader::helper('concrete/urls');
		
		//* for non-problog install only *//
		$bt = BlockType::getByHandle('trackback');
		$tburl = $uh->getBlockTypeAssetsURL($bt,'tools/trackback.php');
		$tbpurl = $uh->getBlockTypeAssetsURL($bt,'tools/xmlrpc.php');
		$this->set('trackback_url',$tburl);
		$this->set('trackback_comment_url',$tbcomment);
		$this->set('xmlrpc',$tbpurl);
	}
}