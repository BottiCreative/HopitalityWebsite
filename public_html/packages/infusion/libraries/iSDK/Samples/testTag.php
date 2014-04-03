<?php
require("isdk.php");  

$app = new iSDK;
echo "created object!<br/>";

if($app->cfgCon("connectionName")){
	echo "app connected!<br/>";
        
        $cid=(int)$_POST['Id'];
        
        $tagId = 184;
        $result = $app->grpAssign($cid, $tagId);

        
	
	
}	
else {
	echo "connection failed!<br/>";
	
}
?>