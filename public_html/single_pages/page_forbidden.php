<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>


<div class="forbiddenWrapper">
        <?php  
        	$a = new GlobalArea('Forbidden Register Message');
        	$a->display();
         ?>
</div>

<a href="<?php echo DIR_REL?>/" class="ForbiddhomeLink"><?php echo t('Back to Home')?></a>
