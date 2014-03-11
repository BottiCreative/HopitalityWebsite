<?php   defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

$subject = t("%s account deactivated", SITE);
$body = t("

Dear Admin,

User %s's account on %s was deactivated due to several simultaneous login.

Their email is %s.

Sincerely,
Simultaneous Login Killer

", $uName, SITE, $uEmail);

?>