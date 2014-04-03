<?php
require("isdk.php");  
$app = new iSDK;

if($app->cfgCon("connectionName")){
    
    $orderId = 673;
    $firstName='API';
    $lastName='Has Updated Me';
    $street='333 API st';
    $city='gilbert';
    
    $dat=array('ShipFirstName' => $firstName,
                'ShipLastName' => $lastName,
                'ShipStreet1' => $street,
                'ShipCity' => $city);
    
    $jobId = $app->dsUpdate("Job", $orderId, $dat);

    echo "JobId=$jobId<br/>";
}

?>