<?php      
if($_REQUEST['akID']){
	$akID = $_REQUEST['akID'];
	if($_REQUEST['akID']){
		if($_REQUEST['akID'] == 'same_tags'){
			Loader::model('attribute/categories/collection');
			$key = CollectionAttributeKey::getByHandle('tags');
			$akID = $key->akID;
		}
	}
	$html = '<fieldset>';
	$db = loader::db();
	$r = $db->execute("SELECT * FROM atSelectOptions WHERE akID = $akID");
	while($row = $r->fetchrow()){
		$id = $row['ID'];
		$options[$id] = $row['value'];
	}
	if(is_array($options)){
		foreach($options as $key=>$option){
			$html .= '<input type="checkbox" name="fields[]" value="'.$option.'">'.$option.'<br/>';
		}
	}
	$html .= '</fieldset>';
	//print json_encode($options);
	print $html;
	exit;
}
?>