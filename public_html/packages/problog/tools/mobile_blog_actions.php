<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

if($_REQUEST['method']=='file_post'){
    //print_r($_FILES);
    
    if (!is_dir(DIR_FILES_UPLOADED_STANDARD.'/incoming')) { 
			mkdir(DIR_FILES_UPLOADED_STANDARD.'/incoming', 0777);
		}
    
    $destFile = DIR_FILES_UPLOADED_STANDARD. '/incoming/' . $_FILES['file']['name'];
    if(substr($_FILES['file']['name'],-4,-3) != '.'){
		$destFile = $destFile.'.jpg';
	}
    move_uploaded_file($_FILES['file']['tmp_name'], $destFile);
    chmod($destFile, 0777);
}

?>