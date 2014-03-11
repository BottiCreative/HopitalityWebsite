<?php      
$fm = Loader::helper('form');  
$pgp=Loader::helper('form/page_selector');
?>
<style type="text/css">
table td{padding: 12px!important;}
</style>
<div class="ccm-ui">
	<?php      echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t($title.' Blog'), false, false, false);?>
	<div class="ccm-pane-body">
		<!--
		<ul class="breadcrumb">
		  <li><a href="/index.php/dashboard/problog/list/">List</a> <span class="divider">|</span></li>
		  <li><a href="/index.php/dashboard/problog/add_blog/">Add/Edit</a> <span class="divider">|</span></li>
		  <li><a href="/index.php/dashboard/problog/comments/">Comments</a> <span class="divider">|</span></li>
		  <li class="active">Settings </li>
		</ul>
		-->
		<h4><?php       echo t('Options')?></h4> 
		<div id="settings_adds" style="float: right; width: 310px;">
			<a href="http://chadstrat.com/apps/problogmobile/" target="_blank"><img src="http://chadstrat.com/apps/problogmobile/images/promo.png" alt="phone" style="float: left; padding-right: 15px;"/></a>
			<strong><?php      echo t('ProBlog Mobile')?></strong>
			<p><?php      echo t('Don\'t forget to check out ProBog Mobile iPhone & iPad native app in the Apple App Store for $4.99!')?></p>
			<p><?php      echo t('Blog on the go and include phone photos and geo-tagging for the ultimate photo-blogging experience!')?></p>
			<a href="http://chadstrat.com/apps/problogmobile/" target="_blank"><img src="http://chadstrat.com/apps/problogmobile/images/app_store.gif" alt="store" style="width: 140px!important;"/></a>
		</div>
		<form method="post" action="<?php       echo $this->action('save')?>" id="settings" style="width: 480px!important;">
		<table>
			<tr>
				<td colspan="2"><strong><?php      echo t('Show')?></strong></td>
			</tr>
			<tr>
				<td>
					<input name="tweet" type="checkbox" value="1" <?php       if($tweet==1){echo ' checked';}?> /> <?php      echo t('Twitter')?>
				</td>
				<td>
					<input name="google" type="checkbox" value="1" <?php       if($google==1){echo ' checked';}?> /> <?php      echo t('Google +1')?>
				</td>
				<td>
					<input name="fb_like" type="checkbox" value="1" <?php       if($fb_like==1){echo ' checked';}?> /> <?php      echo t('Facebook Like')?>
				</td>
			</tr>
			<tr>
				<!--
				## - 07/18/11
				## Depreicated.  Slow loading time, and distracts from lower sharing options
				##
				<td>
					<input name="addthis" type="checkbox" value="1" <?php       if($addthis==1){echo ' checked';}?> /> Addthis
				</td>
				-->
				<td>
					<input name="author" type="checkbox" value="1" <?php       if($author==1){echo ' checked';}?> /> <?php      echo t('Author Info')?>
				</td>
				<td>
					<input name="comments" type="checkbox" value="1" <?php       if($comments==1){echo ' checked';}?> /> <?php      echo t('Comments')?>
				</td>
				<td>
					<input name="trackback" type="checkbox" value="1" <?php       if($trackback==1){echo ' checked';}?> /> <?php      echo t('Pingback')?>
				</td>
			</tr>
		</table>
		<br/>

		<br/>
		<h4><?php      echo t('Publishing Settings')?></h4>
		<div style="width: 380px;">
			<table id="settings3" class="ccm-grid" style="width: 380px;">
				<tr>
					<th class="header">
					<strong><?php       echo t('Enable Canonical URLS')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<input name="canonical" type="checkbox" value="1" <?php       if($canonical==1){echo ' checked';}?> /> <?php      echo t('Yes')?> <br/>
					<i><?php    echo t('Automatically publish pages by year and month. (/blog/2013/06/my-blog-post)')?></i>
					</td>
				</tr>
				<tr>
					<th class="header">
					<strong><?php       echo t('Default Page Type')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<?php       echo $fm->select('ctID', $pageTypes, $ctID)?>
					</td>
				</tr>
			</table>
		</div>
		
		<br/>
		<h4><?php      echo t('Content')?></h4>
		<div style="width: 380px;">
			<table id="settings3" class="ccm-grid" style="width: 380px;">
				<tr>
					<th class="header">
					<strong><?php       echo t('Page Break for Post Preview')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<?php       echo $fm->text('breakSyntax',$breakSyntax);?>
					</td>
				</tr>
			</table>
		</div>
		
		<br/>
		<h4><?php      echo t('Blog Path Settings')?></h4>
		<div style="width: 380px;">
			<table id="settings2" class="ccm-grid" style="width: 380px;">
				<tr>
					<th class="header">
					<strong><?php      echo t('Tags/Categories Search Results Location')?></strong>
					</th>
				</tr>
				<tr>
					<td>
						<?php       
						echo $pgp->selectPage('search_path',$search_path);
						?>
					</td>
				</tr>
				<tr>
					<th class="header">
					<strong><?php      echo t('Mobile Posts Location')?></strong>
					</th>
				</tr>
				<tr>
					<td>
						<?php       
						echo $pgp->selectPage('mobile_path',$mobile_path);
						?>
					</td>
				</tr>
			</table>
		</div>
		
		<br/>
		<h4><?php      echo t('Blog List Settings')?></h4>
		<div style="width: 380px;">
			<table id="settings3" class="ccm-grid" style="width: 380px;">
				<tr>
					<th class="header">
					<strong><?php      echo t('Icon Color')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<select name="icon_color">
						<option value="green" <?php       if($icon_color=='green'){echo ' selected';}?>>green</option>
						<option value="pink" <?php       if($icon_color=='pink'){echo ' selected';}?>>pink</option>
						<option value="red" <?php       if($icon_color=='red'){echo ' selected';}?>>red</option>
						<option value="blood" <?php       if($icon_color=='blood'){echo ' selected';}?>>blood red</option>
						<option value="darkblue" <?php       if($icon_color=='darkblue'){echo ' selected';}?>>dark blue</option>
						<option value="babyblue" <?php       if($icon_color=='babyblue'){echo ' selected';}?>>baby blue</option>
						<option value="grey" <?php       if($icon_color=='grey'){echo ' selected';}?>>grey</option>
						<option value="tan" <?php       if($icon_color=='tan'){echo ' selected';}?>>tan</option>
						<option value="brown" <?php       if($icon_color=='brown'){echo ' selected';}?>>brown</option>
					</select>
					<br/><br/>
					<i><?php      echo t('(for the default bloglist veiw only.)')?></i>
					</td>
				</tr>
				<tr>
					<th class="header">
					<strong><?php      echo t('Max Thumbnail Width')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<?php       
					echo $fm->text('thumb_width',$thumb_width,array('size'=>'2'));
					echo 'px';
					?>
					</td>
				</tr>
				<tr>
					<th class="header">
					<strong><?php      echo t('Max Thumbnail Height')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<?php       
					echo $fm->text('thumb_height',$thumb_height,array('size'=>'2'));
					echo 'px';
					?>
					</td>
				</tr>
			</table>
		</div>

		<br/>
		<h4><?php      echo t('API Settings')?></h4>
		<div style="width: 380px;">
			<table id="settings3" class="ccm-grid">
				<tr>
					<th class="header">
					<strong><?php       echo t('Sharethis Publisher Key')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<?php       echo $fm->text('sharethis', $sharethis)?>
					<br/><br/>
					<i><?php      echo t('grab your publisher key <a href="http://sharethis.com/account/" target="_blank">http://sharethis.com/account/</a> in your account area.  track your social impact for free.')?></i>
					</td>
				</tr>
				<tr>
					<th class="header">
					<strong><?php      echo t('Disqus Short Name (case sensitive)')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<?php       
					echo $fm->text('disqus',$disqus,array('size'=>'2'));
					?>
					<br/><br/>
					<i><?php      echo t('Entering this value will set your comments, comment counts, and latest comments block to the Disqus comments system.  Simply remove this value if you desire to use guestbook and/or advanced guestbook.')?></i>
					</td>
				</tr>
				<tr>
					<th class="header">
					<strong><?php       echo t('embed.ly API Key')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<?php       echo $fm->text('embedly', $embedly)?>
					<br/><br/>
					<i><?php      echo t('grab your API key <a href="http://embed.ly/" target="_blank">http://embed.ly</a> in your account area for free & embed pretty much anything!')?></i>
					</td>
				</tr>
				<tr>
					<th class="header">
					<strong><?php      echo t('Enable Twitter Option')?></strong>
					</th>
				</tr>
				<tr>
					<td>
					<?php     	
					Loader::library('oAuth','problog');
					Loader::library('twitteroauth','problog');
					
					$pkg = Package::getByHandle('problog');
					$PB_AUTH_TOKEN = $pkg->config('PB_AUTH_TOKEN');
					$PB_AUTH_SECRET = $pkg->config('PB_AUTH_SECRET');
					$PB_APP_KEY = $pkg->config('PB_APP_KEY');
					$PB_APP_SECRET = $pkg->config('PB_APP_SECRET');
					$uh = Loader::helper('concrete/urls');
					$tool = str_replace('index.php/','',BASE_URL.$uh->getToolsUrl('twitter_save.php?', 'problog'));
					if(!$PB_APP_KEY){
						$pkg->saveConfig('PB_APP_KEY','MfUJJrhZDXHUsvbVSf2Ag');
						$pkg->saveConfig('PB_APP_SECRET','uhvYCtKCNSdHGYvwNwu80rkw5Ju53f5jhaLPMAgK0');
						$PB_APP_KEY = $pkg->config('PB_APP_KEY');
						$PB_APP_SECRET = $pkg->config('PB_APP_SECRET');
					}
					if(!$PB_AUTH_TOKEN){
						$connection = new TwitterOAuth($PB_APP_KEY, $PB_APP_SECRET);
						$temporary_credentials = $connection->getRequestToken($tool);
						$_SESSION['oauth_token'] = $temporary_credentials['oauth_token'];
						$_SESSION['oauth_token_secret'] = $temporary_credentials['oauth_token_secret'];
						$redirect_url = $connection->getAuthorizeURL($temporary_credentials,FALSE);
						echo '<a href="' . $redirect_url . '" class="btn info">'.t('Authorize with Twitter').'</a>';
					}else{
						$connection = new TwitterOAuth($PB_APP_KEY, $PB_APP_SECRET, $PB_AUTH_TOKEN, $PB_AUTH_SECRET);
						$content = $connection->get('account/verify_credentials');
						$username = $content->screen_name;
						$profilepic = $content->profile_image_url;
						echo '</br/>';
						echo t('You are connected to twitter as').': <br/><br/><img src="'.$profilepic.'" width="22px"/> <a href="https://twitter.com/#!/'.$username.'">'.$username.'</a>';
						echo '<a href="'.$this->action('clear_twitter').'" class="btn danger ccm-button-v2-right">'.t('Clear').'</a>';
					}
					
					?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="ccm-pane-footer">
    	<?php       $ih = Loader::helper('concrete/interface'); ?>
        <?php       print $ih->submit(t('Save Settings'), 'settings', 'right', 'primary'); ?>
        </form>
    </div>
</div>