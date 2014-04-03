<?php

require("isdk.php");  

$app = new iSDK;
echo "connected<br/>";
$app->cfgCon("connectionName");
	echo "app connected<br/>";


$tmpId = $app->createEmailTemplate("This is my API template",0,"Info@test.com",
                                   "~Contact.Email~","","","html","My Test Email",
                                   "<b>This is my test body</b>","");

echo "Template ".$tmpId." has been created!";


?>