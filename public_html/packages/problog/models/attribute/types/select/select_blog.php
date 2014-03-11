<?php       defined('C5_EXECUTE') or die("Access Denied.");

class SelectBlog extends Concrete5_Controller_AttributeType_Select  {

	var $attributeKey;

	public function getOptionUsageArray($parentPage = false, $limit = 9999) {
		$db = Loader::db();
		$q = "select atSelectOptions.value, atSelectOptionID, count(atSelectOptionID) as total from Pages inner join CollectionVersions on (Pages.cID = CollectionVersions.cID and CollectionVersions.cvIsApproved = 1) inner join PagePaths on Pages.cID = PagePaths.cID inner join CollectionAttributeValues on (CollectionVersions.cID = CollectionAttributeValues.cID and CollectionVersions.cvID = CollectionAttributeValues.cvID) inner join atSelectOptionsSelected on (atSelectOptionsSelected.avID = CollectionAttributeValues.avID) inner join atSelectOptions on atSelectOptionsSelected.atSelectOptionID = atSelectOptions.ID where Pages.cIsActive = 1 and CollectionAttributeValues.akID = ? ";
		$v = array($this->attributeKey->getAttributeKeyID());
		if (is_object($parentPage)) {
			$path = $parentPage->getCollectionPath();
			$v[] = $path;
			$q .= "and PagePaths.cPath LIKE '$path%'";
		}
		$q .= " group by atSelectOptionID order by total desc limit " . $limit;
		$r = $db->Execute($q, $v);
		$list = new SelectAttributeTypeOptionList();
		$i = 0;
		while ($row = $r->FetchRow()) {
			$opt = new SelectAttributeTypeOption($row['atSelectOptionID'], $row['value'], $i, $row['total']);
			$list->add($opt);
			$i++;
		}		
		return $list;
	}
	
	public function setAttributeKey($ak){
		$this->attributeKey = $ak;
	}
	
	
}