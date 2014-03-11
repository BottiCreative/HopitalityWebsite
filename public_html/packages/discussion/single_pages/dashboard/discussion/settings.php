<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Discussion Settings'), false, false, false);?>
<form method="post" action="<?php echo $this->action('save')?>" id="ccm-discussion-settings-settings-form">
	<div class="ccm-pane-body">

<fieldset>
	<legend><?php echo t('Display')?></legend>
	<div class="clearfix">
		<label><?php echo t('Default Mode')?></label>
		<div class="input">
			<ul class="inputs-list">
				<li>
					<label><?php echo $form->radio('GLOBAL_DISPLAY_MODE', 'flat', $pkg->config('GLOBAL_DISPLAY_MODE'))?> <span><?php echo t('Flat.')?></span></label>
				</li>
				<li>
					<label><?php echo $form->radio('GLOBAL_DISPLAY_MODE', 'threaded', $pkg->config('GLOBAL_DISPLAY_MODE'))?> <span><?php echo t('Threaded.')?></span></label>
				</li>
			</ul>
		</div>
	</div>


<?php 
$options = array(
	'cvName' => t('Topic Name'),
	'cvDatePublic' => t('Topic Date'),
	'cvDatePublicLastPost' => t('Latest Reply'),
	'totalViews' => t('Views'),
	'totalPosts' => t('Replies')
);
?>
<div class="clearfix">
	<label><?php echo t('Sort Topics By')?></label>
	<div class="input">
		<?php echo $form->select('GLOBAL_TOPIC_SORT_MODE', $options, $pkg->config('GLOBAL_TOPIC_SORT_MODE'))?> 
		<?php echo $form->select('GLOBAL_TOPIC_SORT_MODE_DIR', array('asc' => t('Ascending'), 'desc' => t('Descending')), $pkg->config('GLOBAL_TOPIC_SORT_MODE_DIR'))?>	
	</div>
</div>

<div class="clearfix">
	<label><?php echo t('Badges')?></label>
	<div class="input">
		<ul class="inputs-list">
			<li>
				<label><?php echo $form->checkbox('ENABLE_BADGES_OVERLAY', 1, $pkg->config('ENABLE_BADGES_OVERLAY'))?> <span><?php echo t('Display badges overlay when hovering over user avatars.')?></span></label>
			</li>
			<li>
				<label><?php echo $form->checkbox('ENABLE_BADGES_PROFILE', 1, $pkg->config('ENABLE_BADGES_PROFILE'))?> <span><?php echo t('Display badges on user profiles (User profiles must be enabled.)')?></span></label>
			</li>
		</ul>
	</div>
</div>
</fieldset>


<script language="javascript">
function anonPostingEnabled() {
	if($('#ENABLE_ANON_POSTING').attr('checked') || $('#ENABLE_ANON_POSTING_REPLIES').attr('checked')){ 
		$('#ccm-anon-posting-settings').show(); 
	} else { 
		$('#ccm-anon-posting-settings').hide(); 
	}	
}
</script>


<fieldset>
	<legend><?php echo t('Posting')?></legend>
	<div class="clearfix">
		<label><?php echo t('Anonymous Posting')?></label>
		<div class="input">
			<ul class="inputs-list">
				<li>
					<label><?php echo  $form->checkbox('ENABLE_ANON_POSTING', 1, $pkg->config('ENABLE_ANON_POSTING'),array('onclick'=>'anonPostingEnabled();'))?> <span><?php echo t('Enable Anonymous Posting (new posts)')?></span></label>
					<ul class="inputs-list"  id="ccm-anon-posting-settings" <?php  echo ($pkg->config('ENABLE_ANON_POSTING') || $pkg->config('ENABLE_ANON_POSTING_REPLIES')?'':'style="display:none;"' ) ?>>
						<li><label><?php echo $form->checkbox('ANON_POSTING_CAPTCHA_REQUIRED', 1, $pkg->config('ANON_POSTING_CAPTCHA_REQUIRED'))?> <span><?php echo t('Solving Captcha is Required to Post')?></span></label></li>
						<li><label><?php echo $form->checkbox('ANON_POSTING_ATTACHMENTS', 1, $pkg->config('ANON_POSTING_ATTACHMENTS'))?> <span><?php echo t('Allow Anonymous Posters To Attach Files')?></span></label></li>
					</ul>
				</li>
				<li>
					<label><?php echo $form->checkbox('ENABLE_ANON_POSTING_REPLIES', 1, $pkg->config('ENABLE_ANON_POSTING_REPLIES'),array('onclick'=>'anonPostingEnabled();'))?> <span><?php echo t('Enable Anonymous Replies')?></span></label>
				</li>
			</ul>
		</div>
	</div>
	
	
	<div class="clearfix">
		<label><?php echo t('Posting Method Form')?></label>
		<div class="input">
			<ul class="inputs-list">
				<li>
					<label><?php echo $form->radio('GLOBAL_POSTING_METHOD', 'overlay', $pkg->config('GLOBAL_POSTING_METHOD'))?> <span><?php echo t('Overlay.')?></span></label>
				</li>
				
				<li>
					<label><?php echo $form->radio('GLOBAL_POSTING_METHOD', 'in_page', $pkg->config('GLOBAL_POSTING_METHOD'))?> <span><?php echo t('Within the page.')?></span></label>
				</li>
				
			</ul>
		</div>
	</div>
	
</fieldset>

<fieldset>
	<legend><?php echo t('Moderation')?></legend>
	<div class="clearfix">
		<label><?php  echo t('Moderate')?></label>
		<div class="input">
			<ul class="inputs-list">
				<li>
					<label><?php echo $form->radio('MODERATION_TYPE', 'all', $pkg->config('MODERATION_TYPE'))?> <span><?php echo t('All Posts')?></span></label>
				</li>
				<li>
					<label><?php echo $form->radio('MODERATION_TYPE', 'anon', $pkg->config('MODERATION_TYPE'))?> <span><?php echo t('Only Posts by Anonymous Users')?></span></label>
				</li>
				<li>
					<label><?php echo $form->radio('MODERATION_TYPE', 'none', $pkg->config('MODERATION_TYPE'))?> <span><?php echo t('Don\'t Moderate Any Posts')?></span></label>
				</li>
				<li><span class="help-block"><?php  echo t('Posts by users in the following groups will not be moderated: Administrators, No_Moderation')?></span></li>
			</ul> 
		</div>
	</div>
	<div class="clearfix">
		<label><?php  echo t('Moderator Email')?></label>
		<div class="input"><?php  echo $form->text('MODERATOR_EMAIL',$pkg->config('MODERATOR_EMAIL'))?></div>
		<div class="input"><span class="help-block"><?php  echo t('Email will be sent to moderator when posts requiring moderation are submitted, leave blank for no notification.')?></span></div>
	</div>
	<div class="clearfix">
		<label><?php echo t('Content Filtering')?></label>
		<div class="input">
			<ul class="inputs-list">
				<li><label><?php echo $form->radio('FILTER_BANNED_WORDS', 0, $pkg->config('FILTER_BANNED_WORDS'))?> <span><?php echo t('Do not check posts for banned content.')?></span></label></li>
				<li>
					<label><?php echo $form->radio('FILTER_BANNED_WORDS', 1, $pkg->config('FILTER_BANNED_WORDS'))?> <span><?php echo t('Disallow posts that contain words in the banned words file.')?></span></label>
					<span class=help-block><?php  echo t('Typical location of this file:')?> "config/banned_words.txt"</span>
				</li>
			</ul>
		</div>
	</div>
</fieldset>
<?php  //DISCUSSION_MULTILINGUAL_ENABLED
if(Loader::helper('discussion_config','discussion')->isMultilingualInstalled()) { ?>
<fieldset><legend><?php  echo t('Internationalization')?></legend>
	<div class="clearfix">
		<div class="input">
			<ul class="inputs-list">
				<li>
					<label><?php echo $form->checkbox('DISCUSSION_MULTILINGUAL_ENABLED', 1, $pkg->config('DISCUSSION_MULTILINGUAL_ENABLED'))?> <span><?php echo t('Track the language that users post from.')?></span></label>
					<span class=help-block><?php  echo t('Posted language will be displayed for any user not posting from the site\'s default language interface')?></span>
				</li>
			</ul>
		</div>
	</div>
</fieldset>
<?php  } ?>

<br/>
</div>
<div class="ccm-pane-footer">
	<?php  echo $concrete_interface->submit(t('Save'),'Save','right', 'primary')?>
</div>
</form>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>