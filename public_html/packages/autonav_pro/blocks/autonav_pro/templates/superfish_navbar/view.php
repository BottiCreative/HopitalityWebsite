<?php   
defined('C5_EXECUTE') or die("Access Denied.");
/**
	* @ concrete5 package AutonavPro
	* @copyright  Copyright (c) 2012 Hostco. (http://www.hostco.com)  	
*/
//get current page
$c = Page::getCurrentPage();
//get navigation
$allNavItems = $controller -> generateNav();
//create nav array
$pro_nav_class = Loader::helper('autonavpro', 'autonav_pro');
$pro_nav_class -> set_curr($c);
$pro_nav_class -> create_nav_objs($allNavItems);
$navItems=$pro_nav_class->navItem;
//get search link
if($searchres!=null && $searchres!=0 && $searchres!='0'){
$subPagelink = Page::getById($searchres);
$searchpageLink = Loader::helper('navigation')->getLinkToCollection($subPagelink); }
/*
 ____________________________________________________________________________NAVIGATION ARRAY INFO___________________________________________________________
 $navItems[<element number>]=>output array

 $navitems[<element number>]['anp_nav_class'] => element custom class;
 $navitems[<element number>]['anp_extra_attr_data'] => add extra attribute for link;
 $navitems[<element number>]['anp_overwrite_title'] =>  auto overwrite element title;
 $navitems[<element number>]['anp_overwrite_html'] =>   overwrite element title, this is the final title ovewrite, good for large html content; //NEW
 $navitems[<element number>]['anp_remove_link'] => check if is enable;
 $navitems[<element number>]['anp_sublvl_stack'] =>  has stack;
 $navitems[<element number>]['anp_sublvl_content'] =>  has content; 
 $navitems[<element number>]['anp_add_img'] => add img ;
 $navitems[<element number>]['anp_add_active_img'] => add img for active mode;
 $navitems[<element number>]['anp_add_extra_img1'] => add extra img 1;
 $navitems[<element number>]['anp_add_extra_img2'] => add extra img 2;
 $navitems[<element number>]['anp_add_extra_img3'] => add extra img 3;
 $navitems[<element number>]['anp_add_extra_img4'] => add extra img 4;
 $navitems[<element number>]['anp_add_extra_img5'] => add extra img 5;
 $navitems[<element number>]['anp_overwrite_link'] => page id link for anchor links=> #footer or javascript calls=>   			 javascript:void(0)(NOTE for js, you need to add page attribute "Dont link in Navigation");
 
 $navitems[<element number>]['target'] => target;
 $navitems[<element number>]['level'] => element level in sitemap;
 $navitems[<element number>]['subDepth'] => element level between this and next;
 $navitems[<element number>]['hasSubmenu'] => has children; 
 $navitems[<element number>]['name'] =>  link name;
 $navitems[<element number>]['isFirst'] => is first in level;
 $navitems[<element number>]['isLast'] =>  is last in level;
 $navitems[<element number>]['isCurrent'] => element selected;
 $navitems[<element number>]['inPath'] => path selected;
 $navitems[<element number>]['isHome'] => check if is home page;
 $navitems[<element number>]['cID'] => element page id;
 $navitems[<element number>]['cObj'] => element obj ;
 $navitems[<element number>]['classes']=> auto classifie elements;
 $navitems[<element number>]['url'] => page Link;
 */

/*************************************************************************** CUSTOM TEMPLATE****************************************************************/

//check if the nav list is empty
if(empty($navItems)){
echo '
<style type="text/css">
.autonav_pro_disable{width:100%;min-height:20px;background:#999999;padding:10px;text-align:center;color:#fff}
</style>
<div class="autonav_pro_disable"><h3>'.t("There is no navigation to display with the currect settings. Please check your configuration.").'</h3></div>';
}
else{

echo '<div class="pro_navbar pro_navbar' . $bID . '"  id="pro_navbar' . $bID . '">';

//mobile btn
echo '<a class="pronav_btn_navbar pronav_btn_navbar' . $bID . '">
<span class="pronav_icon_bar"></span>
<span class="pronav_icon_bar"></span>
<span class="pronav_icon_bar"></span>
</a>';
 
echo '<div class="clear"></div>';
echo '<div class="pronav_collapse nav_collapse pronav_collapse' . $bID . '">';
echo '<ul class="pronav_list superfish-menu'. $bID . '" id="superfish-menu'. $bID . '">';

//reset stack list array
$nav_stack_array='';
//opens the top-level menu
$i = 0;
/***********************************************************build nav list****************************************/
foreach ($navItems as $ni) {

/*_____________________________add custom class for li when it has sublvl/stack or sublvl content________________*/
if ($ni['hasSubmenu']|| $ni['anp_sublvl_stack'] == 1 || $ni['anp_sublvl_content'] !=null){$li_class='nav-dropdown';}
else{$li_class='';}

/*________________________________________________________extra attribute________________________________________*/
$anp_extra_attr_data='';
if($ni['anp_extra_attr_data']!=null){$anp_extra_attr_data=$ni['anp_extra_attr_data'];}
else{$anp_extra_attr_data='';}

/*___________________________________________________remove link_________________________________________________*/
if ($ni['anp_remove_link']) {$ni['url']='';}


echo '<li class="'.$li_class.' ' . $ni['classes'] . '">';


/*________________________________________add item class and remove item link____________________________________*/
if ($ni['hasSubmenu']|| $ni['anp_sublvl_stack'] == 1 || $ni['anp_sublvl_content'] !=null){$ni['classes'].=' drop_a_superfish';}
	
		echo '<a href="' . $ni['url'] . $ni['anp_overwrite_link'] . '" target="' . $ni['target'] . '" class="' . $ni['classes'] . '" '.$anp_extra_attr_data.' >';
		echo $ni['anp_add_img'] . $ni['name'];
		if ($ni['hasSubmenu']|| $ni['anp_sublvl_stack'] == 1 || $ni['anp_sublvl_content'] !=null){echo '    <b class="caret"></b>';}
		echo '</a>';
	
	
//sublvl options:stack/html content/nav links 	
//add sublvl stack 		
		if ($ni['anp_sublvl_stack'] == 1 && !$ni['hasSubmenu'] && $ni['anp_sublvl_content'] ==null) {
		echo '<ul class="sublvl dropdown-menu dropdown-stack"><li>';
		
			$global_area_name = 'anp_sublvl_stack' . $ni['cID'];
			$nav_stack_array[$i]['id'] = $ni['cID'];
			$nav_stack_array[$i]['name'] = $ni['name'];
			$nav_stack_array[$i]['url'] = $ni['url'];
			$nav_stack_array[$i]['stackname'] = $global_area_name;
			//add the stack
			
			global $c;
			if (!$c -> isEditMode()) {			
				echo '<div class="sublvl_stack">';
				$a = new GlobalArea($global_area_name);
				$a -> display();
				echo '</div>';
			}
			$i++;
		echo '</li></ul>';	
		}
//add sublvl stack 			
		elseif($ni['anp_sublvl_stack'] != 1 && $ni['anp_sublvl_content'] !=null && !$ni['hasSubmenu'])
		{
			echo '<ul class="sublvl dropdown-menu"><li>';
			echo $ni['anp_sublvl_content'];
			echo '</li></ul>';
		}
//add sublvl links 		
	if ($ni['hasSubmenu']) {
		
		echo '<ul class="sublvl dropdown-menu">';
		//opens a dropdown sub-menu
	
	} else {
		echo '</li>';
		echo str_repeat('</ul></li>', $ni['subDepth']);

	}
}
if($searchres!=null && $searchres!=0 && $searchres!='0'){

//here you can change the placeholder txt
echo '<li class="search_container">
	<form class="search" method="get" action="'.$searchpageLink.'">
		<input class="search-query" value="" id="search" placeholder="Search..." type="text" name="query" />
		<input type="hidden" value="" name="search_paths[]">
		<input type="hidden" value="Search" name="submit">					
	</form>
	</li>';
	}
echo '</ul></div>
 <div style="clear:both;line-height:0"></div>
 </div>';
//closes the top-level menu

//show sublvl stack name on edit mode
global $c;
if ($c -> isEditMode()) {
if(!empty($nav_stack_array)){
echo '<br/><div class="anp-stack-table"><table class="table table-bordered table-striped"><thead>
<tr>
<th>'.t("Parent cID").'</th>
<th>'.t("Parent name").'</th>
<th>'.t("Sublevel stack name").'</th>
</tr>
</thead><tbody>';
foreach ($nav_stack_array as $stack_arr){
echo '<tr><td>'.$stack_arr["id"].'</td><td>'.$stack_arr["name"].'</td><td>'.$stack_arr["stackname"].'</td></tr>';
}
echo'</tbody></table></div>';
}}


/*customize area*/
?>
<style type="text/css">
<?php   
/*___________________________________________________css customize______________________________________________________________*/

//set default responsize width size:979
if($responsive==null || $responsive < 0 ){$responsive='979';}


if($responsive!=0 && $responsive!='0'){
echo '@media(max-width:'.$responsive.'px){
.pro_navbar' . $bID . ' .caret {right:8px}
.pronav_btn_navbar' . $bID . '{
	display:block
}
.pronav_collapse' . $bID . '{
	display:none;
	padding:5px
}
.pronav_collapse #superfish-menu'. $bID . ' > li {
	float: none;
}
#superfish-menu'. $bID . ' > li > a {
	display:block
}
.pro_navbar' . $bID . ' #superfish-menu'. $bID . ' > li > .dropdown-menu:after, .lexus_efx .pro_navbar #superfish-menu'. $bID . ' > li > .dropdown-menu:before,.pro_navbar' . $bID . ' ul.dropdown-menu, .lexus_efx ul.dropdown-menu, div#main-container #header ul#superfish-menu'. $bID . ' ul.dropdown-menu,#superfish-menu'. $bID . ' li,div#main-container ul#superfish-menu'. $bID . ' ul.dropdown-menu{
	position:static!important;
	float:none!important
}
#superfish-menu'. $bID . '  li  a {
	position:relative;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	margin-bottom:2px
}
.pro_navbar #superfish-menu'. $bID . ' > li > .dropdown-menu:after, .lexus_efx .pro_navbar #superfish-menu'. $bID . ' > li > .dropdown-menu:before{
	display:block
}
#superfish-menu'. $bID . ' .dropdown-menu,#superfish-menu'. $bID . ' .dropdown-menu:before,#superfish-menu'. $bID . ' .dropdown-menu:after{
	background-color:transparent;
	border-color:transparent!important;
	-webkit-box-shadow:none;
	-moz-box-shadow: none;
	box-shadow: none;
}
.pronav_collapse #superfish-menu'. $bID . ' .sublvl{
	width:auto!important
}
.pro_navbar' . $bID . ' .dropdown-menu a,.pro_navbar' . $bID . ' .dropdown-menu a:visited, .pro_navbar #superfish-menu'. $bID . ' .dropdown-menu a{
	padding: 10px 15px;
	color:#999999;
	position:relative
}
.pro_navbar' . $bID . ' .dropdown-menu .caret,#superfish-menu'. $bID . ' .open .dropdown-menu .caret{
	border-color: #999999 transparent transparent transparent;
}
.pro_navbar #superfish-menu'. $bID . ' .caret ,#superfish-menu'. $bID . ' .open  .caret{
	border-color: #999999 transparent transparent transparent ;
}
.pro_navbar' . $bID . ' .dropdown-menu .nav-selected > a,
.pro_navbar' . $bID . ' .dropdown-menu  li.open > a,
.pro_navbar' . $bID . ' .dropdown-menu .nav-selected > a:hover,
.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu .nav-selected > a,
.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu  li.open > a,
.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu .nav-selected > a:hover,
.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu  li > a:focus{
	color: #ffffff;
	text-decoration: none;
	background-color: #0088cc;
	background-color: #0081c2;
	background-image: linear-gradient(to bottom, #0088cc, #0077b3);
	background-image: -moz-linear-gradient(top, #0088cc, #0077b3);
	background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0077b3));
	background-image: -webkit-linear-gradient(top, #0088cc, #0077b3);
	background-image: -o-linear-gradient(top, #0088cc, #0077b3);
	background-repeat: repeat-x;
	outline: 0;
	
}
#superfish-menu'. $bID . ' .search-query {
	max-width:200px!important;
	width:200px;
	margin:5px auto 5px;
}

.pro_navbar #superfish-menu'. $bID . ' > li.search_container {
	float: none;
	text-align: center;
}
} @media(max-width:480px){#superfish-menu'. $bID . ' .search-query {width:120px!important}}';
echo ' @media(min-width:'.$responsive.'px){
	.pronav_collapse'. $bID . '{
		display:block!important;overflow:visible!important;
	}
	.pronav_btn_navbar'. $bID . '{display:none!important}
} ';
echo ' @media(min-width:'.$responsive.'px){
#superfish-menu'. $bID . ' .open > .dropdown-menu{display:table}}';
}
else{
echo '.pronav_collapse'. $bID . '{
	display:block!important;
}';
}


//nav sublevel min-width (default size 100px)
if ($swidthsize != null) {
	echo '#superfish-menu' . $bID . ' .sublvl{min-width:' . $swidthsize . 'px}
	@media(max-width:480px){#superfish-menu' . $bID . ' .sublvl{min-width:100%} }
	';
}
//custom stuff
if ($customnav == 1) {
	//custom top bg color
	if ($bgcolor_c == 1) {
		echo '#pro_navbar' . $bID . '{background-color:' . $bgcolor .'!important;background-image:none!important;box-shadow:none!important}';
		
	}
	//custom sublvl bg color
	if ($sbgcolor_c == 1) {
		echo '#superfish-menu' . $bID . ' ul,#superfish-menu' . $bID . ' ul:after{border:none;box-shadow:none;background-color:' . $sbgcolor . '!important}';
		
		echo '.pro_navbar .pronav_list' . $bID . ' > li > .dropdown-menu:before, .lexus_efx .pro_navbar .pronav_list' . $bID . ' > li > .dropdown-menu:before{border-bottom:7px solid ' . $sbgcolor . '}';
	}
	//custom nav font size
	if ($fontsize_c == 1) {
		echo '#superfish-menu' . $bID . ' a ,#superfish-menu' . $bID . ', #superfish-menu' . $bID . ' a:visited {font-size:' . $fontsize . 'px!important;line-height:'. $fontsize . 'px!important;}';		
		echo '#superfish-menu'. $bID . ' .search-query{font-size:'. $fontsize . 'px}';
		
		
	}
	//custom nav font color
	if ($fontcolor_c == 1) {
		echo '#superfish-menu' . $bID . ' a ,#superfish-menu' . $bID . ', #superfish-menu' . $bID . ' a:visited {color:' . $fontcolor . '!important}';
		echo '#superfish-menu' . $bID . ' .search-query{color:' . $fontcolor . '!important}';
		echo '#pro_navbar' . $bID . ' .pronav_btn_navbar .pronav_icon_bar{background-color:' . $fontcolor .'!important;background-image:none!important}';
	}
	//custom nav font color on hover mode and for active links
	if ($fontcolorh_c == 1) {
		echo '#superfish-menu' . $bID . ' a:hover,#superfish-menu' . $bID . ' .nav-selected a ,#superfish-menu' . $bID . ' .nav-selected a:visited {color:' . $fontcolorh . '!important}';
		echo '#superfish-menu' . $bID . ' .search-query:focus{color:' . $fontcolorh . '!important}';
		echo '#superfish-menu' . $bID . ' .nav-selected > a,#superfish-menu' . $bID . ' .nav-selected > a:visited{color:' . $fontcolorh . '!important}';
	}
	//custom nav font style and weight
	if ($fontstyle_c == 1) {
		switch ($fontstyle) {
			case 'normal' :
				echo '#superfish-menu' . $bID . ' a ,#superfish-menu' . $bID . '{font-style:normal!important;font-weight:normal!important}';
				break;
			case 'italic' :
				echo '#superfish-menu' . $bID . ' a ,#superfish-menu' . $bID . '{font-style:italic!important;font-weight:normal!important}';
				break;
			case 'oblique' :
				echo '#superfish-menu' . $bID . ' a ,#superfish-menu' . $bID . '{font-style:oblique!important;font-weight:normal!important}';
				break;
			case 'bold' :
				echo '#superfish-menu' . $bID . ' a ,#superfish-menu' . $bID . '{font-style:normal!important;font-weight:bold!important}';
				break;
			case 'italic_b' :
				echo '#superfish-menu' . $bID . ' a ,#superfish-menu' . $bID . '{font-style:italic!important;font-weight:bold!important}';
				break;
			case 'oblique_b' :
				echo '#superfish-menu' . $bID . ' a ,#superfish-menu' . $bID . '{font-style:oblique!important;font-weight:bold!important}';
				break;
			default :
				echo '#superfish-menu' . $bID . ' a ,#superfish-menu' . $bID . '{font-style:normal!important;font-weight:normal!important}';
		}
	}
	//add same color to sub indicator as the link font color
	if ($fontcolor_c == 1) {
		echo '.pro_navbar #superfish-menu' . $bID . ' .caret, #superfish-menu' . $bID . ' .open .caret,.pro_navbar #superfish-menu' . $bID . ' .caret, #superfish-menu' . $bID . ' .open .caret,#superfish-menu' . $bID . ' .caret{ border-top-color:' . $fontcolor . ';} #superfish-menu' . $bID . ' .dropdown-menu .caret{border-left-color:' . $fontcolor . ';border-top-color:transparent}';
		if($responsive!=0 && $responsive!='0'){
		echo ' @media(max-width:'.$responsive.'px){.pro_navbar #superfish-menu' . $bID . ' .caret, #superfish-menu' . $bID . ' .open .caret,#superfish-menu' . $bID . ' .dropdown-menu .caret{border-left-color:transparent;border-top-color:' . $fontcolor . '}}';
		}
		
	}
	//custom bg color for link tab
	if ($bgtabcolor_c == 1) {
		echo '#superfish-menu' . $bID . ' a, #superfish-menu' . $bID . ' a:visited {background-color:' . $bgtabcolor . '} ';
		echo '#superfish-menu' . $bID . ' .search-query{background-color:' . $bgtabcolor . ';background-image:none!important;box-shadow:none!important;border-color:' . $bgtabcolor .'}';
		echo '#pro_navbar' . $bID . ' .pronav_btn_navbar {background-color:' . $bgtabcolor .'!important;background-image:none!important}';

	}

	//custom bg color for link tab on hover state
	if ($bgtabcolorh_c == 1) {
		echo '#superfish-menu' . $bID . ' .nav-selected > a,#superfish-menu' . $bID . ' .nav-selected > a:visited, #superfish-menu' . $bID . ' .pronav_list-path-selected > a, #superfish-menu' . $bID . ' .nav-selected > a:hover, #superfish-menu' . $bID . ' > li > a:hover {background-color:' . $bgtabcolorh . '!important;background-image:none!important} ';
		echo '#superfish-menu' . $bID . ' .search-query:focus{background-color:' . $bgtabcolorh . '!important;background-image:none!important;box-shadow:none!important;}';
	}

	//custom font size for sublvl links
	if ($sfontsize_c == 1) {
		echo '#superfish-menu' . $bID . ' ul.sublvl a ,#superfish-menu' . $bID . ', #superfish-menu' . $bID . ' ul.sublvl a:visited {font-size:' . $sfontsize . 'px!important;line-height:'. $sfontsize . 'px!important;}';
	}
	//custom font color for sublvl links
	if ($sfontcolor_c == 1) {
		echo '#superfish-menu' . $bID . ' ul.sublvl a ,#superfish-menu' . $bID . ', #superfish-menu' . $bID . ' ul.sublvl a:visited {color:' . $sfontcolor . '!important}';
		
		echo '.pro_navbar #superfish-menu' . $bID . ' ul.sublvl a .caret, #superfish-menu' . $bID . ' .open  ul.sublvl a .caret,#superfish-menu' . $bID . ' ul.sublvl a .caret{ border-left-color:' . $sfontcolor . ';border-top-color:transparent;}';
		if($responsive!=0 && $responsive!='0'){
		echo ' @media(max-width:'.$responsive.'px){.pro_navbar #superfish-menu' . $bID . ' ul.sublvl a .caret, #superfish-menu' . $bID . ' .open  ul.sublvl a .caret,#superfish-menu' . $bID . ' ul.sublvl a .caret{border-left-color:transparent;border-top-color:' . $sfontcolor . '}}';
		}
		
	}
	//custom font color for sublvl links,on hover state
	if ($sfontcolorh_c == 1) {
		echo '#superfish-menu' . $bID . ' ul.sublvl a:hover,#superfish-menu' . $bID . ' ul.sublvl .nav-selected > a,#superfish-menu' . $bID . ' ul.sublvl .nav-selected > a:visited {color:' . $sfontcolorh . '!important}';
		echo '.pro_navbar' . $bID . ' .dropdown-menu .nav-selected > a,
			.pro_navbar' . $bID . ' .dropdown-menu  li.open > a,
			.pro_navbar' . $bID . ' .dropdown-menu .nav-selected > a:hover,
			.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu .nav-selected > a,
			.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu  li.open > a,
			.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu .nav-selected > a:hover,
			.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu  li > a:focus{color:' . $sfontcolorh . '!important}';
		
	}
	//custom font style for sublvl links
	if ($sfontstyle_c == 1) {
		switch ($sfontstyle) {
			case 'normal' :
				echo '#superfish-menu' . $bID . ' ul.sublvl a ,#superfish-menu' . $bID . ' ul.sublvl {font-style:normal!important;font-weight:normal!important}';
				break;
			case 'italic' :
				echo '#superfish-menu' . $bID . ' ul.sublvl a ,#superfish-menu' . $bID . ' ul.sublvl {font-style:italic!important;font-weight:normal!important}';
				break;
			case 'oblique' :
				echo '#superfish-menu' . $bID . ' ul.sublvl a ,#superfish-menu' . $bID . ' ul.sublvl {font-style:oblique!important;font-weight:normal!important}';
				break;
			case 'bold' :
				echo '#superfish-menu' . $bID . ' ul.sublvl a ,#superfish-menu' . $bID . ' ul.sublvl{font-style:normal!important;font-weight:bold!important}';
				break;
			case 'italic_b' :
				echo '#superfish-menu' . $bID . ' ul.sublvl a ,#superfish-menu' . $bID . ' ul.sublvl{font-style:italic!important;font-weight:bold!important}';
				break;
			case 'oblique_b' :
				echo '#superfish-menu' . $bID . ' ul.sublvl a ,#superfish-menu' . $bID . ' ul.sublvl{font-style:oblique!important;font-weight:bold!important}';
				break;
			default :
				echo '#superfish-menu' . $bID . ' ul.sublvl a ,#superfish-menu' . $bID . ' ul.sublvl{font-style:normal!important;font-weight:normal!important}';
		}
	}
	//custom sublvl tab bg color
	if ($sbgtabcolor_c == 1) {
		echo '#superfish-menu' . $bID . ' ul.sublvl a, #superfish-menu' . $bID . ' ul.sublvl a:visited {background-color:' . $sbgtabcolor . '!important;background-image:none!important} ';
	}

	//custom sublvl tab bg color,hover state
	if ($sbgtabcolorh_c == 1) {
		echo '#superfish-menu' . $bID . ' .nav-selected > ul.sublvl a, #superfish-menu' . $bID . ' .pronav_list-path-selected > ul.sublvl a, #superfish-menu' . $bID . ' .nav-selected > ul.sublvl a:hover, #superfish-menu' . $bID . ' > li > ul.sublvl a:hover,#superfish-menu' . $bID . '  > ul.sublvl .nav-selected a {background-color:' . $sbgtabcolorh . '!important;background-image:none!important} ';
		echo '.pro_navbar' . $bID . ' .dropdown-menu .nav-selected > a,
			.pro_navbar' . $bID . ' .dropdown-menu  li.open > a,
			.pro_navbar' . $bID . ' .dropdown-menu .nav-selected > a:hover,
			.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu .nav-selected > a,
			.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu  li.open > a,
			.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu .nav-selected > a:hover,
			.pro_navbar #superfish-menu'. $bID . ' .dropdown-menu  li > a:focus{background-color:' . $sbgtabcolorh . '!important;background-image:none!important}';
		
	}	
}
echo '</style>';

/*______________________________________________________add js___________________________________________________________________*/
$html = Loader::helper('html');
$pkg=Package::getByHandle('autonav_pro');
$basic_path=Loader::helper('concrete/urls')->getPackageURL($pkg);
$basic_path=rtrim($basic_path,'/');
$controller->addFooterItem('<script type="text/javascript" src="'.$basic_path.'/blocks/autonav_pro/templates/superfish/js/autonav_pro_superfish.js"></script>');
$custom_js='
		jQuery(function(){
			jQuery("ul.superfish-menu'.$bID.'").superfish(
			{
			cssArrows	: false,
			hoverClass:  "open" 
			
			}
			);
		});
';
$controller->addFooterItem($html->javascript('autonav_pro_superfish.js','autonav_pro'));
$controller->addFooterItem('<script type="text/javascript">'.$custom_js.'</script>');
$controller->addFooterItem($html->javascript('autonavProApp.js','autonav_pro'));
}


?>