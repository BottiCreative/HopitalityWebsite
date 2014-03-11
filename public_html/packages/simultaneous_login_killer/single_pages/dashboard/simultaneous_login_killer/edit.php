<?php  
defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

$dbh = Loader::helper('concrete/dashboard');
$nh = Loader::helper('navigation');
$fh = Loader::helper('form');
$ps = Loader::helper('form/page_selector');

$time_unit = array('Minute'=>'Minute', 'Hour'=>'Hour', 'Day'=>'Day', 'Week'=>'Week', 'Month'=>'Month', 'Year'=>'Year');

if ($killer['enabled']) {
	$bdgeClass = 'badge-success';
	$btnText = 'ON';
	$bdgeIcon = '<i class="icon-ok icon-white"></i>';
} else {
	$bdgeClass = 'badge-important';
	$btnText = 'OFF';
	$bdgeIcon = '<i class="icon-off icon-white"></i>';
}
?>
<style type="text/css">
	.slk-status .badge {
		padding: 3px;
		margin: 0 5px 0 0;
	}
	.slk-status {
		padding: 4px 10px 5px 5px;
	}
	.slk-status .icon-white {
		margin: 2px 5px 0 0;
	}
	.slk-status .icon-off, .slk-status .icon-ok {
		padding: 0;
		margin: 0;
	}
	#nbr_logouts {
		margin-right: 5px;
	}
	#time_span {
		margin-left: 5px;
	}
	.slk-form .help-inline.margined {
		margin-top: 5px;
	}
	.slk-form div.ccm-summary-selected-item {
		margin: 0!important;
	}
</style>
<?php  
echo $dbh->getDashboardPaneHeaderWrapper(t('Set your Login Killer'), t('Set your Login Killer'), false, false);
?>

<form class="form-horizontal" action="<?php    echo $this->action('save'); ?>" method="POST">
	<div class="ccm-pane-body slk-form">
		<legend><?php    echo t('Simultaneous Login Killer Settings'); ?></legend>

		<div class="control-group">
			<span class="slk-status"><span class="badge <?php   echo $bdgeClass; ?>"><?php   echo $bdgeIcon; ?></span><?php   echo t('Simultaneous Login Killer is ').'<strong>'.t('%s', $btnText).'</strong>'; ?></span><br /><br />
		</div>

		<div class="control-group">
			<div class="control-label">
				<?php    echo t("Enabled"); ?>
			</div>
			<div class="controls">
				<label class="checkbox">
					<?php    echo $fh->checkbox('enabled', 'enabled', $killer['enabled']); ?>
					<span class="help-inline"><?php    echo t('Turn Simultaneous Login Killer on or off.') ?></span>
				</label>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label"><?php    echo t("Exclude groups"); ?></label>
			<div class="controls">
				<?php    foreach($groups as $gid => $name): ?>
				<p><?php    echo $fh->checkbox('excluded_groups[]', $gid, in_array($gid, $killer['excluded_groups']), null) . ' ' . $name; ?></p>
			<?php    endforeach;?>
		</div>
	</div>

	<div class="control-group">
		<div class="control-label">
			<?php    echo t("Redirect on Logout"); ?>
		</div>
		<div class="controls">
			<label class="checkbox">
				<?php    echo $ps->selectPage('logout_redirect', $killer['logout_redirect']); ?>
				<span class="help-inline margined"><?php    echo t('Redirect the user to a specific page when logged out.') ?></span>
			</label>
		</div>
	</div>

	<div class="control-group">
		<div class="control-label">
			<?php    echo t("Deactivate User account"); ?>
		</div>
		<div class="controls">
			<label class="checkbox">
				<?php    echo $fh->checkbox('disable_account', 'disable_account', $killer['disable_account']); ?>
				<span class="help-inline"><?php    echo t('Deactivate the user account after a certain number of double login attempts.') ?></span>
			</label>
		</div>
	</div>

	<fieldset class="disable-account">

		<div class="control-group">
			<label class="control-label" for="nbr_logouts"><?php    echo t("Deactivate account after"); ?></label>
			<div class="controls controls-row logout-per-time">
				<?php    echo $fh->text('nbr_logouts', $killer['nbr_logouts'], array("class" => "span1")) . t("logouts"); ?>

				<?php    echo t("in less than") . $fh->text('time_span', $killer['time_span'], array("class" => "span1")); ?>
				<?php    echo $fh->select('time_unit', $time_unit, $killer['time_unit'], array("class" => "span2")); ?>
				<span class="help-inline margined"><?php    echo t('The number of logouts per unit of time before an account is deactivated.') ?></span>
			</div>
		</div>

		<div class="control-group">
			<div class="control-label">
				<?php    echo t("Show a fair warning"); ?>
			</div>
			<div class="controls">
				<label class="checkbox">
					<?php    echo $fh->checkbox('fair_warning', 'fair_warning', $killer['fair_warning']); ?>
					<span class="help-inline"><?php    echo t('Show the User a fair warning a bit before their account gets deactivated.') ?></span>
				</label>
			</div>
		</div>

		<fieldset class="fair-warning">
			<div class="control-group">
				<label class="control-label" for="nbr_logouts_warning"><?php    echo t("Number of logouts before fair warning"); ?></label>
				<div class="controls">
					<?php    echo $fh->text('nbr_logouts_warning', $killer['nbr_logouts_warning'], array("class" => "span1")); ?>
					<span class="help-inline margined"><?php    echo t('A number of logouts within the same time frame set for deactivation. Must be inferior to the number of logouts set for deactivation.') ?></span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="warning_heading"><?php    echo t("Warning heading"); ?></label>
				<div class="controls">
					<?php    echo $fh->text('warning_heading', $killer['warning_heading'], array("class" => "span8")); ?>
					<span class="help-inline margined"><?php    echo t('This heading will appear above the message in the warning modal.') ?></span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="warning_message"><?php    echo t("Warning message"); ?></label>
				<div class="controls">
					<?php  
					// Loader::element('editor_config');
					// Loader::element('editor_controls', array('mode'=>'full'));
					echo $fh->textarea('warning_message', $killer['warning_message'], array('rows' => '10', 'class' => 'span8 ccm-advanced-editor'));
					?>
					<span class="help-inline margined"><?php    echo t('This text will be shown the user as a warning. Available variables: !!userName!!, !!nbrLogouts!!, !!timeFrame!!') ?></span>
				</div>
			</div>
		</fieldset>

		<div class="control-group">
			<div class="control-label">
				<?php    echo t("Admin Notification"); ?>
			</div>
			<div class="controls">
				<label class="checkbox">
					<?php    echo $fh->checkbox('email_admin', 'email_admin', $killer['email_admin']); ?>
					<span class="help-inline"><?php    echo t('Send the Admin a notification when a user account gets deactivated.') ?></span>
				</label>
			</div>
		</div>

		<div class="control-group">
			<div class="control-label">
				<?php    echo t("User Notification"); ?>
			</div>
			<div class="controls">
				<label class="checkbox">
					<?php    echo $fh->checkbox('email_user', 'email_user', $killer['email_user']); ?>
					<span class="help-inline"><?php    echo t('Send the User a notification that their account was deactivated.') ?></span>
				</label>
			</div>
		</div>

		<fieldset class="email-user">
			<div class="control-group">
				<label class="control-label" for="email_subject"><?php    echo t("Notification Email Subject"); ?></label>
				<div class="controls">
					<?php    echo $fh->text('email_subject', $killer['email_subject'], array("class" => "span8")); ?>
					<span class="help-inline margined"><?php    echo t('If no message is entered in the field below, this subject will be ignored.') ?></span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="notification_email"><?php    echo t("Notification Email Message"); ?></label>
				<div class="controls">
					<?php    echo $fh->textarea("notification_email", $killer['notification_email'], array("class" => "span8", "rows" => "10")); ?>
					<span class="help-inline margined"><?php    echo t('Email sent to the user. Available variables: !!userName!!, !!userEmail!!, !!nbrLogouts!!, !!timeFrame!!') ?></span>
				</div>
			</div>
		</fieldset>

		<div class="control-group">
			<div class="control-label">
				<?php    echo t("Redirect on Account Deactivation"); ?>
			</div>
			<div class="controls">
				<label class="checkbox">
					<?php    echo $ps->selectPage('disabled_redirect', $killer['disabled_redirect']); ?>
					<span class="help-inline margined"><?php    echo t('Redirect the user to a specific page after their account has been deactivated.') ?></span>
				</label>
			</div>
		</div>
	</fieldset>

	<div class="control-group">
		<div class="control-label">
			<?php    echo t("Delete all user-relevant data on user deletion"); ?>
		</div>
		<div class="controls">
			<label class="checkbox">
				<?php    echo $fh->checkbox('clear_stats', 'clear_stats', $killer['clear_stats']); ?>
				<span class="help-inline"><?php    echo t('All data saved for statistical purposes will be deleted for the user whose account is deleted.') ?></span>
			</label>
		</div>
	</div>

	<?php    echo $vth->output('slk_save_settings'); ?>

</div>
<div class="ccm-pane-footer">
	<a class="btn pull-left" href="<?php    echo $nh->getLinkToCollection(Page::getByPath('/dashboard')); ?>"><?php    echo t('Return to Dashboard'); ?></a>
	<button type="submit" class="btn btn-primary pull-right"><?php    echo t('Save Settings'); ?></button>
</div>
</form>
<?php    echo $dbh->getDashboardPaneFooterWrapper(false);?>

<script>
	$(document).ready(function(){
		//initial checks
		var disable_account = $('input[type="checkbox"][name="disable_account"]'),
		status = $('input[type="checkbox"][name="enabled"]'),
		email_user = $('input[type="checkbox"][name="email_user"]'),
		fair_warning = $('input[type="checkbox"][name="fair_warning"]'),
		all_groups = $('#excluded_groups_All');

		checkStatus(status);
		checkDisableAccount(disable_account);
		checkEmailUser(email_user);
		checkFairWarning(fair_warning);
		checkGroups(all_groups);

		//event handlers
		disable_account.on('change', function(){checkDisableAccount($(this));});
		status.on('change', function(){checkStatus($(this));});
		email_user.on('change', function(){checkEmailUser($(this));});
		fair_warning.on('change', function(){checkFairWarning($(this));});
		all_groups.on('change', function(){checkGroups($(this));});
	});
		//if "All Groups" is checked hide all other group CBs - otherwise show all others
	function checkStatus(chk_status){
		if(chk_status.is(':checked')){
			$('.slk-status')
			.find('.badge')
			.removeClass('badge-important')
			.addClass('badge-success')
			.find('i')
			.removeClass('icon-off')
			.addClass('icon-ok')
			.parent()
			.parent()
			.find('strong')
			.text('ON');

		} else {
			$('.slk-status')
			.find('.badge')
			.removeClass('badge-success')
			.addClass('badge-important')
			.find('i')
			.removeClass('icon-ok')
			.addClass('icon-off')
			.parent()
			.parent()
			.find('strong')
			.text('OFF');
		}
	}

	function checkDisableAccount(chk_disable){
		if(chk_disable.is(':checked')){
			$('fieldset.disable-account').show("slide", {direction: "up"}, 'slow');
		} else {
			$('fieldset.disable-account').hide("slide", {direction: "up"}, 'slow');
		}
	}

	function checkEmailUser(chk_email){
		if(chk_email.is(':checked')){
			$('fieldset.email-user').show("slide", {direction: "up"}, 'slow');
		} else {
			$('fieldset.email-user').hide("slide", {direction: "up"}, 'slow');
		}
	}

	function checkFairWarning(chk_warning){
		if(chk_warning.is(':checked')){
			$('fieldset.fair-warning').show("slide", {direction: "up"}, 'slow');
		} else {
			$('fieldset.fair-warning').hide("slide", {direction: "up"}, 'slow');
		}
	}

	function checkGroups(allGroupsCb){
		var checkboxes = $('input[type="checkbox"][name^="excluded_groups"][id!=excluded_groups_All]');

		if(allGroupsCb.is(':checked')){
			checkboxes.each(function(){
				$(this).removeAttr('checked');
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			checkboxes.each(function(){
				$(this).removeAttr('disabled');
			});
		}
	}
</script>