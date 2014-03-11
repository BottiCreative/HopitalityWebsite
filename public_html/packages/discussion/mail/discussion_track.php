<?php 
if (defined('DISCUSSION_MONITOR_FROM_EMAIL')) {
	$from = array(DISCUSSION_MONITOR_FROM_EMAIL, DISCUSSION_MONITOR_FROM_NAME);
}
$subject = "{$thread_title}: {$title}"; 
$body = t('Dear')." {$name},

{$posterName} ".t('has posted to a discussion you\'re monitoring')." 

".t('Subject').":
{$post_title}

".t('Message').":
{$post_body}

".t('Click the link below to view the discussion').":
{$link}";

if (ENABLE_USER_PROFILES) {

$body .= "

".t('To view')." {$posterName}'s ".t('profile, click the link below').":
{$posterProfile}";

}

$body .= "

".t('Regards');