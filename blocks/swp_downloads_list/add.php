<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));
$this->controller->set("display_columns", "Y");
$this->controller->set("display_filesize", "Y");
$this->inc("edit.php");
?>