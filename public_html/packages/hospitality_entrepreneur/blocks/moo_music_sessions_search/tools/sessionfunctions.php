<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<?php

Loader::helper('validation/strings');

$userID = $_GET['uID'];
$message = $_GET['Message'];
$subject = 'Moo Music Session Enquiry - ' . $_GET['Subject'];
$name = $_GET['Name'];
$email = $_GET['Email'];
$user = UserInfo::getByID($userID);

$validation = new ValidationStringsHelper();

//check if email valid.
if(!$validation->email($email))
{
	echo 'Email address is not valid.  Please enter a valid email address';
	exit;
}
if(empty($name))
{
	echo 'Please enter your name';
	exit;
	
}


$mail = Loader::helper('mail');	
$mail->setSubject($subject);
$mail->from($email,$name);
$mail->to($user->getUserEmail());
$mail->setBody($message);
$mail->sendMail();

exit();



?>




