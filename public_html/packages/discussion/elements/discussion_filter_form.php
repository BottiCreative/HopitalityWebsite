<?php  
$f = Loader::helper('form');
$dh = Loader::helper('form/date_time');
global $c;
?>
<div class="ccm-filter-discussions">
<form method="get" action="<?php echo DIR_REL?>/index.php">
<?php echo $f->hidden('cID', $c->getCollectionID());?>
<?php echo t('Between')?>
<?php echo $dh->date('cDiscussionStartDate', '')?>
<?php echo t('and')?>
<?php echo $dh->date('cDiscussionEndDate', '')?>


<div class="ccm-sort-discussions">
<?php echo t('Sort By')?>

<?php 
$values = array(
	'most_recent_post' => t('Most Recent Post'),
	'most_recent_topic' => t('Most Recent Topic'),
	'unanswered' => t('Unanswered')
);

print $f->select('cDiscussionSortBy', $values); ?>

<?php echo $f->submit('cSubmitSearch', t('Search'))?>

</div>


</form>
</div>