<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $ih = Loader::helper('concrete/interface'); ?>
<?php Loader::element('editor_init'); ?>
<?php Loader::element('editor_config'); ?>
<?php //Loader::element('editor_controls'); ?>
<?php $form = Loader::helper('form'); ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t($title), false, false, false)?>



<div class="ccm-pane-body">
<?php 



if($this->controller->getTask() == 'update_member_email') 
{


	
 ?>
<form id="form1" method="post" action="<?php echo $form->action("/dashboard/moomusic/members/update_member_email",'update') ?>">

<p><?php echo t('This is the email that gets sent to Moo Music Members just after they purchase their first area and become a member.');?></p>
<p><?php echo t('The following tags (in square brackets) can be used with this email:'); ?></p>
<ul>
	<li>Link to Login Page: [loginlink]</li>
	<li>Username of Member: [username]</li>
	<li>Password of Member: [password]</li>
	
</ul>
<?php



echo $form->textarea('content', $member_email, array('style' => 'width:100%;', 'class' => 'ccm-advanced-editor'));

echo $form->submit('frmSubmit','Update Member Email');
?>

</form>


<?php 

}
elseif($this->controller->getTask() == 'update_license') 
{


	
 ?>
<form id="form1" method="post" action="<?php echo $form->action("/dashboard/moomusic/members/update_license",'update') ?>">

<p><?php echo t('This is the license that gets sent to Moo Music Members just after they purchase their area and become a member.');?></p>
<p><?php echo t('The following tags (in square brackets) can be used with this email:'); ?></p>
<ul>
	<li>Name of member: [name]</li>
	<li>Member Address: [address]</li>
	<li>Area(s) purchased: [areas]</li>
	<li>Day of order: [orderday]</li>
	<li>Month of order: [ordermonth]</li>
	<li>Year of order: [orderyear]</li>
	
	
</ul>
<?php



echo $form->textarea('content', $member_license, array('style' => 'width:100%;', 'class' => 'ccm-advanced-editor'));

echo $form->submit('frmSubmit','Update License');
?>

</form>


<?php 

}
else 
{

//view		
echo $ih->button('Update Member Email',$this->url('/dashboard/moomusic/members','update_member_email'), 'left');
echo $ih->button('Update Member License',$this->url('/dashboard/moomusic/members','update_license'), 'left');

?>



<?php

}

?>
	
</div>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>