<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$subject = SITE." - ".t("Order# %s Files available for download",$orderID);

$body = array();
$body[] = t("The following files are available for download");
$body[] = '';

foreach($downloads as $download) {
	$body[] = $download['name'];
	$body[] = "\t".BASE_URL.$download['url'];
	$body[] = '';
}

$body[] = '';
$body[] = t('Thank you for your order!');

$body = implode("\n",$body);
