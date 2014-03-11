<?php       defined('C5_EXECUTE') or die("Access Denied."); ?>
<style type="text/css">
span.error{color: red; text-align: left; width: 500px!important; margin: 12px 0px; float: left;}
</style>
<?php     
$ub_page = Page::getByPath('/profile/user_blog');
if(!$ub_page->cID){
	echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('User Blog Settings'), false, false, false);
	?>
		<div class="ccm-pane-body">
			<form method="post" action="<?php      echo $this->action('install_userblogs')?>" name="settings">
			<?php     
				echo '<h4>'.t('Install User Blogs?').'</h4>';
				echo '<br/><p>'.t('ProBlog now includes and optional install of UserBlogs.  UserBlogs enables individual blogging for each user from the convienience of their User Profile page.  UserBlogs provides several enhancements such as integration with Concrete Wall, front-end user blogging interface, and user specific Blog URLS. Primarily for use with Public Profile websites').'</p>';
				echo '<p>'.t('Installing UserBlogs will do the following:').'</p>';
				echo '<ul>';
				echo ' <li>'.t('disable caching for proper install (you can re-enable afterwards)').'</li>';
				echo ' <li>'.t('enable public profiles if they are not already active').'</li>';
				echo ' <li>'.t('install UserBlogs Package').'</li>';
				echo '</ul>';
				echo '<p>'.t('Installing UserBlogs will not effect any existing blog content you have on your site.').'<p>';
				echo '<p>'.t('Would you like to install UserBlogs with your ProBlog install?').'</p><br/>';
				echo '<span class="error">';
				echo ' * * * *  '.t('!!!ALERT!!!').' * * * * ';
				echo '<br/>';
				echo '<br/>';
				echo t('THIS PORTION OF PROBLOG IS IN "ALPHA" STAGE AND NOT RECOMMENDED FOR PRODUCTION.  AKA - WE DO NOT RECOMMEND DELIVERING THIS PORTION OF THE ADDON TO CLIENTS AT THIS TIME.');
				echo '<br/>';
				echo '<br/>';
				echo ' * * * * ';
				echo '</span>';
				echo '<br style="clear: both;"/>';
				echo '<input type="checkbox" name="enable_user_blogs" value="1"/> ';
				echo ' <strong>'.t(' Yes. Please install UserBlogs with my ProBlog install').'</strong>';
			?>
		</div>
		<div class="ccm-pane-footer">
	    	<?php       $ih = Loader::helper('concrete/interface'); ?>
	        <?php       print $ih->submit(t('Install UserBlogs'), 'settings', 'right', 'primary'); ?>
	        </form>
	    </div>
	</div>
<?php     	

}else{

	echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('User Blog Settings'), false, false, false);
	?>
		<div class="ccm-pane-body">
			<form method="post" action="<?php      echo $this->action('save_config_new')?>" name="settings">
			<span style="float: right; color: red;"> * ALPHA STAGE - NOT FOR PRODUCTION * </span>
			<h3><?php         echo t('User Blog Page');?></h3>
			<?php     
			$ph = Loader::helper('form/page_selector');
			$form = Loader::helper('form');
			echo FormPageSelectorHelper::selectPage('user_blog_page', $cID);
			?>
			<p><?php      echo  t("This is the page that all new user blogs will exist under.");?></p>
			
			<br/>
			<h3><?php      echo t('Userblog Name Format');?></h3>
			<?php      $formats = array(
			'username' => t("User Name (/username)"),
			'userid' => t("User ID (/15)"),
			'personname' => t("Person Name (/first-last)")
			);?>
			<?php         echo $form->select("name_format", $formats, $name_format);?>
			<p><?php      echo  t("This is the format that will be used for page paths for newly created user blogs.");?></p>
			
			<br/>
			<h3><?php      echo t('Share With Attribute Default Handle');?></h3>
			<p><?php      echo  t("This is the attribute handle of the attribute that ProBlog will use to filter.");?></p>
			<?php      
			if (!$attribute_handle_share){
			$attribute_handle_share = 'blog_cateogory';
			}
			?>
			<?php      echo $form->text('attribute_handle_share',$attribute_handle_share);?>
			<br/>
			<hr/>
			<div class="">
				<h3><?php     echo t('Some things you\'ll want to consider doing:')?></h3>
				<ul>
				</ul>
			</div>
		</div>
		<div class="ccm-pane-footer">
	    	<?php       $ih = Loader::helper('concrete/interface'); ?>
	        <?php       print $ih->submit(t('Save Settings'), 'settings', 'right', 'primary'); ?>
	        </form>
	    </div>
	</div>
<?php     
}
?>