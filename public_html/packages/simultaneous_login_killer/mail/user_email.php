<?php   defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

$subject = t("Your %s account was deactivated", SITE);
$body = t("

Dear %s,

Following what appears to be the repeated use of your account by a third party, we have decided to deactivate it to prevent its fraudulent use by others.

Please contact us as soon as possible through the site %s to deal with this matter.

Thank You!

", $uName, $url);

?>