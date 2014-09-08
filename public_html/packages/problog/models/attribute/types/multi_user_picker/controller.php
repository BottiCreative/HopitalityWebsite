<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('attribute/types/default/controller');

//########################################################################
//
//	   EXAMPLE USAGE 
//    ================
//
//	$at_multi_user = CollectionAttributeKey::getByHandle('your_attribute_handle'); 
//	$multi_user = $c->getCollectionAttributeValue($at_multi_user); 
//	$u = new user();
//	if(in_array($u->uID,$multi_user)){
//		//************************************************************************
//		//this is where you would wrap your content that you need permission based.
//		//************************************************************************
//
//		echo $your_content_here;
//
//		//************************************************************************
//		//this is the end of the secure content
//		//************************************************************************
//	}
//
//########################################################################


class MultiUserPickerAttributeTypeController extends DefaultAttributeTypeController  {
	protected $searchIndexFieldDefinition = 'X NULL';
	public function form() {
		if (is_object($this->attributeValue)) {
			$value = $this->getDataValues();
			$ul = explode(', ',$value);
		}

		if(count($ul)==1 && $ul[0]==''){
			$ul = null;
		}
		
		$fieldName2 ='akID['.$this->attributeKey->getAttributeKeyID().']';
		$fieldName = $this->attributeKey->getAttributeKeyID();
		
		$html = '';
		$html .= '<table id="ccmMultiUserSelect' . $fieldName . '" class="ccm-results-list" cellspacing="0" cellpadding="0" border="0">';
		$html .= '<tr>';
		$html .= '<th>' . t('Username') . '</th>';
		$html .= '<th>' . t('Email Address') . '</th>';
		$html .= '<th><a class="ccm-multiuser-select-item dialog-launch"  onclick="ccmActiveBlogUserField=this" alt="multi" var="'.$this->attributeKey->getAttributeKeyID().'" dialog-width="90%" dialog-height="70%" dialog-modal="false" dialog-title="' . t('Choose Users') . '" href="' . Loader::helper('concrete/urls')->getToolsURL('users/search_dialog','problog').'?mode=choose_multiple"><img src="' . ASSETS_URL_IMAGES . '/icons/add.png" width="16" height="16" /> &nbsp;&nbsp;Add</a></th>';
		$html .= '</tr><tbody id="ccmMultiUserSelect' . $fieldName . '_body" >';
	
		for ($i = 0; $i < count($ul); $i++ ) {
			$ui = UserInfo::getByID($ul[$i]);

			if($ul[$i] != ''){
				$class = $i % 2 == 0 ? 'ccm-row-alt' : '';
				$html .= '<tr id="ccmMultiUserSelect' . $fieldName . '_' . $ui->getUserID() . '" class="ccm-list-record line ' . $class . '">';
				$html .= '<td><input type="hidden" name="' . $fieldName2 . '[]" value="' . $ui->getUserID() . '" />' . $ui->getUserName() . '</td>';
				$html .= '<td>' . $ui->getUserEmail() . '</td>';
				$html .= '<td><a href="javascript:void(0)" class="ccm-user-list-clear"><img src="' . ASSETS_URL_IMAGES . '/icons/close.png" width="16" height="16" class="ccm-user-list-clear-button" /> &nbsp;Remove</a>';
				$html .= '</tr>';		
			}
		}
	
		if($i==0){
			$html .= '<tr class="ccm-user-selected-item-none"><td colspan="3">' . t('No users selected.') . '</td></tr>';
		}
		$html .= '</tbody></table><script type="text/javascript">
		$(function() {
			//var field = $(ccmActiveBlogUserField).attr(\'var\');

			$(".ccm-multiuser-select-item").dialog();
			$("a.ccm-user-list-clear").click(function() {
				$(this).parents(\'.ccm-list-record\').remove();
				ccm_setupGridStriping(\'ccmMultiUserSelect\' + field );
				$(".ccm-results-list tr").attr(\'class\', \'ccm-list-record\');
			});
		
			ccm_triggerSelectBlogMultiUser = function(uID, uName, uEmail) {
				console.log(uID);
				var field = $(ccmActiveBlogUserField).attr(\'var\');
			
				if($(ccmActiveBlogUserField).attr(\'alt\') != "multi"){
					var par = $(ccmActiveBlogUserField).parent().find(\'.ccm-summary-selected-item-label\');
					var pari = $(ccmActiveBlogUserField).parent().find(\'[name=' . $fieldName . ']\');
					par.html(uName);
					pari.val(uID);
	
				}

				$("tr.ccm-user-selected-item-none").hide();
				if ($("#ccmMultiUserSelect" + field + "_" + uID).length < 1) {
					var html = "";
					html += "<tr id=\"ccmMultiUserSelect" + field + "_" + uID + "\" class=\"ccm-list-record\"><td><input type=\"hidden\" name=\"akID[" + field + "][]\" value=\"" + uID + "\" />" + uName + "</td>";
					html += "<td>" + uEmail + "</td>";
					html += "<td><a href=\"javascript:void(0)\" class=\"ccm-user-list-clear\"><img src=\"' . ASSETS_URL_IMAGES . '/icons/close.png\" width=\"16\" height=\"16\" class=\"ccm-user-list-clear-button\" /></a>";
					html += "</tr>";
					$("#ccmMultiUserSelect"+field+"_body").append(html);
				}
				ccm_setupGridStriping(\'ccmMultiUserSelect\' + field );
				$("#ccmMultiUserSelect" + field + "_body tr").attr(\'class\', \'ccm-list-record\');
	
				$("a.ccm-user-list-clear").click(function() {
					$(this).parents(\'.ccm-list-record\').remove();
					ccm_setupGridStriping(\'ccmMultiUserSelect\' + field );
					$(".ccm-results-list tr").attr(\'class\', \'ccm-list-record\');
				});
			}
		});
		</script>';	
		echo $html;
		
		//$up = Loader::helper('form/user_selector');
		//echo $up->selectMultipleUsers($fieldName2);
		
	}
	
	public function saveValue($obj) {
	
		$uIDs = $obj;

		$uIDarray = '';
		if(is_array($uIDs)){
			foreach($uIDs as $uID){
				if($i){ $uIDarray .= ', '; }
				$uIDarray .= $uID ;
				$i++;
			}
		}else{
			$uIDarray = $uIDs;
		}
		
		$db = Loader::db();
		$db->Replace('atDefault', array('avID' => $this->getAttributeValueID(), 'value' => $uIDarray), 'avID', true);
	}
	
	public function getSearchIndexValue(){
		$ul = array();
		$value = $this->getDataValues();
		return $value;
	}
	
	private function getDataValues(){
		$db = Loader::db();
		$value = $db->GetOne("select value from atDefault where avID = ?", array($this->getAttributeValueID()));
		return $value;
	}
	
	public function getValue() {
		$ul = array();
		$value = $this->getDataValues();
		if($value){
			$ul = explode(', ',$value);
		}
		//if you desire, here is usage example to toss all users into an array
		//$users = array();
		//for ($i = 0; $i < count($ul); $i++ ) {
		//	$users[] = UserInfo::getByID($ul[$i]);	
		//}
		//return $users;
		return $ul;
	}
	
	public function saveForm($data) { 
		$this->saveValue($data);
	}
	
	public function deleteValue() {
		$db = Loader::db();
		$db->Execute('delete from atDefault where avID = ?', array($this->getAttributeValueID()));
	}
	
	public function deleteKey() {
		$db = Loader::db();
		$arr = $this->attributeKey->getAttributeValueIDList();
		foreach($arr as $id) {
			$db->Execute('delete from atDefault where avID = ?', array($id));
		}
	}
	
	public function getDisplayValue() {
		Loader::model('userinfo');
		$values = $this->getValue();
		$html = '';
		if(is_array($values)){
			foreach($values as $id){
				$user = UserInfo::getByID($id);
				if($i){
					$html .= ',';
				}
				if($user){
				$html .= $user->getUserFirstName();
				$i++;
				}
			}
		}
		return $html;
	}
	
}