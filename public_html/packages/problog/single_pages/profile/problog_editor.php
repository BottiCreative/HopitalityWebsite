<style type="text/css">
.loader {display: block;float: left;margin-right: 12px; margin-top: 6px; height:16px;width:16px;background-image:url('<?php      echo ASSETS_URL_IMAGES?>/icons/icon_header_loading.gif');}
.event_warning{padding-left: 22px;padding-bottom: 8px;padding-right: 22px;padding-top: 10px;font-size: 12px;margin-right: 20px;float: right;color: #698c66;margin-bottom: -20px;margin-top: 12px;}
.icon {display: block;float: left;height:20px;width:20px;background-image:url('<?php       echo ASSETS_URL_IMAGES?>/icons_sprite.png'); /*your location of the image may differ*/}
.edit {background-position: -22px -2225px;margin-right: 6px!important;}
.copy {background-position: -22px -439px;margin-right: 6px!important;}
.delete {background-position: -22px -635px;}
#blogBody_tbl { height: 700px!important;}
#blogBody_ifr { height: 700px!important;}
a.error {color: white!important;}
</style>
<?php     
$u = new User();

$pk = Cache::flush();
$tp = PermissionKey::getByHandle('problog_post');


if ($u->isSuperUser() || $tp->can()){
	if (is_object($blog)) { 
		$blogTitle = $blog->getCollectionName();
		$blogDescription = $blog->getCollectionDescription();
		$blogDate = $blog->getCollectionDatePublic();
		$cParentID = $blog->getCollectionParentID();
		$ctID = $blog->getCollectionTypeID();
		$blogBody = '';
		$eb = $blog->getBlocks('Main');
		if (is_object($eb[0])) {
			$blogBody = $eb[0]->getInstance()->getContent();
		}
		echo "<div class=\"event_warning\"><span class=\"tooltip icon edit\"></span> You are now editing <b><u>$blogTitle</u></b></div>";
		$task = 'editthis';
		$buttonText = t('Update Blog Entry');
		$title = 'Update';
	} else {
		$task = 'addthis';
		$buttonText = t('Add Blog Entry');
		$title= 'Add';
	}	
	$set = AttributeSet::getByHandle('problog_additional_attributes');
	$setAttribs = $set->getAttributeKeys();

	$u = new User();
	if($u->isLoggedIn()){
	?>
	<div style="padding-left: 8px;" class="ccm-ui">
		<div class="ccm-pane-body">
			<div id="blog-message">
				<?php     
				if($message){
					echo '<div class="alert-message success">'.$message.'</div>';
				}
				?>
			</div>
			<?php      
			if($remove_name){
			?>
			<div class="alert-message block-message error">
			  <a class="close" href="<?php       echo $this->action('clear_warning');?>">×</a>
			  <p><strong><?php       echo t('Holy guacamole! This is a warning!');?></strong></p><br/>
			  <p><?php       echo t('Are you sure you want to delete ').$remove_name.'?';?></p>
			  <p><?php       echo t('This action may not be undone!');?></p>
			  <div class="alert-actions">
			    <a class="btn small" href="<?php       echo $this->url('/problog_editor', 'deletethis',$remove_cid,$remove_name)?>"><?php       echo t('Yes Remove This');?></a> <a class="btn small" href="<?php       echo $this->action('clear_warning');?>"><?php       echo t('Cancel');?></a>
			  </div>
			</div>
			<?php      
			}
			?>
		  <div id="blog-post-form">
			<ul class="tabs">
				<li <?php      if(!$blog){ ?>class="active"<?php      } ?>><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.drafts').show();"><?php      echo t('Drafts')?></a>
				</li>
				<li <?php      if($blog){ ?>class="active"<?php      } ?>><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.info').show();"><?php      echo t('Info')?></a>
				</li>
				<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.post').show();"><?php      echo t('Post')?></a>
				</li>
				<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.options').show();"><?php      echo t('Options')?></a>
				</li>
				<?php  if(count($setAttribs) > 0){ ?>
				<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.attributes').show();"><?php      echo t('Attributes')?></a>
				</li>
				<?php  } ?>
				<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.meta').show();"><?php      echo t('Meta')?></a>
				</li>
	
			</ul>
			<br style="clear: both;"/>
				<?php        if ($task == 'editthis') { ?>
					<form method="post" action="<?php       echo BASE_URL.DIR_REL.'/index.php/dashboard/problog/add_blog/addthis/'?>" id="blog-form">
					<?php       echo $form->hidden('blogID', $blog->getCollectionID())?>
				<?php        }else{ ?>
					<form method="post" action="<?php       echo BASE_URL.DIR_REL.'/index.php/dashboard/problog/add_blog/addthis/'?>" id="blog-form">
				<?php       } ?>
			<div class="pane drafts" style="display: <?php      if(!$blog){ ?> block <?php      }else{ ?> none <?php      } ?>;">
				<?php     
				if (count($drafts) > 0) { 
				?>
				
					<table border="0" class="ccm-results-list zebra-striped" cellspacing="0" cellpadding="0">
						<tr>
							<th>&nbsp;</th>
							<th><?php       echo t('Name')?></th>
							<th><?php       echo t('Date')?></th>
							<th><?php       echo t('blog Category')?></th>
							<th><?php       echo t('In Draft')?></th>
						</tr>
						<?php       
						$pkt = Loader::helper('concrete/urls');
						$pkg= Package::getByHandle('problog');
						foreach($drafts as $cobj) { 
						
							Loader::model('attribute/categories/collection');
									
							$akct = CollectionAttributeKey::getByHandle('blog_category');
							$blog_category = $cobj->getCollectionAttributeValue($akct);
							
							if($u->uID == $cobj->getCollectionUserID()){
								?>
								<tr>
									<td width="60px">
									<a href="<?php       echo $this->url('/profile/problog_editor', $cobj->getCollectionID())?>" class="icon edit"></a> &nbsp;
									<a href="<?php       echo $this->url('/profile/problog_editor', 'delete_check', $cobj->getCollectionID(),$cobj->getCollectionName())?>" class="icon delete"></a>
									</td>
									<td><a href="<?php       echo $nh->getLinkToCollection($cobj)?>"><?php       echo $cobj->getCollectionName()?></a></td>
									<td>
									<?php       
									if ($cobj->getCollectionDatePublic() > date(DATE_APP_GENERIC_MDYT_FULL) ){
										echo '<font style="color:green;">';
										echo $cobj->getCollectionDatePublic(DATE_APP_GENERIC_MDYT_FULL);
										echo '</font>';
									}else{
										echo $cobj->getCollectionDatePublic(DATE_APP_GENERIC_MDYT_FULL);
									}
									?>
									</td>
									<td><?php       echo $blog_category;?></td>
									<td>
									<?php       
									$tp = PermissionKey::getByHandle('problog_approve');
									if($tp->can()){
										if(!$cobj->isActive()){
										echo '<a href="'.$this->url('/profile/problog_editor', 'approvethis', $cobj->getCollectionID(),$cobj->getCollectionName()).'">'.t('Approve This').'</a>';
										}
									}else{
										echo t('Awaiting Approval');
									}
									?>
									</td>
								</tr>
								<?php       
								} 
							}
							?>
						</table>
					<?php     
					}
					?>
			</div>
			<div class="pane info" style="display: <?php      if($blog){ ?> block <?php      }else{ ?> none <?php      } ?>;">
				<?php       echo $form->hidden('front_side',1)?>
				<div class="clearfix">
					<?php       echo $form->label('blogTitle', t('Blog Title'))?> *
					<div class="input">
						<?php       echo $form->text('blogTitle', $blogTitle, array('style' => 'width: 230px'))?>
					</div>
				</div>
				
				<div class="clearfix">
					<?php       echo $form->label('blog_author', t('Author'))?>
					<div class="input">
						<?php       
						$auth = CollectionAttributeKey::getByHandle('blog_author');
						if (is_object($blog)) {
							$authvalue = $blog->getAttributeValueObject($auth);
						}
						?>
						<div class="blog-attributes">
							<div style="width: 230px;">
								<?php       echo $form->hidden('user_pick_'.$auth->getAttributeKeyID(), $u->uID);?>
								<?php    
								echo $u->getUserName();
								?>
							</div>
						</div>
					</div>
				</div>
				<?php       
				$akt = CollectionAttributeKey::getByHandle('thumbnail');
				if (is_object($blog)) {
					$tvalue = $blog->getAttributeValueObject($akt);
				}
				?>
				<div class="clearfix">
					<?php       echo $akt->render('label', t('Thumbnail Image'));?>
					<div class="input">
						<table class="bordered-table" style="width: 230px;">
							<tr>
								<td>
									<?php       echo $akt->render('form', $tvalue, true);?>
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				
				<div class="clearfix">
					<?php       echo $form->label('blogDescription', t('Blog Description'))?>
					<div class="input">
						<div><?php       echo $form->textarea('blogDescription', $blogDescription, array('style' => 'width: 98%; height: 90px; font-family: sans-serif;'))?></div>
					</div>
				</div>
			</div>
			<div class="pane post" style="display: none;">
				<br styl="clear:both;"/>
				<div class="clearfix">
				<?php       Loader::packageElement('editor_init','problog'); ?>
				<?php       Loader::Element('editor_config'); ?>
				<?php       //Loader::element('editor_controls', array('mode'=>'full')); ?>
				<?php       Loader::packageElement('editor_controls','problog' ,array('mode'=>'full'));?>
				
				<?php       echo $form->textarea('blogBody', $blogBody, array('style' => 'width: 100%; font-family: sans-serif;', 'class' => 'ccm-advanced-editor'))?>
				</div>
			</div>
				<div class="pane options" style="display: none;">
					<div class="clearfix">
						<?php       echo $form->label('blogDate', t('Date/Time'))?>
						<div class="input">
							<?php       echo $df->datetime('blogDate', $blogDate)?>
						</div>
					</div>
	
					<?php       
					$akt = CollectionAttributeKey::getByHandle('tags');
					if (is_object($blog)) {
						$tvalue = $blog->getAttributeValueObject($akt);
					}
					?>
					<div class="clearfix">
						<?php       echo $akt->render('label');?>
						<div class="input">
							<?php       echo $akt->render('form', $tvalue, true);?>
						</div>
					</div>
					
					<?php       
					$akct = CollectionAttributeKey::getByHandle('blog_category');
					if (is_object($blog)) {
						$tcvalue = $blog->getAttributeValueObject($akct);
					}
					?>
					<div class="clearfix">
						<?php       echo $form->label('blogCategory', t('Blog Category'))?>
						<div class="input">
							<?php       echo $akct->render('form', $tcvalue, true);?>
						</div>
					</div>
	
	
					<div class="clearfix">
						<?php       echo $form->label('cParentID', t('Section/Location'))?>
						<div class="input">
							<?php       if (count($sections) == 0) { ?>
								<div><?php       echo t('No sections defined. Please create a page with the attribute "blog_section" set to true.')?></div>
							<?php       } else { ?>
								<?php      
								if($ubp->cID){
									if(array_key_exists($cParentID,$sections)){
										?>
										<div style="display: none;"><?php       echo $form->select('cParentID', $sections, $cParentID)?></div>
										<?php      
										echo '<br/><i>'.$sections[$cParentID].'</i><br/>';
									}else{
									?>
									<div><?php       echo $form->select('cParentID', $sections, $cParentID)?></div>
									<?php      
									}
								}else{
								?>
								<div><?php       echo $form->select('cParentID', $sections, $cParentID)?></div>
							<?php       }
							
								} 
							?>
						</div>
					</div>
					
					
					<div class="clearfix">
						<?php       echo $form->label('post_ping',t('Scrape content for url Pingbacks?'));?>
						<div class="input">
							<?php       echo $form->checkbox('post_ping',1).' Yes';?>
						</div>
					</div>

					<div class="clearfix">
						<?php       echo $form->label('draft',t('Draft Copy'));?>
						<div class="input">
							<?php       
							if($blog){
								$pa = $blog->getVersionObject();
								if($pa->isApproved()==1){$draft = 0;}else{$draft = 1;}
							}else{
								$draft = 0;
							}
							//var_dump($draft);
							//exit;
							$values = array(0=>t('save normal'),1=>t('save as draft'),2=>t('save & notify approvers'));
							?>
							<?php      echo $form->select('draft',$values,$draft)?>
						</div>
					</div>
	
					<?php       
					if(!$ctID){
						$ctID = $settings['ctID'];
					}
					?>
					<div class="clearfix" style="display: none;">
						<?php       echo $form->label('ctID', t('Page Type'))?>
						<div class="input">
							<?php       echo $form->select('ctID', $pageTypes, $ctID)?>
						</div>
					</div>
	
	
					<?php      
					$setAttribs = null;
					$set = AttributeSet::getByHandle('problog_additional_attributes');
					if($set){
						$setAttribs = $set->getAttributeKeys();
					}
					if($setAttribs){
						echo '<br/><h2>'.t('Additional Attributes').'</h2>';
						foreach ($setAttribs as $ak) {
							echo '<div class="blog-attributes">';
							if(is_object($blog)) {
								$aValue = $blog->getAttributeValueObject($ak);
							}
							echo '<div>	';
							echo '<h4>'.$ak->render('label').'</h4>';
							echo $ak->render('form', $aValue);
							echo '</div>';
							echo '</div>';
						}
					}
					?>
				</div>
				<div class="pane attributes" style="display: none;">
					<?php       
						if($setAttribs){
							foreach ($setAttribs as $ak) {
								if(is_object($event)) {
									$aValue = $blog->getAttributeValueObject($ak);
								}
								?>
								<div class="clearfix">
									<?php       echo $ak->render('label');?>
									<div class="input">
										<?php       echo $ak->render('form', $aValue)?>
									</div>
								</div>
								<?php     
							}
						}
					?>
				</div>
				<div class="pane meta" style="display: none;">
					<div class="clearfix">
						<?php       echo $form->label('akID[1][value]', t('Meta Title'))?>
						<div class="input">
							<?php      
							if(is_object($blog)){
								$metaTitle = $blog->getAttribute('meta_title');
							}
							?>
							<?php       echo $form->text('akID[1][value]', $metaTitle, array('style' => 'width: 230px'))?>
						</div>
					</div>
					
					<div class="clearfix">
						<?php       echo $form->label('akID[2][value]', t('Meta Description'))?>
						<div class="input">
							<?php      
							if(is_object($blog)){
								$metaDescription = $blog->getAttribute('meta_description');
							}
							?>
							<?php       echo $form->textarea('akID[2][value]', $metaDescription, array('style' => 'width: 98%; height: 90px; font-family: sans-serif;'))?>
						</div>
					</div>
					
					<div class="clearfix">
						<?php       echo $form->label('akID[3][value]', t('Meta Tags'))?>
						<div class="input">
							<?php      
							if(is_object($blog)){
								$metaKeywords = $blog->getAttribute('meta_keywords');
							}
							?>
							<?php       echo $form->textarea('akID[3][value]', $metaKeywords, array('style' => 'width: 98%; height: 90px; font-family: sans-serif;'))?>
						</div>
					</div>
	
				</div>
			<br style="clear: both;"/>
			<div class="loader" style="display: none;"></div>
	    	<?php       $ih = Loader::helper('concrete/interface'); ?>
	        <?php       print $ih->submit(t($buttonText), 'blog-form', 'right', 'primary'); ?>
	         <?php       print $ih->button(t('Cancel'), $this->url('/problog_editor'), 'left','error'); ?>
		    </form>
		    </div>
		</div>
	</div>
	<script type="text/javascript">
	/*<![CDATA[*/
		$('document').ready(function(){
			$('.tabs li').click(function(){
				$('.alert-message').remove();
			});
			$('#ccm-submit-blog-form').click(function(){
				$('#blog-post-form').show();
				$('.loader').show();
				$('#blog-message').html('');
				var message = '';
				var content = tinyMCE.activeEditor.getContent();
				$('#blogBody').val(content);
				//alert(content);
				var form = $('#blog-form').serialize();
				var url = '<?php       echo $AJAXeventPost?>?'+form;
				//alert(content_encode);
				$.post(url, function(response) {
	
					if(response != 'success'){
						message = 'There was a problem with your post:';
						message += '<br/><ul>';
						$.each(response,function(key,r){
							message += '<li>'+r+'</li>';
						});
						message += '</ul>';
						$('#blog-message').html('<div class="alert-message error">'+message+'</div>');
						$('.loader').hide();
					}else{
						window.location.href = "<?php     echo $this->url('/profile/problog_editor','post_added');?>";
					}
				}, 'json');
				return false;
			});
		});
	
	/*]]>*/
	</script>
	<?php     
	}else{
		echo '<div style="padding-left: 8px;" class="ccm-ui"><div class="ccm-pane-body"><div class="alert-message block-message error">'.t('You must be logged in to use the Blog Editor!').'</div></div></div>';
	}
}else{
	echo '<div style="padding-left: 8px;" class="ccm-ui"><div class="ccm-pane-body"><div class="alert-message block-message error">'.t('Your administrator has not granted you access to this page!').'</div></div></div>';
	echo '<br/><br/><div class="ccm-ui"><a href="/login" class="btn btn-large primary">Log In Now</a></div>';
}
?>