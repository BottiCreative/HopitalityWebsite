<?php  
defined('C5_EXECUTE') or die(_("Access Denied"));

/**
 * @author 		Nour Akalay (mnakalay)
 * @copyright  	Copyright 2013 Nour Akalay
 * @license     concrete5.org marketplace license
 */

$dbh = Loader::helper('concrete/dashboard');

echo $dbh->getDashboardPaneHeaderWrapper(t('Critical Warning & Help'), t('Critical Warning, Disclaimer & Help'), false, false);
?>
<div class="ccm-list-wrapper ccm-pane-body slk-help">
	<fieldset class="slk-menu">
		<a href="#warning"><?php   echo t("Warning & Disclaimer"); ?></a> | <a href="#principle"><?php   echo t("How it works"); ?></a> | <a href="#requirements"><?php   echo t("Requirements"); ?></a> | <a href="#options"><?php   echo t("Options & Settings"); ?></a>
	</fieldset>
	<fieldset id="warning">

		<legend><?php   echo t("Warning & Disclaimer"); ?></legend>

		<p><?php   echo t("Simultaneous Login Killer (S.L.K.) has an option to automatically deactivate acoounts of users who might be sharing their login credentials. Emphasis is on \"MIGHT\"."); ?> <strong><?php   echo t("Extreme care is advised if you choose to use that option."); ?></strong></p>

		<p><?php   echo t("Under certain circumstances, legitimate behavior might get the user's account deactivated. For example if a user logs in their account from different devices, to S.L.K. it will look like different users. It is then important that you use"); ?> <strong><?php   echo t("sensible settings"); ?></strong> <?php   echo t("for the automatic deactivation feature or that you"); ?> <strong><?php   echo t("disable it altogether."); ?></strong></p>

		<p><?php   echo t("A setting such as: \"deactivate the account if 5 double logins have been flagged in 1 month\" is sure to make many users very upset at you. A user who logs in alternatively from their desktop, their laptop, or their mobile will get deactivated very quickly."); ?></p>

		<p><?php   echo t("A more sensible setting would be: \"deactivate the account if 5 double logins have been flagged in 30 minutes.\" We can then assume that 2 different users might be using the account at the same time. This is of course just an example not to be taken litterally."); ?></p>

		<p><?php   echo t("Ultimately it is up to you to use that automatic deactivation setting or not; and to use it wisely and sensibly."); ?></p>

		<p class="alert-message error"><?php   echo t("IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE."); ?></p>
	</fieldset>

	<fieldset id="principle">

		<legend><?php   echo t("How it works"); ?></legend>

		<p>
			<ul>
				<li><?php   echo t("User A logs in as \"userA\". A session ID \"SessionA\" (simplified example) is created and saved."); ?></li>
				<li><?php   echo t("User B logs in as \"userA\". A session ID \"SessionB\" (simplified example) is created and saved, overwriting \"SessionA\"."); ?></li>
				<li><?php   echo t("User A tries to load a page on your site, S.L.K catches them and logs them out."); ?></li>
				<li><?php   echo t("User B can browse around the site as normal... unless..."); ?></li>
				<li><?php   echo t("User A logs in again as \"userA\". Their new session ID, SessionC is stored and overwrites SessionB."); ?></li>
				<li><?php   echo t("Now user B would be logged out if they load another page."); ?></li>
				<li><?php   echo t("Every time User A or User B is logged out the number of logout is recorded."); ?></li>
			</ul>
		</p>

	</fieldset>

	<fieldset id="requirements">

		<legend><?php   echo t("Requirements"); ?></legend>

		<p class="alert-message error"><?php   echo t("This add-on requires PHP 5.3 and above. It will not work with PHP 5.2 and below."); ?></p>

	</fieldset>

	<fieldset id="options">
		<legend><?php   echo t("Options & Settings"); ?></legend>

		<h4><?php   echo t("Turning S.L.K. on & off"); ?></h4>
		<p><?php   echo t("S.L.K. can be totally turned off and is by default. Don't Forget to turn it on."); ?></p>

		<h4><?php   echo t("Excluding Groups"); ?></h4>
		<p><?php   echo t("It is recommended to exclude at least the Administrators group from being logged out continuously but it really depends on each website's specific characteristics. In any case, the main Admin (Super User) will not be flagged and logged out."); ?></p>

		<h4><?php   echo t("Redirecting on Logout"); ?></h4>
		<p><?php   echo t("When a user is logged out the default behaviour depends on the situation:"); ?>
		<ol>
			<li><?php   echo t("The user was viewing a public page when logged out:"); ?><br>
			<span><?php   echo t("The user remains on the page."); ?></span>
			</li>
			<li><?php   echo t("The user was viewing a private page when logged out:"); ?><br>
			<span><?php   echo t("The user is taken to the log-in page."); ?></span>
			</li>
		</ol>
		<?php   echo t("Alternatively, you can use this setting to redirect the user to any page of your choice."); ?>
		</p>

		<h4><?php   echo t("Account deactivation"); ?></h4>
		<p><?php   echo t("See Warning & Disclaimer above."); ?></p>

		<h4><?php   echo t("Deactivation timing"); ?></h4>
		<p><?php   echo t("You can set accounts to be deactivated after a certain number of simultaneous logins in a certain time span."); ?></p>
		<p><?php   echo t("If you leave the time field empty, the system will only take into account the number of logouts and not the time span. Say you set the number to 5, the account will be deactivated after 5 logouts whatever the time span."); ?></p>
		<p><strong><?php   echo t("As expressed in Warning & Disclaimer above, you should be careful with the values you put in these fields."); ?></strong></p>

		<h4><?php   echo t("Fair warning"); ?></h4>
		<p><?php   echo t("Some time before deactivating an account you can choose to give the user a fair warning. The warning will be a modal popup with a heading, a text, and a captcha to solve before being able to close the popup just to make sure they pay attention."); ?></p>
		<p><?php   echo t("You choose how many logouts should happen before the warning (within the same time span set for deactivation) and you write a heading and a message for the popup, both optional"); ?></p>

		<h4><?php   echo t("Default warning"); ?></h4>
		<p><?php   echo t("The default warning to the user reads:"); ?></p>
		<p class="alert-message notice"><?php   echo t("Heading: Suspicious Activity Detected!"); ?></p>
		<p class="alert-message notice"><?php   echo t("Dear {User name},"); ?><br><br>

			<?php   echo t("it seems your account is being used by more than one person. As a result you and those other users have already been logged out {Number of logouts} time(s) in less than {Time frame}."); ?><br><br>

			<?php   echo t("If this goes on, we will have no choice but to deactivate your account."); ?><br><br>

			<?php   echo t("If you feel this warning is unjustified and you have no knowledge of others using your login credentials, please contact us as soon as possible to allow us to deal with the situation accordingly."); ?><br><br>

			<?php   echo t("Thank you for your understanding."); ?>
		</p>

		<h4><?php   echo t("Notification Emails"); ?></h4>
		<p><?php   echo t("Whenever an account is deactivated, you can choose to have emails sent to the account's owner and to the Admin. Both are optional."); ?></p>
		<p><?php   echo t("If you choose to send an email to the account's owner, you have the choice between the default template and writing your own email. Simply leaving the email message field empty will force the system to use the default template."); ?></p>

		<h4><?php   echo t("Default emails"); ?></h4>
		<p><?php   echo t("The default email to the user reads:"); ?></p>
		<p class="alert-message notice"><?php   echo t("Subject: Your {site's name} account was deactivated"); ?></p>
		<p class="alert-message notice"><?php   echo t("Dear {User name},"); ?><br><br>

			<?php   echo t("Following what appears to be the repeated use of your account by a third party, we have decided to deactivate it to prevent its fraudulent use by others."); ?><br><br>

			<?php   echo t("Please contact us as soon as possible through the site {site's address} to deal with this matter."); ?><br><br>

			<?php   echo t("Thank You!"); ?>
		</p>

				<h4><?php   echo t("Email and warning text variables"); ?></h4>
		<p><?php   echo t("If you write custom email and warning messages, there are 4 variables for emails and 3 for warnings that you can use in your text. These variables will be automatically replaced by their value when the email is sent or the warning is shown. These variables are:"); ?></p>
		<ul>
			<li><?php   echo t("!!userName!!"); ?><br>
				<span><?php   echo t("Automatically replaced by the user's name."); ?></span>
			</li>
			<li><?php   echo t("!!userEmail!!"); ?><br>
				<span><?php   echo t("Automatically replaced by the user's email."); ?></span>
			</li>
			<li><?php   echo t("!!nbrLogouts!!"); ?><br>
				<span><?php   echo t("Automatically replaced by the number of logouts for that user to date."); ?></span>
			</li>
			<li><?php   echo t("!!timeFrame!!"); ?><br>
				<span><?php   echo t("Automatically replaced by the time frame you set in the deactivation parameters."); ?></span>
			</li>
		</ul>

		<h4><?php   echo t("Redirecting on deactivation"); ?></h4>
		<p><?php   echo t("When a user's account is deactivated the default behaviour is the same as when logged out since the user will be logged out before the account is deactivated."); ?></p>
		<p><?php   echo t("When attempting to log back in, Concrete5 will show a message stating that the account was deactivated;"); ?></p>
		<p><?php   echo t("Here you can specify a page to redirect the user to upon deactivation."); ?></p>

		<h4><?php   echo t("Delete user data"); ?></h4>
		<p><?php   echo t("When a user is logged out or their account deactivated, data is saved for statistical purposes in a database table."); ?></p>
		<p><?php   echo t("If you decide later on to delete that user account manually you can choose to keep or delete that statistical data."); ?></p>
		<p><?php   echo t("If you keep it, when looking at SLK's statistics, those users will be presented as having been deleted to distinguish them from active users."); ?></p>

	</fieldset>
	</div>
	<?php  
echo $dbh->getDashboardPaneFooterWrapper(false);?>
<style>
	.slk-help {position: relative;}
	.slk-help li span {padding-left: 15px;}
	.slk-help .slk-menu { display: block; padding: 15px 0; text-align: center; margin-bottom: 15px; border: 1px solid #000; background-color:rgba(0,0,0,0.5); -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #fff; width: 500px; position: fixed; top: 55px; left:50%; margin-left: -250px;}
	.slk-help .slk-menu a { display: inline; padding: 5px 8px;color: #fff;}
</style>
<script>
$(function() {
	$('.slk-help').find('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top-60
				}, 500);
				return false;
			}
		}
	});
});
</script>