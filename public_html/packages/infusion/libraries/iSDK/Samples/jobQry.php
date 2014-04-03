<?
require("isdk.php");  



$app = new iSDK;
echo "connected<br/>";
$app->cfgCon("connectionName");
	echo "app connected<br/>";    


$qry = array('JobTitle'=>'New Order for Contact 123');
$rets= array('Id');
$cards=$app->dsQuery("Job",99,0,$qry,$rets);

	echo "<pre>";
	print_r($cards);
	echo "</pre>";


?>
