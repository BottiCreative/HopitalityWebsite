<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('oAuth','problog');
Loader::library('twitteroauth','problog');


$PB_APP_KEY = $pkg->config('PB_APP_KEY');
$PB_APP_SECRET = $pkg->config('PB_APP_SECRET');


/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth($PB_APP_KEY, $PB_APP_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);


/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $access_token;


/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);


$pkg = Package::getByHandle('problog');
$pkg->saveConfig('PB_AUTH_TOKEN',$access_token['oauth_token']);
$pkg->saveConfig('PB_AUTH_SECRET',$access_token['oauth_token_secret']);


header('Location: '.BASE_URL.'/index.php/dashboard/problog/settings/');
?>





