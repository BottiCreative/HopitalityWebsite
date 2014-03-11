<?php        
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::helper('userblogify','problog');

//-----------------------------------------------------//
//          !!!ATTENTION DEVELOPERS!!!                 //
//-----------------------------------------------------//
//this 'model' is now deprecated
//please use:
//  $userblogify = Loader::helper('userblogify','problog');
//  $var = $userblogify->method();
//-----------------------------------------------------//

class Userblogify Extends UserblogifyHelper{	


}