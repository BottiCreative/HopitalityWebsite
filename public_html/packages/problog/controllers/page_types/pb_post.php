<?php      
defined('C5_EXECUTE') or die("Access Denied.");

class PbPostPageTypeController extends Controller {


	public function view(){
		$blogify = Loader::helper('blogify','problog');
		$settings = $blogify->getBlogSettings();
		$embedlykey = $settings['embedly'];
		$this->set('next_link',$this->getNextPost());
		$this->set('prev_link',$this->getPrevPost());
		$html = Loader::helper('html');
		$this->addHeaderItem($html->css('page_types/pb_post.css', 'problog'));
		if($embedlykey){
			$this->addHeaderItem($html->javascript('jquery.embedly.js','problog'));
			$this->addFooterItem("
<script type=\"text/javascript\">
$(document).ready(function(){
  $('.embedly').each(function(){
    var w = $(this).parent().parent().width();
  	$(this).embedly({
  		key: '$embedlykey',
  		query: {
  			maxwidth: w,
  		},
  	});
  });
});
</script>
");
		}
	}
	
	public function getNextPost(){
		global $c;

		$page_path = str_replace('/index.php','',Loader::helper('navigation')->getLinkToCollection($c));
		$link = $c->getCollectionHandle();
		
		$shortened = str_replace($link.'/','',$page_path);
		$cID = $c->getCollectionID();
		

		$db = Loader::db();
		$q = "SELECT cID FROM PagePaths WHERE cID > $cID AND cPath LIKE '%$shortened%' ORDER BY cID ASC";
		$ncID = $db->getOne($q);
		//var_dump($ncID);
		$np = Page::getByID($ncID);
		if($ncID){
			return Loader::helper('navigation')->getLinkToCollection($np);
		}
	}
	
	public function getPrevPost(){
		global $c;

		$page_path = str_replace('/index.php','',Loader::helper('navigation')->getLinkToCollection($c));
		$link = $c->getCollectionHandle();
		
		$shortened = str_replace($link.'/','',$page_path);
		$cID = $c->getCollectionID();
		

		$db = Loader::db();
		$q = "SELECT cID FROM PagePaths WHERE cID < $cID AND cPath LIKE '%$shortened%' ORDER BY cID DESC";
		$ncID = $db->getOne($q);
		//var_dump($shortened);
		$np = Page::getByID($ncID);
		if($ncID){
			return Loader::helper('navigation')->getLinkToCollection($np);
		}
	}
}