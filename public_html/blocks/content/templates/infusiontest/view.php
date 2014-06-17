<?php 
	defined('C5_EXECUTE') or die("Access Denied.");
	$content = $controller->getContent();
	
	
	
	$pkg = Package::getByHandle('infusion');
		
	//now load the infusion api
	Loader::model('Groups',$pkg->getPackageName());
	
	$groups = new InfusionGroupsModel();
	
	$ContactData = array();
	
	$ContactData["FirstName"]  = 'Nore';
	$ContactData["LastName"]  = 'Gabbidon';
	$ContactData["Email"] ='noregabbidon@hotmail.com';
	/*$ContactData["Phone1"]  = $form->getRequestValue("Contact0Phone1");
	$ContactData["StreetAddress1"]  = $form->getRequestValue("Contact0StreetAddress1");
	$ContactData["StreetAddress2"]  = $form->getRequestValue("Contact0StreetAddress2");
	$ContactData["City"]  = $form->getRequestValue("Contact0City");
	$ContactData["State"]  = $form->getRequestValue("Contact0County");
	$ContactData["Country"]  = $form->getRequestValue("Contact0Country");
	$ContactData["PostalCode"]  = sprintf("%s %s",$form->getRequestValue("Contact0PostalCode"),$form->getRequestValue("Contact0PostalCode2"));
 	*/		
	
	
	$done = $groups->updateInfusionContact(0,'noregabbidon@hotmail.com',$ContactData);
	
	
	if($done)
	{
		print "Hello World";
		
	}
	
	print $content;
	
	
	
	
?>