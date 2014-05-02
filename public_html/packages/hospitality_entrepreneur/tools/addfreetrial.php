<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
?>
<style type="text/css">
	.event_warning{
	padding-left: 22px;
	padding-bottom: 8px;
	padding-right: 22px;
	padding-top: 8px;
	font-size: 12px;
	margin-right: 20px;
	float: right;
	border-color: #8cbb82;
	border-width: 1px;
	border-style: solid;
	background-color: #d5ffcd;
	color: #698c66;
	margin-bottom: -20px;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
	}
.icon {
display: block;
float: left;
height:20px;
width:20px;
background-image:url('<?php       echo ASSETS_URL_IMAGES?>/icons_sprite.png'); /*your location of the image may differ*/
}
.edit {background-position: -22px -775px;margin-right: 6px!important;}
</style>
<?php       
	$blogify = Loader::helper('blogify','problog');
	Loader::model("attribute/categories/collection");
	Loader::model("collection_types");
	Loader::model('page_list');
	$settings = $blogify->getBlogSettings();
	$AJAXeventPost = BASE_URL.Loader::helper('concrete/urls')->getToolsURL('post_blog.php','problog');
	$df = Loader::helper('form/date_time');
	$form = Loader::helper('form');

	$blogSectionList = new PageList();
	$blogSectionList->filterByBlogSection(1);
	$blogSectionList->sortBy('cvName', 'asc');
	$tmpSections = $blogSectionList->get();
	$sections = array();
	foreach($tmpSections as $_c) {
		$sections[$_c->getCollectionID()] = $_c->getCollectionName();
	}
	$ctArray = CollectionType::getList('');
	$pageTypes = array();
	foreach($ctArray as $ct) {
		$pageTypes[$ct->getCollectionTypeID()] = $ct->getCollectionTypeName();		
	}
	if($_REQUEST['blogID']){
		$keys = array_keys($sections);
		$keys[] = -1;
		Loader::model('page');
		
		$current_page = Page::getByID($_REQUEST['blogID']);
		$date = $current_page->getCollectionDatePublic();
		$canonical_parent_id = Loader::helper('blogify','problog')->getCanonicalParent($date,$current_page);
		
		if(in_array($canonical_parent_id, $keys)){
			$blog = $current_page;
		}
	}

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
	?>
	
<div style="padding-left: 8px;" class="ccm-ui">
	
	<div class="ccm-pane-body">
	  <div id="blog-post-form">
		<ul class="tabs">
			<li class="active"><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.info').show();"><?php      echo t('Info')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.post').show();"><?php      echo t('Post')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.options').show();"><?php      echo t('Options')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.attributes').show();"><?php      echo t('Attributes')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.meta').show();"><?php      echo t('Meta')?></a>
			</li>

		</ul>
		<br style="clear: both;"/>
			<?php        if ($task == 'editthis') { ?>
				<form method="post" id="blog-form">
				<?php       echo $form->hidden('blogID', $blog->getCollectionID())?>
			<?php        }else{ ?>
				<form method="post" id="blog-form">
			<?php       } ?>
			
		<div class="pane info" style="display: block;">
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
					<?php       echo $form->label('send_to_subscribers',t('Send eMail to subscribers?'));?>
					<div class="input">
						<?php       echo $form->checkbox('send_to_subscribers',1).' Yes';?>
					</div>
				</div>
				
				
				<div class="clearfix">
					<?php       echo $form->label('post_ping',t('Scrape content for url Pingbacks?'));?>
					<div class="input">
						<?php       echo $form->checkbox('post_ping',1).' Yes';?>
					</div>
				</div>
				
				<div class="clearfix">
					<?php     echo $form->label('notify', t('Post to Twitter?'))?>
					<div class="input">
						<div class="input-prepend">
							<label>
							<span class="add-on" style="z-index: 2000">
								<?php     echo $form->checkbox('post_twitter', 1, 0, array('onclick' => "$('input[name=twitter_hash]').focus()"))?>
							</span><?php     echo $form->text('twitter_hash', $twitter_hash, array('style' => 'z-index:2000;width: 180px!important;display: inline-block!important;' ))?>
							</label>
						</div>
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
				<div class="clearfix">
					<?php       echo $form->label('ctID', t('Page Type'))?>
					<div class="input">
						<?php       echo $form->select('ctID', $pageTypes, $ctID)?>
					</div>
				</div>
			</div>
			<div class="pane attributes" style="display: none;">
				<?php       
					$set = AttributeSet::getByHandle('problog_additional_attributes');
					$setAttribs = $set->getAttributeKeys();
					if($setAttribs){
						foreach ($setAttribs as $ak) {
							if(is_object($blog)) {
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

    	<?php       //$ih = Loader::helper('concrete/interface'); ?>
        <?php       //print $ih->submit(t($buttonText), 'blog-form', 'right', 'primary'); ?>
        <a href="#" class="btn ccm-button-v2 primary ccm-button-v2-right" id="submit-blog-form"><?php     echo $buttonText?></a>

	    </form>
	    </div>
	</div>
	<div id="blog-message">
	
	</div>
</div>
<script type="text/javascript">
/*<![CDATA[*/
	$('document').ready(function(){
		$('#submit-blog-form').click( function(){
			$('#blog-post-form').show();
			$('#blog-message').html('');
			var message = '';
			var content = tinyMCE.activeEditor.getContent();
			$('#blogBody').val(content);
			//alert(content);
			var form = $('#blog-form').serialize();
			var url = '<?php       echo $AJAXeventPost?>';
			$.post(url,form, function(response){
				if(response != 'success'){
					message = '<?php      echo t('There was a problem with your post:'); ?>';
					message += '<br/><ul>';
					$.each(response,function(key,r){
						message += '<li>'+r+'</li>';
					});
					message += '</ul>';
					$('#blog-message').html('<div class="alert-message error">'+message+'</div>');
				}else{
					$('#blog-post-form').hide();
					$('#blog-message').html('<div class="alert-message success"><?php      echo t('Your Post has been submitted successfully!'); ?></div>');
				}
			}, 'json');
			return false;
		});
		$('.ccm-dialog-close').click( function(){
                location.reload();
        });
	});
/*]]>*/
</script>