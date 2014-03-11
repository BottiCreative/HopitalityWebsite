<?php 
//$from = array( , );
//$subject = "";
$body = t("A message has been sent to you by")." \"{$senderUserName}\" ".t('through your profile on')." Concrete5.org 

".t('Message').":
{$message}

".t('To view this user\'s profile, visit').":
{$senderProfileURL}

".t('To disable any future messages, change your profile preferences at').":
{$profilePrefsURL}

".t('Regards').",
".t('C5 Team')."
";