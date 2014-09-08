<?php     
/**
 * @package Helpers
 * @category Concrete
 * @subpackage Forms
 * @author Andrew Embler <andrew@concrete5.org>
 * @copyright  Copyright (c) 2003-2008 Concrete5. (http://www.concrete5.org)
 * @license    http://www.concrete5.org/license/     MIT License
 */

/**
 * Special form elements for choosing a page from the concrete5 sitemap tool.
 * @package Helpers
 * @category Concrete
 * @subpackage Forms
 * @author Andrew Embler <andrew@concrete5.org>
 * @copyright  Copyright (c) 2003-2008 Concrete5. (http://www.concrete5.org)
 * @license    http://www.concrete5.org/license/     MIT License
 */

defined('C5_EXECUTE') or die("Access Denied.");
class UserSelectorHelper {

	
	/** 
	 * Creates form fields and JavaScript user chooser for choosing a user. For use with inclusion in blocks and addons.
	 * <code>
	 *     $dh->selectUser('userID', '1'); // prints out the admin user and makes it changeable.
	 * </code>
	 * @param int $uID
	 */
	
	
	public function selectUser($fieldName, $uID = false, $javascriptFunc = 'ccm_triggerSelectBlogUser') {
		$selectedUID = 0;
		$clearStyle = 'display: none';
		if (isset($_REQUEST[$fieldName])) {
			$selectedUID = $_REQUEST[$fieldName];
			$clearStyle = '';
		} else if ($uID > 0) {
			$selectedUID = $uID;
			$clearStyle = '';
		}
		
		$html = '';
		$html .= '<div class="ccm-summary-selected-blog-user"><div class="ccm-summary-selected-user-inner"><strong class="ccm-summary-selected-item-label">';
		if ($selectedUID > 0) {
			$ui = UserInfo::getByID($selectedUID);
			$html .= $ui->getUserName();
		}
		$html .= '</strong></div>';
		$html .= '<style type="text/css">.ccm-summary-selected-blog-user{border: 1px solid #b7b7b7;padding: 15px 8px;}</style>';
		$html .= '<a class="ccm-sitemap-select-blog-user" id="ccm-blog-user-selector-' . $fieldName . '" onclick="ccmActiveBlogUserField=this" dialog-append-buttons="true" dialog-width="90%" dialog-height="70%" dialog-modal="false" dialog-title="' . t('Choose User') . '" href="'.Loader::helper('concrete/urls')->getToolsURL('users/search_dialog','problog').'?mode=choose_one">' . t('Select User') . '</a>';
		$html .= '&nbsp;<a href="javascript:void(0)" dialog-sender="' . $fieldName . '" class="ccm-sitemap-clear-selected-user" style="float: right; margin-top: -8px;' . $clearStyle . '"><img src="' . ASSETS_URL_IMAGES . '/icons/remove.png" style="vertical-align: middle; margin-left: 3px" /></a>';
		$html .= '<input type="hidden" name="' . $fieldName . '" value="' . $selectedUID . '">';
		$html .= '</div>'; 
		$html .= '<script type="text/javascript">';
		$html .= '$(function() { $("#ccm-blog-user-selector-' . $fieldName . '").dialog(); });';
		$html .= 'if (typeof(ccmActiveBlogUserField) == "undefined") {';
		$html .= 'var ccmActiveBlogUserField;';		
		$html .= '}';
		$htmls .= '
		function ccm_initSelectUser() {
			$("a.ccm-sitemap-clear-selected-user").unbind().click(function(){
				ccmActiveBlogUserField = this;
				clearUserSelection();
			});
		};

		function clearUserSelection() {
			var par = $(ccmActiveBlogUserField).parent().find(\'.ccm-summary-selected-item-label\');
			$(ccmActiveBlogUserField).parent().find(\'.ccm-sitemap-clear-selected-user\').hide();
			var pari = $(ccmActiveBlogUserField).parent().find(\'input\');
			par.html("");
			pari.val("0");
		}
		
		ccm_triggerSelectBlogUser = function(uID,uName){
			var par = $(ccmActiveBlogUserField).parent().find(\'.ccm-summary-selected-item-label\');
			var pari = $(ccmActiveBlogUserField).parent().find(\'input\');
			$(ccmActiveBlogUserField).parent().find(\'.ccm-sitemap-clear-selected-user\').show();
			par.html(uName);
			pari.val(uID);
			
			ccm_initSelectUser();
			
			return false;
		}
		$(ccm_initSelectUser);
		</script>';
		print $html.$htmls;
		
	}
	
	public function quickSelect($key, $val = false, $args = array()) {
		$form = Loader::helper('form');
		$valt = Loader::helper('validation/token');
		$token = $valt->generate('quick_user_select_' . $key);
		$html .= "
		<style type=\"text/css\">
		ul.ui-autocomplete {position:absolute; list-style:none; }
		ul.ui-autocomplete li.ui-menu-item { margin-left:0; padding:2px;}
		</style>
		<script type=\"text/javascript\">
		$(function () {
			$('#".$key."').autocomplete({source: '" . REL_DIR_FILES_TOOLS_REQUIRED . "/users/autocomplete?key=" . $key . "&token=" . $token . "'});
		} );
		</script>";
		$html .= '<span class="ccm-quick-user-selector">'.$form->text($key,$val, $args).'</span>';
		return $html;
	}
	
}