<?php      defined('C5_EXECUTE') or die("Access Denied.");
	Events::extendPageType('user_blog_post', 'on_page_add');
	Events::extendPageType('user_blog_list', 'on_page_add');
?>