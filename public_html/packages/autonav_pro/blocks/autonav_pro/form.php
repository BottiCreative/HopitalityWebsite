<?php   
defined('C5_EXECUTE') or die("Access Denied.");
/**
	* @ concrete5 package AutonavPro
	* @copyright  Copyright (c) 2013 Hostco. (http://www.hostco.com)  	
*/
$al = Loader::helper('concrete/asset_library');
$ah = Loader::helper('concrete/interface');
$fm = loader::helper('form');
$bt = BlockType::getByHandle('autonav_pro');
$pkg=Package::getByHandle('autonav_pro');
$burl=Loader::helper('concrete/urls')->getPackageURL($pkg);
$burl=rtrim($burl,'/');
//default values
if($info['responsive']==null){$info['responsive']='979';}

//load alternative colorpicker
?>

<script type="text/javascript" src="<?php    echo $burl; ?>/js/jquery.miniColors.js"></script>
<link type="text/css" rel="stylesheet" href="<?php    echo $burl; ?>/css/jquery.miniColors.css" />	
<style>
.miniColors-selector {
	margin: -45px 0 0 160px;
}
.bigspace {
	display: block;
	width: 100%;
	clear: both;
	height: 100px;
}
input[type="checkbox"] {margin:0 5px}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		//
		// Enabling miniColors
		//
		$(".miniColors").miniColors({
			letterCase : 'uppercase',
			change : function(hex, rgb) {

			}
		});
		

		if ($('select.customnav option:selected').val() == '1') {
			$('.custom_options').show();
		} else {
			$('.custom_options').hide();
			$('.bigspace').hide();
		}
		if ($('select.typewnav option:selected').val() == '1') {
			$('.staticwidth_div').show();
		} else {
			$('.staticwidth_div').hide();
		}

		if ($('#fontsize_c').is(":checked")) {
			$('#fontsize_div').show();
		} else {
			$('#fontsize_div').hide();
		}
		if ($('#fontstyle_c').is(":checked")) {
			$('#fontstyle_div').show();
		} else {
			$('#fontstyle_div').hide();
		}
		if ($('#fontcolor_c').is(":checked")) {
			$('#fontcolor_div').show();
		} else {
			$('#fontcolor_div').hide();
		}
		if ($('#fontcolorh_c').is(":checked")) {
			$('#fontcolorh_div').show();
		} else {
			$('#fontcolorh_div').hide();
		}
		if ($('#bgcolor_c').is(":checked")) {
			$('#bgcolor_div').show();
		} else {
			$('#bgcolor_div').hide();
		}
		if ($('#bgtabcolor_c').is(":checked")) {
			$('#bgtabcolor_div').show();
		} else {
			$('#bgtabcolor_div').hide();
		}
		if ($('#bgtabcolorh_c').is(":checked")) {
			$('#bgtabcolorh_div').show();
		} else {
			$('#bgtabcolorh_div').hide();
		}
		if ($('#sfontsize_c').is(":checked")) {
			$('#sfontsize_div').show();
		} else {
			$('#sfontsize_div').hide();
		}
		if ($('#sfontstyle_c').is(":checked")) {
			$('#sfontstyle_div').show();
		} else {
			$('#sfontstyle_div').hide();
		}
		if ($('#sfontcolor_c').is(":checked")) {
			$('#sfontcolor_div').show();
		} else {
			$('#sfontcolor_div').hide();
		}
		if ($('#sfontcolorh_c').is(":checked")) {
			$('#sfontcolorh_div').show();
		} else {
			$('#sfontcolorh_div').hide();
		}
		if ($('#sbgcolor_c').is(":checked")) {
			$('#sbgcolor_div').show();
		} else {
			$('#sbgcolor_div').hide();
		}
		if ($('#sbgtabcolor_c').is(":checked")) {
			$('#sbgtabcolor_div').show();
		} else {
			$('#sbgtabcolor_div').hide();
		}
		if ($('#sbgtabcolorh_c').is(":checked")) {
			$('#sbgtabcolorh_div').show();
		} else {
			$('#sbgtabcolorh_div').hide();
		}

	});

	$("select").change(function() {

		if ($('select.customnav option:selected').val() == '1') {
			$('.custom_options').show();
		} else {
			$('.custom_options').hide();
			$('.bigspace').hide();
		}
		if ($('select.typewnav option:selected').val() == '1') {
			$('.staticwidth_div').show();
		} else {
			$('.staticwidth_div').hide();
		}

	});
	$("input").change(function() {
		if ($('#fontsize_c').is(":checked")) {
			$('#fontsize_div').show();
		} else {
			$('#fontsize_div').hide();
		}
		if ($('#fontstyle_c').is(":checked")) {
			$('#fontstyle_div').show();
		} else {
			$('#fontstyle_div').hide();
		}
		if ($('#fontcolor_c').is(":checked")) {
			$('#fontcolor_div').show();
		} else {
			$('#fontcolor_div').hide();
		}
		if ($('#fontcolorh_c').is(":checked")) {
			$('#fontcolorh_div').show();
		} else {
			$('#fontcolorh_div').hide();
		}
		if ($('#bgcolor_c').is(":checked")) {
			$('#bgcolor_div').show();
		} else {
			$('#bgcolor_div').hide();
		}
		if ($('#bgtabcolor_c').is(":checked")) {
			$('#bgtabcolor_div').show();
		} else {
			$('#bgtabcolor_div').hide();
		}
		if ($('#bgtabcolorh_c').is(":checked")) {
			$('#bgtabcolorh_div').show();
		} else {
			$('#bgtabcolorh_div').hide();
		}
		if ($('#sfontsize_c').is(":checked")) {
			$('#sfontsize_div').show();
		} else {
			$('#sfontsize_div').hide();
		}
		if ($('#sfontstyle_c').is(":checked")) {
			$('#sfontstyle_div').show();
		} else {
			$('#sfontstyle_div').hide();
		}
		if ($('#sfontcolor_c').is(":checked")) {
			$('#sfontcolor_div').show();
		} else {
			$('#sfontcolor_div').hide();
		}
		if ($('#sfontcolorh_c').is(":checked")) {
			$('#sfontcolorh_div').show();
		} else {
			$('#sfontcolorh_div').hide();
		}
		if ($('#sbgcolor_c').is(":checked")) {
			$('#sbgcolor_div').show();
		} else {
			$('#sbgcolor_div').hide();
		}
		if ($('#sbgtabcolor_c').is(":checked")) {
			$('#sbgtabcolor_div').show();
		} else {
			$('#sbgtabcolor_div').hide();
		}
		if ($('#sbgtabcolorh_c').is(":checked")) {
			$('#sbgtabcolorh_div').show();
		} else {
			$('#sbgtabcolorh_div').hide();
		}
	});

</script>
<div style="padding:10px">
<ul id="ccm-autonav-tabs" class="ccm-dialog-tabs">
	<li class="ccm-nav-active"><a id="ccm-autonav-tab-add" href="javascript:void(0);"><?php    echo t('Edit')?></a></li>
	<li class=""><a id="ccm-autonav-tab-style"  href="javascript:void(0);"><?php    echo t('Customize')?></a></li>			
</ul>
<div class="ccm-autonavPane" id="ccm-autonavPane-add" style="clear: both">

<input type="hidden" name="autonavCurrentCID" value="<?php    echo $c->getCollectionID()?>" />
<input type="hidden" name="autonavPreviewPane" value="<?php    echo REL_DIR_FILES_TOOLS_BLOCKS?>/<?php    echo $this->getBlockTypeHandle()?>/preview_pane.php" />
<div class="ccm-summary-selected-item">
<strong><?php    echo t('Pages Should Appear')?></strong><br/>
<select name="orderBy" class="mySelect">
	<option value="display_asc" <?php     if ($info['orderBy'] == 'display_asc') { ?> selected<?php     } ?>><?php    echo t('in their sitemap order.')?></option>
	<option value="chrono_desc" <?php     if ($info['orderBy'] == 'chrono_desc') { ?> selected<?php     } ?>><?php    echo t('with the most recent first.')?></option>
    <option value="chrono_asc" <?php     if ($info['orderBy'] == 'chrono_asc') { ?> selected<?php     } ?>><?php    echo t('with the earliest first.')?></option>
    <option value="alpha_asc" <?php     if ($info['orderBy'] == 'alpha_asc') { ?> selected<?php     } ?>><?php    echo t('in alphabetical order.')?></option>
    <option value="alpha_desc" <?php     if ($info['orderBy'] == 'alpha_desc') { ?> selected<?php     } ?>><?php    echo t('in reverse alphabetical order.')?></option>
    <option value="display_desc" <?php     if ($info['orderBy'] == 'display_desc') { ?> selected<?php     } ?>><?php    echo t('in reverse sitemap order.')?></option>
</select>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><?php    echo t('Viewing Permissions')?></strong><br/>
<?php    echo $fm -> checkbox('displayUnavailablePages', 1, $info['displayUnavailablePages']); ?>
<?php    echo t('Display pages to users even when those users cannot access those pages.')?>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><?php    echo t('Display Pages')?></strong><br/>
<select name="displayPages" onchange="toggleCustomPage(this.value);" class="mySelect">
	<option value="top"<?php     if ($info['displayPages'] == 'top') { ?> selected<?php     } ?>><?php    echo t('at the top level.')?></option>
	<option value="second_level"<?php     if ($info['displayPages'] == 'second_level') { ?> selected<?php     } ?>><?php    echo t('at the second level.')?></option>
	<option value="third_level"<?php     if ($info['displayPages'] == 'third_level') { ?> selected<?php     } ?>><?php    echo t('at the third level.')?></option>
	<option value="above"<?php     if ($info['displayPages'] == 'above') { ?> selected<?php     } ?>><?php    echo t('at the level above.')?></option>
	<option value="current"<?php     if ($info['displayPages'] == 'current') { ?> selected<?php     } ?>><?php    echo t('at the current level.')?></option>
	<option value="below"<?php     if ($info['displayPages'] == 'below') { ?> selected<?php     } ?>><?php    echo t('At the level below.')?></option>
	<option value="custom"<?php     if ($info['displayPages'] == 'custom') { ?> selected<?php     } ?>><?php    echo t('Beneath a particular page')?></option>
</select>

<br/>

<div id="ccm-autonav-page-selector"<?php     if ($info['displayPages'] != 'custom') { ?> style="display: none"<?php     } ?>>
<?php     $fmps = Loader::helper('form/page_selector');
	print $fmps -> selectPage('displayPagesCID', $info['displayPagesCID']);
?>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><?php    echo t('Subpages to Display')?></strong><br/>
<select name="displaySubPages" onchange="toggleSubPageLevels(this.value);" class="mySelect">
	<option value="none"<?php     if ($info['displaySubPages'] == 'none') { ?> selected<?php     } ?>><?php    echo t('None')?></option>
	<option value="relevant"<?php     if ($info['displaySubPages'] == 'relevant') { ?> selected<?php     } ?>><?php    echo t('Relevant sub pages.')?></option>
	<option value="relevant_breadcrumb"<?php     if ($info['displaySubPages'] == 'relevant_breadcrumb') { ?> selected<?php     } ?>><?php    echo t('Display breadcrumb trail.')?></option>
	<option value="all"<?php     if ($info['displaySubPages'] == 'all') { ?> selected<?php     } ?>><?php    echo t('Display all.')?></option>
</select>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><?php    echo t('Subpage Levels')?></strong><br/>
<select id="displaySubPageLevels" name="displaySubPageLevels" <?php     if ($info['displaySubPages'] == 'none') { ?> disabled <?php     } ?> onchange="toggleSubPageLevelsNum(this.value);" class="mySelect">
	<option value="enough"<?php     if ($info['displaySubPageLevels'] == 'enough') { ?> selected<?php     } ?>><?php    echo t('Display sub pages to current.')?></option>
	<option value="enough_plus1"<?php     if ($info['displaySubPageLevels'] == 'enough_plus1') { ?> selected<?php     } ?>><?php    echo t('Display sub pages to current +1.')?></option>
	<option value="all"<?php     if ($info['displaySubPageLevels'] == 'all') { ?> selected<?php     } ?>><?php    echo t('Display all.')?></option>
	<option value="custom"<?php     if ($info['displaySubPageLevels'] == 'custom') { ?> selected<?php     } ?>><?php    echo t('Display a custom amount.')?></option>
</select>

<br/>

<div id="divSubPageLevelsNum"<?php     if ($info['displaySubPageLevels'] != 'custom') { ?> style="display: none"<?php     } ?>>
	<br/>
	<input type="text" name="displaySubPageLevelsNum" value="<?php    echo $info['displaySubPageLevelsNum'] ;?>" style="width: 30px; vertical-align: middle">
	&nbsp;<?php    echo t('levels')?>
</div>
</div>
<br/><br/>
</div>

<div  class="ccm-autonavPane " id="ccm-autonavPane-style" style="display: none;clear: both">
<div class="ccm-summary-selected-item">
<strong><?php    echo t('Responsive Width')?></strong><br/>
<p>
<?php    echo t('Width when nav becomes responsive. Set to 0 to disable. Default value is 979')?>
</p>
<br/>
<?php     echo $fm->text('responsive', $info['responsive']); ?>&nbsp;px
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><?php    echo t('Sublevel Min Width Size')?></strong><br/>
<?php     echo $fm->text('swidthsize', $info['swidthsize']); ?>&nbsp;px
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><?php    echo t('Search Results Page')?></strong><br/>
<?php     $sform = Loader::helper('form/page_selector');
	print $sform->selectPage('searchres', $info['searchres']);
?>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><?php    echo t('Customize Nav')?></strong><br/>
<select id="customnav" name="customnav"  class="mySelect customnav">
	<option value="0"<?php     if ($info['customnav'] == 0) { ?> selected<?php     } ?>><?php    echo t('No')?></option>
	<option value="1"<?php     if ($info['customnav'] == 1 ) { ?> selected<?php     } ?>><?php    echo t('Yes')?></option>

</select>
</div>
<br/>
<div class="custom_options">
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="fontsize_c" value="1" id="fontsize_c" <?php   
	if ($info['fontsize_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Font Size')?></strong><br/>
<div id="fontsize_div">
<select id="fontsize" name="fontsize"  class="mySelect">
	
	<option value="1"<?php     if ($info['fontsize'] == 1) { ?> selected<?php     } ?>><?php    echo t('1px')?></option>
	<option value="2"<?php     if ($info['fontsize'] == 2) { ?> selected<?php     } ?>><?php    echo t('2px')?></option>
	<option value="3"<?php     if ($info['fontsize'] == 3) { ?> selected<?php     } ?>><?php    echo t('3px')?></option>
	<option value="4"<?php     if ($info['fontsize'] == 4) { ?> selected<?php     } ?>><?php    echo t('4px')?></option>
	<option value="5"<?php     if ($info['fontsize'] == 5) { ?> selected<?php     } ?>><?php    echo t('5px')?></option>
	<option value="6"<?php     if ($info['fontsize'] == 6) { ?> selected<?php     } ?>><?php    echo t('6px')?></option>
	<option value="7"<?php     if ($info['fontsize'] == 7) { ?> selected<?php     } ?>><?php    echo t('7px')?></option>
	<option value="8"<?php     if ($info['fontsize'] == 8) { ?> selected<?php     } ?>><?php    echo t('8px')?></option>
	<option value="9"<?php     if ($info['fontsize'] == 9) { ?> selected<?php     } ?>><?php    echo t('9px')?></option>
	<option value="10"<?php     if ($info['fontsize'] == 10) { ?> selected<?php     } ?>><?php    echo t('10px')?></option>
	<option value="11"<?php     if ($info['fontsize'] == 11) { ?> selected<?php     } ?>><?php    echo t('11px')?></option>
	<option value="12"<?php     if ($info['fontsize'] == 12) { ?> selected<?php     } if($info['fontsize'] == null){echo 'selected';} ?>><?php    echo t('12px')?></option>
	<option value="13"<?php     if ($info['fontsize'] == 13) { ?> selected<?php     } ?>><?php    echo t('13px')?></option>
	<option value="14"<?php     if ($info['fontsize'] == 14) { ?> selected<?php     } ?>><?php    echo t('14px')?></option>
	<option value="15"<?php     if ($info['fontsize'] == 15) { ?> selected<?php     } ?>><?php    echo t('15px')?></option>
	<option value="16"<?php     if ($info['fontsize'] == 16) { ?> selected<?php     } ?>><?php    echo t('16px')?></option>
	<option value="17"<?php     if ($info['fontsize'] == 17) { ?> selected<?php     } ?>><?php    echo t('17px')?></option>
	<option value="18"<?php     if ($info['fontsize'] == 18) { ?> selected<?php     } ?>><?php    echo t('18px')?></option>
	<option value="19"<?php     if ($info['fontsize'] == 19) { ?> selected<?php     } ?>><?php    echo t('19px')?></option>
	<option value="20"<?php     if ($info['fontsize'] == 20) { ?> selected<?php     } ?>><?php    echo t('20px')?></option>
	<option value="21"<?php     if ($info['fontsize'] == 21) { ?> selected<?php     } ?>><?php    echo t('21px')?></option>
	<option value="22"<?php     if ($info['fontsize'] == 22) { ?> selected<?php     } ?>><?php    echo t('22px')?></option>
	<option value="23"<?php     if ($info['fontsize'] == 23) { ?> selected<?php     } ?>><?php    echo t('23px')?></option>
	<option value="24"<?php     if ($info['fontsize'] == 24) { ?> selected<?php     } ?>><?php    echo t('24px')?></option>
	<option value="25"<?php     if ($info['fontsize'] == 25) { ?> selected<?php     } ?>><?php    echo t('25px')?></option>
	<option value="26"<?php     if ($info['fontsize'] == 26) { ?> selected<?php     } ?>><?php    echo t('26px')?></option>
	<option value="27"<?php     if ($info['fontsize'] == 27) { ?> selected<?php     } ?>><?php    echo t('27px')?></option>
	<option value="28"<?php     if ($info['fontsize'] == 28) { ?> selected<?php     } ?>><?php    echo t('28px')?></option>
	<option value="29"<?php     if ($info['fontsize'] == 29) { ?> selected<?php     } ?>><?php    echo t('29px')?></option>
	<option value="30"<?php     if ($info['fontsize'] == 30) { ?> selected<?php     } ?>><?php    echo t('30px')?></option>	
</select></div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="fontstyle_c" value="1" id="fontstyle_c" <?php   
	if ($info['fontstyle_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Font Style')?></strong><br/>
<div id="fontstyle_div">
<select id="fontstyle" name="fontstyle"  class="mySelect">	
	<option value="normal"<?php     if ($info['fontstyle'] == 'normal') { ?> selected<?php     } ?>><?php    echo t('normal')?></option>
	<option value="italic"<?php     if ($info['fontstyle'] == 'italic') { ?> selected<?php     } ?>><?php    echo t('italic')?></option>
	<option value="oblique"<?php     if ($info['fontstyle'] == 'oblique') { ?> selected<?php     } ?>><?php    echo t('oblique')?></option>
	<option value="bold"<?php     if ($info['fontstyle'] == 'bold') { ?> selected<?php     } ?>><?php    echo t('bold')?></option>	
	<option value="italic_b"<?php     if ($info['fontstyle'] == 'italic_b') { ?> selected<?php     } ?>><?php    echo t('italic bold')?></option>
	<option value="oblique_b"<?php     if ($info['fontstyle'] == 'oblique_b') { ?> selected<?php     } ?>><?php    echo t('oblique bold')?></option>
</select>	
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="fontcolor_c" value="1" id="fontcolor_c" <?php   
	if ($info['fontcolor_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Font Color')?></strong><br/>
<div id="fontcolor_div">
<?php   
echo '<input type="text" id="fontcolor" name="fontcolor" class="miniColors" value="'.$info['fontcolor'].'" />&nbsp;';
?>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="fontcolorh_c" value="1" id="fontcolorh_c" <?php   
	if ($info['fontcolorh_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Font Color On Hover')?></strong><br/>

<div id="fontcolorh_div">
<?php     
echo '<input type="text" id="fontcolorh" name="fontcolorh" class="miniColors" value="'.$info['fontcolorh'].'" />&nbsp;';
?>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="bgcolor_c" value="1" id="bgcolor_c" <?php   
	if ($info['bgcolor_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Nav Background Color')?></strong><br/>
<div id="bgcolor_div">
<?php   
 echo '<input type="text" id="bgcolor" name="bgcolor" class="miniColors" value="'.$info['bgcolor'].'" />&nbsp;';
 ?>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="bgtabcolor_c" value="1" id="bgtabcolor_c" <?php   
	if ($info['bgtabcolor_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Tabs Background Color')?></strong><br/>
<div id="bgtabcolor_div">
<?php   
 echo '<input type="text" id="bgtabcolor" name="bgtabcolor" class="miniColors" value="'.$info['bgtabcolor'].'" />&nbsp;';
?>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="bgtabcolorh_c" value="1" id="bgtabcolorh_c" <?php   
	if ($info['bgtabcolorh_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Tabs Background Color On Hover')?></strong><br/>
<div id="bgtabcolorh_div">
<?php   
 echo '<input type="text" id="bgtabcolorh" name="bgtabcolorh" class="miniColors" value="'.$info['bgtabcolorh'].'" />&nbsp;';
 ?>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="sfontsize_c" value="1" id="sfontsize_c" <?php   
	if ($info['sfontsize_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Sublevel Font Size')?></strong><br/>
<div id="sfontsize_div">
<select id="sfontsize" name="sfontsize"  class="mySelect">
	
	<option value="1"<?php     if ($info['sfontsize'] == 1) { ?> selected<?php     } ?>><?php    echo t('1px')?></option>
	<option value="2"<?php     if ($info['sfontsize'] == 2) { ?> selected<?php     } ?>><?php    echo t('2px')?></option>
	<option value="3"<?php     if ($info['sfontsize'] == 3) { ?> selected<?php     } ?>><?php    echo t('3px')?></option>
	<option value="4"<?php     if ($info['sfontsize'] == 4) { ?> selected<?php     } ?>><?php    echo t('4px')?></option>
	<option value="5"<?php     if ($info['sfontsize'] == 5) { ?> selected<?php     } ?>><?php    echo t('5px')?></option>
	<option value="6"<?php     if ($info['sfontsize'] == 6) { ?> selected<?php     } ?>><?php    echo t('6px')?></option>
	<option value="7"<?php     if ($info['sfontsize'] == 7) { ?> selected<?php     } ?>><?php    echo t('7px')?></option>
	<option value="8"<?php     if ($info['sfontsize'] == 8) { ?> selected<?php     } ?>><?php    echo t('8px')?></option>
	<option value="9"<?php     if ($info['sfontsize'] == 9) { ?> selected<?php     } ?>><?php    echo t('9px')?></option>
	<option value="10"<?php     if ($info['sfontsize'] == 10) { ?> selected<?php     } ?>><?php    echo t('10px')?></option>
	<option value="11"<?php     if ($info['sfontsize'] == 11) { ?> selected<?php     } ?>><?php    echo t('11px')?></option>
	<option value="12"<?php     if ($info['sfontsize'] == 12) { ?> selected<?php     } if($info['sfontsize'] == null){echo 'selected';} ?>><?php    echo t('12px')?></option>
	<option value="13"<?php     if ($info['sfontsize'] == 13) { ?> selected<?php     } ?>><?php    echo t('13px')?></option>
	<option value="14"<?php     if ($info['sfontsize'] == 14) { ?> selected<?php     } ?>><?php    echo t('14px')?></option>
	<option value="15"<?php     if ($info['sfontsize'] == 15) { ?> selected<?php     } ?>><?php    echo t('15px')?></option>
	<option value="16"<?php     if ($info['sfontsize'] == 16) { ?> selected<?php     } ?>><?php    echo t('16px')?></option>
	<option value="17"<?php     if ($info['sfontsize'] == 17) { ?> selected<?php     } ?>><?php    echo t('17px')?></option>
	<option value="18"<?php     if ($info['sfontsize'] == 18) { ?> selected<?php     } ?>><?php    echo t('18px')?></option>
	<option value="19"<?php     if ($info['sfontsize'] == 19) { ?> selected<?php     } ?>><?php    echo t('19px')?></option>
	<option value="20"<?php     if ($info['sfontsize'] == 20) { ?> selected<?php     } ?>><?php    echo t('20px')?></option>
	<option value="21"<?php     if ($info['sfontsize'] == 21) { ?> selected<?php     } ?>><?php    echo t('21px')?></option>
	<option value="22"<?php     if ($info['sfontsize'] == 22) { ?> selected<?php     } ?>><?php    echo t('22px')?></option>
	<option value="23"<?php     if ($info['sfontsize'] == 23) { ?> selected<?php     } ?>><?php    echo t('23px')?></option>
	<option value="24"<?php     if ($info['sfontsize'] == 24) { ?> selected<?php     } ?>><?php    echo t('24px')?></option>
	<option value="25"<?php     if ($info['sfontsize'] == 25) { ?> selected<?php     } ?>><?php    echo t('25px')?></option>
	<option value="26"<?php     if ($info['sfontsize'] == 26) { ?> selected<?php     } ?>><?php    echo t('26px')?></option>
	<option value="27"<?php     if ($info['sfontsize'] == 27) { ?> selected<?php     } ?>><?php    echo t('27px')?></option>
	<option value="28"<?php     if ($info['sfontsize'] == 28) { ?> selected<?php     } ?>><?php    echo t('28px')?></option>
	<option value="29"<?php     if ($info['sfontsize'] == 29) { ?> selected<?php     } ?>><?php    echo t('29px')?></option>
	<option value="30"<?php     if ($info['sfontsize'] == 30) { ?> selected<?php     } ?>><?php    echo t('30px')?></option>	
</select>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="sfontstyle_c" value="1" id="sfontstyle_c" <?php   
	if ($info['sfontstyle_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Sublevel font style')?></strong><br/>
<div id="sfontstyle_div">
<select id="sfontstyle" name="sfontstyle"  class="mySelect">	
	<option value="normal"<?php     if ($info['sfontstyle'] == 'normal') { ?> selected<?php     } ?>><?php    echo t('normal')?></option>
	<option value="italic"<?php     if ($info['sfontstyle'] == 'italic') { ?> selected<?php     } ?>><?php    echo t('italic')?></option>
	<option value="oblique"<?php     if ($info['sfontstyle'] == 'oblique') { ?> selected<?php     } ?>><?php    echo t('oblique')?></option>
	<option value="bold"<?php     if ($info['sfontstyle'] == 'bold') { ?> selected<?php     } ?>><?php    echo t('bold')?></option>	
	<option value="italic_b"<?php     if ($info['sfontstyle'] == 'italic_b') { ?> selected<?php     } ?>><?php    echo t('italic bold')?></option>
	<option value="oblique_b"<?php     if ($info['sfontstyle'] == 'oblique_b') { ?> selected<?php     } ?>><?php    echo t('oblique bold')?></option>
</select>
</div>	
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="sfontcolor_c" value="1" id="sfontcolor_c" <?php   
	if ($info['sfontcolor_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Sublevel Font Color')?></strong><br/>
<div id="sfontcolor_div">
<?php    
 echo '<input type="text" id="sfontcolor" name="sfontcolor" class="miniColors" value="'.$info['sfontcolor'].'" />&nbsp;';
 ?>
 
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="sfontcolorh_c" value="1" id="sfontcolorh_c" <?php   
	if ($info['sfontcolorh_c'] == 1) {  echo 'checked';
}
 ?>/>&nbsp;<?php    echo t('Sublevel Font Color On Hover')?></strong><br/>
<div id="sfontcolorh_div">
<?php   
echo '<input type="text" id="sfontcolorh" name="sfontcolorh" class="miniColors" value="'.$info['sfontcolorh'].'" />&nbsp;';
?>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="sbgcolor_c" value="1" id="sbgcolor_c" <?php   
	if ($info['sbgcolor_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Sublevel Background Color')?></strong><br/>
<div id="sbgcolor_div">
<?php   
echo '<input type="text" id="sbgcolor" name="sbgcolor" class="miniColors" value="'.$info['sbgcolor'].'" />&nbsp;';
 ?>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong>
<input type="checkbox" name="sbgtabcolor_c" value="1" id="sbgtabcolor_c" <?php   
	if ($info['sbgtabcolor_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Sublevel Tabs Background Color')?></strong><br/>
<div id="sbgtabcolor_div">
<?php   
echo '<input type="text" id="sbgtabcolor" name="sbgtabcolor" class="miniColors" value="'.$info['sbgtabcolor'].'" />&nbsp;';
 ?>
</div>
</div>
<br/>
<div class="ccm-summary-selected-item">
<strong><input type="checkbox" name="sbgtabcolorh_c" value="1" id="sbgtabcolorh_c" <?php   
	if ($info['sbgtabcolorh_c'] == 1) {  echo 'checked';
	}
 ?>/>&nbsp;<?php    echo t('Sublevel Tabs Background Color On Hover')?></strong><br/>
<div id="sbgtabcolorh_div">
<?php    
echo '<input type="text" id="sbgtabcolorh" name="sbgtabcolorh" class="miniColors" value="'.$info['sbgtabcolorh'].'" />&nbsp;';
 ?>
</div>
</div>
<br/>

</div>
<div class="bigspace"></div>
</div>

</div>