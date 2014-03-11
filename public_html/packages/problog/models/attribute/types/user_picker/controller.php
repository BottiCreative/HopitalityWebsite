<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('attribute/types/default/controller');

class UserPickerAttributeTypeController extends DefaultAttributeTypeController  {
	protected $searchIndexFieldDefinition = 'X NULL';
	public function form() {
		if (is_object($this->attributeValue)) {
			$value = $this->getAttributeValue()->getValue();
			$_REQUEST['user_pick_'. $this->attributeKey->getAttributeKeyID()] = $value;
		}
		
		$fieldName = 'user_pick_'.$this->attributeKey->getAttributeKeyID();
		
		echo  Loader::helper('user_selector','problog')->selectUser($fieldName,$value,'ccm_triggerSelectBlogUser');
	}
	
	public function saveValue() {
		
		$uID = $_POST['user_pick_'.$this->attributeKey->getAttributeKeyID()];
		
		$db = Loader::db();
		$db->Replace('atDefault', array('avID' => $this->getAttributeValueID(), 'value' => $uID), 'avID', true);
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
	
}