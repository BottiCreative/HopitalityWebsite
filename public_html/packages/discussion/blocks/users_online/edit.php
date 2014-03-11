<div class="ccm-block-field-group">
<?php echo $form->label('minutesSinceLastOnline', 'Show online in last [how many?] minutes');?>
<?php echo $form->text('minutesSinceLastOnline',  $minutesSinceLastOnline, array('style' => 'width: 100'));?>
<div class="ccm-block-field-note">(<?php echo t('Note: for best results, set this greater than')?> <?php echo ONLINE_NOW_TIMEOUT / 60?>.)</div>

</div>

<div class="ccm-block-field-group">
<?php echo $form->label('maxUsersToShow', t('Maximum number of users to display'));?>
<?php echo $form->text('maxUsersToShow',  $maxUsersToShow, array('style' => 'width: 100px'));?>
</div>

<!-- 
<?php echo $form->label('content', t('Name'));?>
<?php echo $form->text('content', $content, array('style' => 'width: 320px'));?>

<?php echo $form->label('content2', t('More Content'));?>
<?php echo $form->text('content2', $content2, array('style' => 'width: 300px'));?>
 -->