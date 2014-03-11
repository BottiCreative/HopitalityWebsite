<?php       
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class BlogsearchController extends Controller {

	public function __construct(){
		$url_array = explode('/',$_SERVER['REQUEST_URI']);
		$bump = 0;
		if($url_array[1] == 'index.php'){$bump = 1;}
		$tag = rawurldecode($url_array[(2+$bump)]);
		$category = rawurldecode($url_array[(3+$bump)]);
		if($tag != 'blogsearch'){
			$this->parseSearchPath($tag,$category);
		}
	}
	
	public function view($tag=null,$category=null){
		if($tag){
			$this->parseSearchPath($tag,$category);
		}else{

			global $c;
			
			$metaT = t('Blog Search Page');
			$metaD = t('Search website for terms, categories, tags and content keywords.');
			
			$mtitle = CollectionAttributeKey::getByHandle('meta_title');
			$c->setAttribute($mtitle,$metaT);
			
			$mdesc = CollectionAttributeKey::getByHandle('meta_description');
			$c->setAttribute($mdesc,$metaD);
			
		}
	}
	
	private function parseSearchPath($tag=null,$category=null){
	
		global $c;
		if($category){
			$metaT = t('Blog Search Categories').' - '.$category;
			$metaD = t('Blog categories search result for ').$category;
			$this->set('category',$category);
		}else{
			$metaT = t('Blog Search Tags').' - '.$tag;
			$metaD = t('Blog tags search result for ').$tag;
			$this->set('tag',$tag);
		}
		
		$mtitle = CollectionAttributeKey::getByHandle('meta_title');
		$c->setAttribute($mtitle,$metaT);
		
		$mdesc = CollectionAttributeKey::getByHandle('meta_description');
		$c->setAttribute($mdesc,$metaD);
		
		$html = Loader::helper('html');
		$this->addHeaderItem($html->css('page_types/pb_post.css', 'problog'));
	
		Loader::model('/attribute/categories/collection');
		$blogify = Loader::helper('blogify','problog');
		$blog_settings = $blogify->getBlogSettings();
		$path = Loader::helper('navigation')->getLinkToCollection(Page::getByID($blog_settings['search_path']));
		if($category != ''){
			$category = str_replace('_',' ',$category);
			$ak = CollectionAttributeKey::getByHandle('blog_category');
			$akID = $ak->akID;
			$akc = $ak->getController();
			$options = $akc->getOptions();
			if(is_object($options)){
				foreach($options as $option){
					if($option == $category){
						$url = $path.'?akID['.$akID.'][atSelectOptionID][]='.$option->ID;
						if($blog_settings['search_path'] == $c->getCollectionID()){
							$_REQUEST['akID'][$akID]['atSelectOptionID'][] = $option->ID;
						}else{
							$this->redirect($url);
						}
					}
				}
			}
		}elseif(substr_count($_SERVER["REQUEST_URI"],'atSelectOptionID') < 1){
			$tag = str_replace('_',' ',$tag);
			$ak = CollectionAttributeKey::getByHandle('tags');
			$akID = $ak->akID;
			$akc = $ak->getController();
			$options = $akc->getOptions();
			if(is_object($options)){
				foreach($options as $option){
					if($option == $tag){
						$url = $path.'?akID['.$akID.'][atSelectOptionID][]='.$option->ID;
						if($blog_settings['search_path'] == $c->getCollectionID()){
							$_REQUEST['akID'][$akID]['atSelectOptionID'][] = $option->ID;
						}else{
							$this->redirect($url);
						}
					}
				}
			}
		}
	}
}