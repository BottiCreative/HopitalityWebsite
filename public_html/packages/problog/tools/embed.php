<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

$fm = Loader::helper('form');
echo $fm->textarea('embed_code',$embed_code, array('rows'=>'8','cols'=>'42'));
echo '<br/><br/>';
echo '<input type="submit" onClick="doEmbed();" value="Add Code" class="ccm-dialog-close"/>';
?>