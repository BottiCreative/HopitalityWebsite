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
		$html .= '<div class="ccm-summary-selected-user"><div class="ccm-summary-selected-user-inner"><strong class="ccm-summary-selected-user-label">';
		if ($selectedUID > 0) {
			$ui = UserInfo::getByID($selectedUID);
			$html .= $ui->getUserName();
		}
		$html .= '</strong></div>';
		$html .= '<style type="text/css">.ccm-summary-selected-user{border: 1px solid #b7b7b7;padding: 15px 8px;}</style>';
		$html .= '<a class="ccm-sitemap-select-user" id="ccm-user-selector-' . $fieldName . '" onclick="ccmActiveUserField=this" dialog-append-buttons="true" dialog-width="90%" dialog-height="70%" dialog-modal="false" dialog-title="' . t('Choose User') . '" href="'.Loader::helper('concrete/urls')->getToolsURL('users/search_dialog','problog').'?mode=choose_one">' . t('Select User') . '</a>';
		$html .= '&nbsp;<a href="javascript:void(0)" dialog-sender="' . $fieldName . '" class="ccm-sitemap-clear-selected-user" style="float: right; margin-top: -8px;' . $clearStyle . '"><img src="' . ASSETS_URL_IMAGES . '/icons/remove.png" style="vertical-align: middle; margin-left: 3px" /></a>';
		$html .= '<input type="hidden" name="' . $fieldName . '" value="' . $selectedUID . '">';
		$html .= '</div>'; 
		$html .= '<script type="text/javascript">';
		$html .= '$(function() { $("#ccm-user-selector-' . $fieldName . '").dialog(); });';
		$html .= 'if (typeof(ccmActiveUserField) == "undefined") {';
		$html .= 'var ccmActiveUserField;';		
		$html .= '}';
		$htmls .= '
		function ccm_initSelectUser() {
			$("a.ccm-sitemap-select-user").unbind().dialog().click(function(){
				ccmActiveUserField = this;
			});
			$("a.ccm-sitemap-clear-selected-user").unbind().click(function(){
				ccmActiveUserField = this;
				clearUserSelection();
			});
		};
		function clearUserSelection() {
			var fieldName = $(ccmActiveUserField).attr("dialog-sender");
			var par = $(ccmActiveUserField).parent().find(\'.ccm-summary-selected-user-label\');
			$(ccmActiveUserField).parent().find(\'.ccm-sitemap-clear-selected-user\').hide();
			var pari = $(ccmActiveUserField).parent().find("[name=\'"+fieldName+"\']");
			par.html("");
			pari.val("0");
		}
		$(ccm_initSelectUser);
		$(function() { 
		ccm_triggerSelectUser = function(uID, uName, uEmail) {';
		if($javascriptFunc=='' || $javascriptFunc=='ccm_triggerSelectUser'){
			$htmls .= '
			var par = $(ccmActiveUserField).parent().find(\'.ccm-summary-selected-user-label\');
			var pari = $(ccmActiveUserField).parent().find(\'[name=' . $fieldName . ']\');
			$(ccmActiveUserField).parent().find(\'.ccm-sitemap-clear-selected-user\').show();
			par.html(uName);
			pari.val(uID);
			';
		}else{
			$htmls .= $javascriptFunc."(uID, uName); \n";
		}
		$htmls .= "}}); \r\n </script>";
		return $html.$htmls;
		
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
	
	public function selectMultipleUsers($fieldName) {
		
		$html = '';
		$html .= '<table id="ccmUserSelect' . $fieldName . '" class="ccm-results-list" cellspacing="0" cellpadding="0" border="0">';
		$html .= '<tr>';
		$html .= '<th>' . t('Username') . '</th>';
		$html .= '<th>' . t('Email Address') . '</th>';
		$html .= '<th><a class="ccm-user-select-item dialog-launch" onclick="ccmActiveUserField=this" dialog-append-buttons="true" dialog-width="90%" dialog-height="70%" dialog-modal="false" dialog-title="' . t('Choose User') . '" href="' . REL_DIR_FILES_TOOLS_REQUIRED . '/users/search_dialog?mode=choose_multiple"><img src="' . ASSETS_URL_IMAGES . '/icons/add.png" width="16" height="16" /></a></th>';
		$html .= '</tr><tbody id="ccmUserSelect' . $fieldName . '_body" >';
		/* for ($i = 0; $i < $ul->getTotal(); $i++ ) {
			$ui = $ul1[$i];
			$class = $i % 2 == 0 ? 'ccm-row-alt' : '';
			$html .= '<tr id="ccmUserSelect' . $fieldName . '_' . $ui->getUserID() . '" class="ccm-list-record ' . $class . '">';
			$html .= '<td><input type="hidden" name="' . $fieldName . '[]" value="' . $ui->getUserID() . '" />' . $ui->getUserName() . '</td>';
			$html .= '<td>' . $ui->getUserEmail() . '</td>';
			$html .= '<td><a href="javascript:void(0)" class="ccm-user-list-clear"><img src="' . ASSETS_URL_IMAGES . '/icons/close.png" width="16" height="16" class="ccm-user-list-clear-button" /></a>';
			$html .= '</tr>';		
		}*/
		$html .= '<tr class="ccm-user-selected-item-none"><td colspan="3">' . t('No users selected.') . '</td></tr>';
		$html .= '</tbody></table><script type="text/javascript">
		$(function() {
			$("#ccmUserSelect' . $fieldName . ' .ccm-user-select-item").dialog();
			$("a.ccm-user-list-clear").click(function() {
				$(this).parents(\'tr\').remove();
				ccm_setupGridStriping(\'ccmUserSelect' . $fieldName . '\');
			});

			ccm_triggerSelectUser = function(uID, uName, uEmail) {
				$("tr.ccm-user-selected-item-none").hide();
				if ($("#ccmUserSelect' . $fieldName . '_" + uID).length < 1) {
					var html = "";
					html += "<tr id=\"ccmUserSelect' . $fieldName . '_" + uID + "\" class=\"ccm-list-record\"><td><input type=\"hidden\" name=\"' . $fieldName . '[]\" value=\"" + uID + "\" />" + uName + "</td>";
					html += "<td>" + uEmail + "</td>";
					html += "<td><a href=\"javascript:void(0)\" class=\"ccm-user-list-clear\"><img src=\"' . ASSETS_URL_IMAGES . '/icons/close.png\" width=\"16\" height=\"16\" class=\"ccm-user-list-clear-button\" /></a>";
					html += "</tr>";
					$("#ccmUserSelect' . $fieldName . '_body").append(html);
				}
				ccm_setupGridStriping(\'ccmUserSelect' . $fieldName . '\');
				$("a.ccm-user-list-clear").click(function() {
					$(this).parents(\'tr\').remove();
					ccm_setupGridStriping(\'ccmUserSelect' . $fieldName . '\');
				});
			}
		});
		
		</script>';	
		return $html;
	}
	
	
}