<?php      defined('C5_EXECUTE') or die(_("Access Denied."));
/**
	* @ concrete5 package AutonavPro
	* @copyright  Copyright (c) 2013 Hostco. (http://www.hostco.com)  	
*/
/**
 * The controller for the Auto-Nav block.
 *
 * @package Blocks
 * @subpackage Auto-Nav
 * @author Andrew Embler <andrew@concrete5.org>
 * @author Jordan Lev
 * @copyright  Copyright (c) 2003-2012 Concrete5. (http://www.concrete5.org)
 * @license    http://www.concrete5.org/license/     MIT License
 *
 */
Class AutonavproHelper {
	public $selectedPathCIDs;
	public $navItem = array();

	public function set_curr($c) {
		$this -> c = $c;
		return true;
	}

	public function cid_arr() {
		$inspectC = $this -> c;
		$selectedPathCIDs = array($inspectC -> getCollectionID());
		$parentCIDnotZero = true;
		while ($parentCIDnotZero) {
			$cParentID = $inspectC -> cParentID;
			if (!intval($cParentID)) {
				$parentCIDnotZero = false;
			} else {
				if ($cParentID != HOME_CID) {
					$selectedPathCIDs[] = $cParentID;
				}
				$inspectC = Page::getById($cParentID);
			}
		}
		$this -> selectedPathCIDs = $selectedPathCIDs;
		return true;
	}

	public function create_nav_objs($allNavItems) {
		$c = $this -> c;		
		//get current array
		$this -> cid_arr();
		/*****************************************************************Check Links Excluded From Nav******************************************************************/
		$includedNavItems = array();
		$excluded_parent_level = 9999;
		$exclude_children_below_level = 9999;
		foreach ($allNavItems as $ni) {		
			$_c = $ni -> getCollectionObject();
			$current_level = $ni -> getLevel();
			$exclude_nav=false;
			if ($_c -> getCollectionAttributeValue('exclude_nav')){
				$exclude_nav=true;
			}
			elseif($_c -> getCollectionAttributeValue('anp_exclude_nav')){
				$exclude_nav=true;
			}
			else{
				$exclude_nav=false;
			}
			
			if ($exclude_nav && ($current_level <= $excluded_parent_level)) {
				$excluded_parent_level = $current_level;
				$exclude_page = true;
			} 			
			else if (($current_level > $excluded_parent_level) || ($current_level > $exclude_children_below_level)) {
				$exclude_page = true;
			} else {
				$excluded_parent_level = 9999;
				$exclude_children_below_level = $_c -> getCollectionAttributeValue('anp_hide_children') ? $current_level : 9999;
				$exclude_page = false;
			}

			if (!$exclude_page) {
				$includedNavItems[] = $ni;
			}
		}

		$navItems = array();
		$navItemCount = count($includedNavItems);
		for ($i = 0; $i < $navItemCount; $i++) {
		//small resets
		$small_img = $medium_img = $large_img = $target='';
		
		$ni = $includedNavItems[$i];
			$_c = $ni -> getCollectionObject();
			/**************************************************************Link Current Level*****************************************************************************/
			$current_level = $ni -> getLevel();

			/**************************************************************************Link target**********************************************************************/
			$target = $ni -> getTarget();
			$target = empty($target) ? '_self' : $target;

			/***************************************************************************Link URL*************************************************************************/
			$pageLink = false;
			if ($_c -> getCollectionAttributeValue('replace_link_with_first_in_nav') && !$exclude_nav && !$_c -> getCollectionAttributeValue('anp_remove_link')) {
				$subPage = $_c -> getFirstChild();
				if ($subPage instanceof Page) {
					$pageLink = Loader::helper('navigation') -> getLinkToCollection($subPage);
				}
			}
			if (!$pageLink) {
				$pageLink = $ni -> getURL();
			}
			/****************************************************************Link Disabled********************************************************************************/
			$anp_remove_link = $_c -> getCollectionAttributeValue('anp_remove_link');
			/*****************************************************************Link images Img******************************************************************************/
			if ($_c -> getCollectionAttributeValue('anp_add_img')) {
				$anp_add_img_obj = $_c -> getCollectionAttributeValue('anp_add_img');
				$anp_add_img_path = $anp_add_img_obj -> getRelativePath();
				$anp_add_img = '<img src="' . $anp_add_img_path . '" class="anp_add_img" />';
			}
			else{unset($anp_add_img);}
			/////////////////////////////////////////////////////////////////////////////////////////
			if ($_c -> getCollectionAttributeValue('anp_add_active_img')) {
				$anp_add_active_img_obj = $_c -> getCollectionAttributeValue('anp_add_active_img');
				$anp_add_active_img_path = $anp_add_active_img_obj -> getRelativePath();
				$anp_add_active_img = '<img src="' . $anp_add_active_img_path . '" class="anp_add_active_img" />';
			}
			else{unset($anp_add_active_img);}
			/////////////////////////////////////////////////////////////////////////////////////////
			if ($_c -> getCollectionAttributeValue('anp_add_extra_img1')) {
				$anp_add_extra_img1_obj = $_c -> getCollectionAttributeValue('anp_add_extra_img1');
				$anp_add_extra_img1_path = $anp_add_extra_img1_obj -> getRelativePath();
				$anp_add_extra_img1 = '<img src="' . $anp_add_extra_img1_path . '" class="anp_add_extra_img1" />';
			}
			else{unset($anp_add_extra_img1);}
			/////////////////////////////////////////////////////////////////////////////////////////
			if ($_c -> getCollectionAttributeValue('anp_add_extra_img2')) {
				$anp_add_extra_img2_obj = $_c -> getCollectionAttributeValue('anp_add_extra_img2');
				$anp_add_extra_img2_path = $anp_add_extra_img2_obj -> getRelativePath();
				$anp_add_extra_img2 = '<img src="' . $anp_add_extra_img2_path . '" class="anp_add_extra_img2" />';
			}
			else{unset($anp_add_extra_img2);}
			/////////////////////////////////////////////////////////////////////////////////////////
			if ($_c -> getCollectionAttributeValue('anp_add_extra_img3')) {
				$anp_add_extra_img3_obj = $_c -> getCollectionAttributeValue('anp_add_extra_img3');
				$anp_add_extra_img3_path = $anp_add_extra_img3_obj -> getRelativePath();
				$anp_add_extra_img3 = '<img src="' . $anp_add_extra_img3_path . '" class="anp_add_extra_img3" />';
			}
			/////////////////////////////////////////////////////////////////////////////////////////
			if ($_c -> getCollectionAttributeValue('anp_add_extra_img4')) {
				$anp_add_extra_img4_obj = $_c -> getCollectionAttributeValue('anp_add_extra_img4');
				$anp_add_extra_img4_path = $anp_add_extra_img4_obj -> getRelativePath();
				$anp_add_extra_img4 = '<img src="' . $anp_add_extra_img4_path . '" class="anp_add_extra_img4" />';
			}
			else{unset($anp_add_extra_img4);}
			/////////////////////////////////////////////////////////////////////////////////////////
			if ($_c -> getCollectionAttributeValue('anp_add_extra_img5')) {
				$anp_add_extra_img5_obj = $_c -> getCollectionAttributeValue('anp_add_extra_img5');
				$anp_add_extra_img5_path = $anp_add_extra_img5_obj -> getRelativePath();
				$anp_add_extra_img5 = '<img src="' . $anp_add_extra_img5_path . '" class="anp_add_extra_img5" />';
			}
			else{unset($anp_add_extra_img5);}
			/////////////////////////////////////////////////////////////////////////////////////////
			
			
			/**************************************************************************Link images Stack*****************************************************************/
			$anp_sublvl_stack = 0;
			if ($_c -> getCollectionAttributeValue('anp_sublvl_stack')) {
				$anp_sublvl_stack = 1;
			} else {$anp_sublvl_stack = 0;
			}
			/*************************************************************************Link Name**************************************************************************/
			if (!$_c -> getCollectionAttributeValue('anp_hide_nav_txt')) {$navtxt = $ni -> getName();
			} else {
				$navtxt = '';
			}
			//________________________________________________________________Current/ancestor page
			$selected = false;
			$path_selected = false;
			if ($c -> getCollectionID() == $_c -> getCollectionID()) {
				$selected = true;
				//Current item is the page being viewed
				$path_selected = true;
			} elseif (in_array($_c -> getCollectionID(), $this -> selectedPathCIDs)) {
				$path_selected = true;
				//Current item is an ancestor of the page being viewed
			}

			//__________________________________________________Calculate difference between this item's level and next item's level
			$next_level = isset($includedNavItems[$i + 1]) ? $includedNavItems[$i + 1] -> getLevel() : 0;
			$levels_between_this_and_next = $current_level - $next_level;

			//________________________________________________Determine if this item has children
			$has_children = $next_level > $current_level;

			//_______________________________________________Calculate if this is the first item in its level
			$prev_level = isset($includedNavItems[$i - 1]) ? $includedNavItems[$i - 1] -> getLevel() : -1;
			$is_first_in_level = $current_level > $prev_level;

			//____________________________________________Calculate if this is the last item in its level
			$is_last_in_level = true;
			for ($j = $i + 1; $j < $navItemCount; $j++) {
				if ($includedNavItems[$j] -> getLevel() == $current_level) {
					$is_last_in_level = false;
					break;
				}
				if ($includedNavItems[$j] -> getLevel() < $current_level) {
					$is_last_in_level = true;
					break;
				}
			}

			/***********************************************************LinkCustom CSS class*********************************************************************/
			$anp_nav_class = $_c -> getCollectionAttributeValue('anp_nav_class');
			$anp_nav_class = empty($anp_nav_class) ? '' : $anp_nav_class;

			/********************************************************************Home Link***********************************************************************/
			$item_cid = $_c -> getCollectionID();
			$is_home_page = ($item_cid == HOME_CID);
			/******************************************************************Overwrite Link***********************************************************************/
			if($_c -> getCollectionAttributeValue('anp_overwrite_link')){
			$anp_overwrite_link = $_c -> getCollectionAttributeValue('anp_overwrite_link');
			}
			else{unset($anp_overwrite_link);}
			/******************************************************************Sublvl Content
			***********************************************************************/
			if($_c -> getCollectionAttributeValue('anp_sublvl_content')!=null){$anp_sublvl_content = $_c -> getCollectionAttributeValue('anp_sublvl_content');}
			else{unset($anp_sublvl_content);}
			
			/******************************************************************Overwrite Title
			***********************************************************************/
			$anp_overwrite_title='';
			if($_c -> getCollectionAttributeValue('anp_overwrite_title')!=null){$anp_overwrite_title = $_c -> getCollectionAttributeValue('anp_overwrite_title');}
			else{unset($anp_overwrite_title);}
			if($anp_overwrite_title!=null && !$_c -> getCollectionAttributeValue('anp_hide_nav_txt')){$navtxt=$anp_overwrite_title;}
			/******************************************************************Overwrite Title with HTML content 
			***********************************************************************/
			$anp_overwrite_html='';
			if($_c -> getCollectionAttributeValue('anp_overwrite_html')!=null){$anp_overwrite_html = $_c -> getCollectionAttributeValue('anp_overwrite_html');}
			else{unset($anp_overwrite_html);}
			if($anp_overwrite_html!=null && !$_c -> getCollectionAttributeValue('anp_hide_nav_txt')){$navtxt=$anp_overwrite_html;}
			
			
			
			/******************************************************************Add extra attr
			***********************************************************************/
			$anp_extra_attr_data='';
			if($_c -> getCollectionAttributeValue('anp_extra_attr_data')!=null){$anp_extra_attr_data = $_c -> getCollectionAttributeValue('anp_extra_attr_data');}			
			//anp_extra_attr_data
			//________________________________________$navitems arr
			
			$navitems[$i]['anp_overwrite_link'] = $anp_overwrite_link;
			$navitems[$i]['anp_remove_link'] = $anp_remove_link;
			$navitems[$i]['anp_nav_class'] = $anp_nav_class;
			$navitems[$i]['anp_extra_attr_data'] = $anp_extra_attr_data;
			$navitems[$i]['anp_overwrite_title'] = $anp_overwrite_title;
			$navitems[$i]['anp_overwrite_html'] = $anp_overwrite_html;
			$navitems[$i]['anp_sublvl_stack'] = $anp_sublvl_stack;
			$navitems[$i]['anp_sublvl_content'] = $anp_sublvl_content;			
			$navitems[$i]['anp_add_img'] = $anp_add_img;
			$navitems[$i]['anp_add_active_img'] = $anp_add_active_img;
			$navitems[$i]['anp_add_extra_img1'] = $anp_add_extra_img1;
			$navitems[$i]['anp_add_extra_img2'] = $anp_add_extra_img2;
			$navitems[$i]['anp_add_extra_img3'] = $anp_add_extra_img3;
			$navitems[$i]['anp_add_extra_img4'] = $anp_add_extra_img4;
			$navitems[$i]['anp_add_extra_img5'] = $anp_add_extra_img5;
						
			
			$navitems[$i]['name'] = $navtxt;
			$navitems[$i]['url'] = $pageLink;
			$navitems[$i]['level'] = $current_level + 1;
			$navitems[$i]['subDepth'] = $levels_between_this_and_next;
			$navitems[$i]['hasSubmenu'] = $has_children;			
			$navitems[$i]['target'] = $target;
			$navitems[$i]['isFirst'] = $is_first_in_level;
			$navitems[$i]['isLast'] = $is_last_in_level;
			$navitems[$i]['isCurrent'] = $selected;
			$navitems[$i]['inPath'] = $path_selected;			
			$navitems[$i]['isHome'] = $is_home_page;
			$navitems[$i]['cID'] = $item_cid;
			$navitems[$i]['cObj'] = $_c;
			$navitems[$i]['count_children'] =$_c ->getNumChildren();
			//_________________________________________________________add classes
			$classes = '';
			
			if ($navitems[$i]['isCurrent']) {$classes[] = 'nav-selected';
			}
			if ($navitems[$i]['inPath']) {$classes[] = 'nav-path-selected';
			}
			if ($navitems[$i]['isFirst']) {$classes[] = 'nav-first';
			}
			if ($navitems[$i]['isLast']) {$classes[] = 'nav-last';
			}
			if ($navitems[$i]['hasSubmenu']) {$classes[] = 'nav-dropdown';
			}
			if ($navitems[$i]['anp_sublvl_stack']) {$classes[] = 'pronav_stack_li';
			}
			if (!empty($navitems[$i]['anp_nav_class'])) {$classes[] = $navitems[$i]['anp_nav_class'];
			}
			if ($navitems[$i]['isHome']) {$classes[] = 'nav-home';
			}
			$classes[] = 'nav-item-' . $navitems[$i]['cID'];

			$navitems[$i]['classes'] = implode(" ", $classes);
			$classes = '';

		}
		$this -> navItem = $navitems;
		return true;
	}
	

}
?>