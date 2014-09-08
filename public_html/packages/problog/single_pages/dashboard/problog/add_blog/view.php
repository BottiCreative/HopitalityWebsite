<?php      defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php      
$df = Loader::helper('form/date_time');

if (is_object($blog)) { 
	$blogTitle = $blog->getCollectionName();
	$blogDescription = $blog->getCollectionDescription();
	$blogDate = $blog->getCollectionDatePublic();
	$ctID = $blog->getCollectionTypeID();
	$blogBody = '';
	$eb = $blog->getBlocks('Main');
	foreach($eb as $b) {
		if($b->getBlockTypeHandle()=='content' || $b->getBlockTypeHandle()=='sb_add_blog'){
			$blogBody = $b->getInstance()->getContent();
		}
	}
	$task = 'edit';
	$buttonText = t('Update Blog Entry');
	$title = t('Update');
} else {
	$task = 'add';
	$buttonText = t('Add Blog Entry');
	$title= t('Add');
}

$set = AttributeSet::getByHandle('problog_additional_attributes');
$setAttribs = $set->getAttributeKeys();
?>
<style type="text/css">
.good{color: green!important;}
.borderline{color: #f2a502!important;}
.poor{color: maroon!important;}
tr.good td{background-color: #d4ffd0!important;}
tr.borderline td{background-color: #fff6d5!important;}
tr.poor td{background-color: #ffd9d9!important;}
td.checkmark{font-size: 22px;}
#blogBody_ifr{height: 900px!important;}
</style>
	<?php     echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper($title.t(' Blog Post').'<span class="label" style="position:relative;top:-3px;left:12px;">'.t('* required field').'</span>', false, false, false);?>
	<div class="ccm-pane-body">
		<!--
		<ul class="breadcrumb">
		  <li><a href="/index.php/dashboard/problog/list/">List</a> <span class="divider">|</span></li>
		  <li class="active">Add/Edit <span class="divider">|</span></li>
		  <li><a href="/index.php/dashboard/problog/comments/">Comments</a> <span class="divider">|</span></li>
		  <li><a href="/index.php/dashboard/problog/settings/">Settings</a></li>
		</ul>
		-->
		<?php      if ($this->controller->getTask() == 'edit') { ?>
				<form method="post" action="<?php      echo $this->action($task,$blog->getCollectionID())?>" id="blog-form">
				<?php      echo $form->hidden('blogID', $blog->getCollectionID())?>
			<?php      }else{ ?>
				<form method="post" action="<?php      echo $this->action($task)?>" id="blog-form">
		<?php      } ?>

		<ul class="tabs">
			<li class="active"><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.info').show();"><?php     echo t('Info')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.post').show();"><?php     echo t('Post')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.options').show();"><?php     echo t('Options')?></a>
			</li>
			<?php  if(count($setAttribs) > 0){ ?>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.attributes').show();"><?php      echo t('Attributes')?></a>
			</li>
			<?php  } ?>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.meta').show();"><?php     echo t('Meta')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.seo').show();" class="seo-tools"><?php     echo t('Optimize')?></a>
			</li>
		</ul>
		<br style="clear:both;"/>
		<div class="pane info" style="display: block;">
			<?php      echo $form->hidden('front_side',1)?>
			<div class="clearfix">
				<?php      echo $form->label('blogTitle', t('Blog Title'))?> *
				<div class="input">
					<?php      echo $form->text('blogTitle', $blogTitle, array('style' => 'width: 230px'))?>
				</div>
			</div>
			
			<div class="clearfix">
				<?php      echo $form->label('blog_author', t('Author'))?>
				<div class="input">
					<?php      
					$auth = CollectionAttributeKey::getByHandle('blog_author');
					if (is_object($blog)) {
						$authvalue = $blog->getAttributeValueObject($auth);
					}
					?>
					<div class="blog-attributes">
						<div style="width: 230px;">
							<?php      echo $auth->render('form', $authvalue);?>
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
				<?php      echo $akt->render('label', t('Thumbnail Image'));?>
				<div class="input">
					<table class="bordered-table" style="width: 230px;">
						<tr>
							<td>
								<?php      echo $akt->render('form', $tvalue, true);?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			
			<div class="clearfix">
				<?php      echo $form->label('blogDescription', t('Blog Description'))?>
				<div class="input">
					<div><?php      echo $form->textarea('blogDescription', $blogDescription, array('style' => 'width: 98%; height: 90px; font-family: sans-serif;'))?></div>
				</div>
			</div>
		</div>
		<div class="pane post" style="display: none;">
			<br styl="clear:both;"/>
			<div class="clearfix">
			<?php      Loader::packageElement('editor_init','problog'); ?>
			<?php      Loader::Element('editor_config'); ?>
			<?php      //Loader::element('editor_controls', array('mode'=>'full')); ?>
			<?php      Loader::packageElement('editor_controls','problog' ,array('mode'=>'full'));?>
			
			<?php      echo $form->textarea('blogBody', $blogBody, array('style' => 'width: 100%; font-family: sans-serif;', 'class' => 'ccm-advanced-editor'))?>
			</div>
		</div>
		<div class="pane options" style="display: none;">
			<div class="clearfix">
				<?php      echo $form->label('blogDate', t('Date/Time'))?>
				<div class="input">
					<?php      echo $df->datetime('blogDate', $blogDate)?>
				</div>
			</div>

			<?php      
			$akt = CollectionAttributeKey::getByHandle('tags');
			if (is_object($blog)) {
				$tvalue = $blog->getAttributeValueObject($akt);
			}
			?>
			<div class="clearfix">
				<?php      echo $akt->render('label', t('Tags'));?>
				<div class="input">
					<?php      echo $akt->render('form', $tvalue, true);?>
				</div>
			</div>

			<?php     
			$co = new Config;
			$upkg = Package::getByHandle('problog');
			$ubp = Page::getByPath('/profile/user_blog');
			if($ubp->cID){
				$co->setPackageObject($upkg);
				$share_attribute = $co->get("USER_BLOG_SHARE_ATTRIBUTE");
				
				if($share_attribute){
					$share_attribute = ucwords(str_replace('_',' ',$share_attribute));
					$shareOptions = array('all'=>"All", 'selected ' => "Selected $share_attribute");
					?>
					<div class="clearfix">
						<?php       echo $form->label('share_with', t('Share With'))?>
						<div class="input">
							<?php      echo $form->select('share_with', $shareOptions, 'all');?>
						</div>
					</div>
					<?php     
				}
			}
			?>
			
			
			<?php      
			$akct = CollectionAttributeKey::getByHandle('blog_category');
			if (is_object($blog)) {
				$tcvalue = $blog->getAttributeValueObject($akct);
			}
			?>
			<div class="clearfix">
				<?php      echo $form->label('blogCategory', t('Blog Category'))?>
				<div class="input">
					<?php      echo $akct->render('form', $tcvalue, true);?>
				</div>
			</div>


			<div class="clearfix">
				<?php      echo $form->label('cParentID', t('Section/Location'))?>
				<div class="input">
					<?php      if (count($sections) == 0) { ?>
						<div><?php      echo t('No sections defined. Please create a page with the attribute "blog_section" set to true.')?></div>
					<?php      } else { ?>
						<?php     
						if($ubp->cID){
							if(array_key_exists($cParentID,$user_sections)){
								?>
								<div style="display: none;"><?php      echo $form->select('cParentID', $user_sections, $cParentID)?></div>
								<?php     
								echo '<br/><i>'.$user_sections[$cParentID].'</i><br/>';
							}else{
							?>
							<div><?php      echo $form->select('cParentID', $sections, $cParentID)?></div>
							<?php     
							}
						}else{
						?>
						<div><?php      echo $form->select('cParentID', $sections, $cParentID)?></div>
					<?php      }
					
						} 
					?>
				</div>
			</div>

	
			<div class="clearfix">
				<?php      echo $form->label('send_to_subscribers',t('Send eMail to subscribers?'));?>
				<div class="input">
					<?php      echo $form->checkbox('send_to_subscribers',1).' Yes';?>
				</div>
			</div>
			
			
			<div class="clearfix">
				<?php      echo $form->label('post_ping',t('Scrape content for url Pingbacks?'));?>
				<div class="input">
					<?php      echo $form->checkbox('post_ping',1).' Yes';?>
				</div>
			</div>
			
			
			<div class="clearfix">
				<?php    echo $form->label('notify', t('Post to Twitter?'))?>
				<div class="input">
					<div class="input-prepend">
						<label>
						<span class="add-on" style="z-index: 2000">
							<?php    echo $form->checkbox('post_twitter', 1, 0, array('onclick' => "$('input[name=twitter_hash]').focus()"))?>
						</span><?php    echo $form->text('twitter_hash', $twitter_hash, array('style' => 'z-index:2000;width: 180px!important;display: inline-block!important;' ))?>
						</label>
					</div>
				</div>
			</div>


			<div class="clearfix">
				<?php      echo $form->label('draft',t('Draft Copy'));?>
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
					<?php     echo $form->select('draft',$values,$draft)?>
				</div>
			</div>

			<?php      
			if(!$ctID){
				$ctID = $settings['ctID'];
			}
			?>
			<div class="clearfix">
				<?php      echo $form->label('ctID', t('Page Type'))?>
				<div class="input">
					<?php      echo $form->select('ctID', $pageTypes, $ctID)?>
				</div>
			</div>
		</div>
		<div class="pane attributes" style="display: none;">
			<?php      
				if($setAttribs){
					foreach ($setAttribs as $ak) {
						if(is_object($blog)) {
							$aValue = $blog->getAttributeValueObject($ak);
						}
						?>
						<div class="clearfix">
							<?php      echo $ak->render('label');?>
							<div class="input">
								<?php      echo $ak->render('form', $aValue)?>
							</div>
						</div>
						<?php    
					}
				}
			?>
		</div>
		<div class="pane meta" style="display: none;">
			<div class="clearfix">
				<?php      echo $form->label('akID[1][value]', t('Meta Title'))?>
				<div class="input">
					<?php     
					if(is_object($blog)){
						$metaTitle = $blog->getAttribute('meta_title');
					}
					?>
					<?php      echo $form->text('akID[1][value]', $metaTitle, array('style' => 'width: 230px'))?>
				</div>
			</div>
			
			<div class="clearfix">
				<?php      echo $form->label('akID[2][value]', t('Meta Description'))?>
				<div class="input">
					<?php     
					if(is_object($blog)){
						$metaDescription = $blog->getAttribute('meta_description');
					}
					?>
					<?php      echo $form->textarea('akID[2][value]', $metaDescription, array('style' => 'width: 98%; height: 90px; font-family: sans-serif;'))?>
				</div>
			</div>
			
			<div class="clearfix">
				<?php      echo $form->label('akID[3][value]', t('Meta Tags'))?>
				<div class="input">
					<?php     
					if(is_object($blog)){
						$metaKeywords = $blog->getAttribute('meta_keywords');
					}
					?>
					<?php      echo $form->textarea('akID[3][value]', $metaKeywords, array('style' => 'width: 98%; height: 90px; font-family: sans-serif;'))?>
				</div>
			</div>
		</div>
		<div class="pane seo" style="display: none;">
			
			<div class="alert-message block-message info">
			  <a class="close" href="javascript:;">×</a>
			  <p><strong><?php       echo t('SEO Tools to help you maximize your impact!');?></strong></p>
			  <p><?php       echo t('<p>Below you will find some helpful SEO tools to aid you in the delicate balance of keywords, keyword phrases, images, and links.</p><p>To the right you will find three important checklists.  While nothing on this report is mandatory, making sure as many items are checked on these lists as possible will ensure better readability and ranking by search engine algorithms.</p>');?></p>
			  <div class="alert-actions">

			  </div>
			</div>
			
			<!--
			<a href="javascript:;" id="control" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh</a><br/><br/>
			-->
			<div class="row">
				<div class="span8">
				
					<div style="display: none;" id="content_dom"></div>
					<a href="http://www.alchemyapi.com/" class="alchemy" target="_blank"></a>
					<h3><?php echo t('Natural Language Keyword Phrase Strength')?>  <i class="icon icon-question-sign tooltips" title="<?php echo t('<p>Natural Language Processing (NLP) is an advanced algorithm design to appropriately arranged keywords as users would most likely search for them</p><p>This differs from single keyword density in that users rarely will search for any given term by itself.  Thus providing a more concise recognizable grouping of keyword terms.  Search Engines are now progressing to recognize and parse data in this way</p>')?>"></i></h3>
					<table id="phrase_result" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?php echo t('NLP Keyword Phrase')?></th>
								<th><?php echo t('Search Relevance')?></th>
								<th><?php echo t('Times Used')?></th>
								<th><?php echo t('Density %')?></th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
					
					<h3><?php echo t('Single Keyword Strength')?>  <i class="icon icon-question-sign tooltips" title="<?php echo t('<p>Single Keyword Optimization is still very important in how Search Engines view your content</p><p>The recommended Keyword Density is 1-3%</p>')?>"></i></h3>
					<table id="single_result" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?php echo t('Keyword')?></th>
								<th><?php echo t('Times Used')?></th>
								<th><?php echo t('Density %')?></th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
					
					
					<h3><?php echo t('Link Usage')?> <i id="link_metric"></i>  <i class="icon icon-question-sign tooltips" title="<?php echo t('<p>Link use is also important in how Search Engines perceive your content.</p><p>The more links you have to related & relevant content, the more relevant Search Engines deem your post.</p><p>Having XMLRPC compatible links can also have a positive impact as your posts will be cross commented between both sites with back linking available for crawlers.</p><p>The recommended Link Density is .5-1.5%</p>')?>"></i></h3>
					<table id="links_result" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?php echo t('Link Address')?></th>
								<th><?php echo t('Valid URL')?></th>
								<th><?php echo t('XMLRPC')?></th>
								<th><?php echo t('Rel Nofollow')?></th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
					
					
					<h3><?php echo t('Image Usage')?> <i id="image_metric"></i>  <i class="icon icon-question-sign tooltips" title="<?php echo t('<p>Because most Search Engines now index images for use in their optimized image search tools, having images in your posts can have a positive impact on your page rankings.</p><p>The recommended Image Density is .5-1.5%</p>')?>"></i></h3>
					<table id="img_result" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?php echo t('Link Address')?></th>
								<th><?php echo t('Valid URL')?></th>
								<th><?php echo t('Alt Data')?></th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
				</div>
				<div class="span3">
					<h3><?php echo t('SEO Checklist')?>  <i class="icon icon-question-sign tooltips" title="<?php echo t('<p>This list is designed to help you produce consistent & relevant content that is search optimized and spider friendly.</p><p>The below should be considered the minimum requirement for stronger SEO presence.</p>')?>"></i></h3>
					<table id="metrics" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?php echo t('Metric')?></th>
								<th><?php echo t('Status')?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo t('Meta Title')?></td>
								<td class="checkmark"><i class="fa fa-circle-o meta-title"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Meta Description')?></td>
								<td class="checkmark"><i class="fa fa-circle-o meta-description"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Meta Keywords')?></td>
								<td class="checkmark"><i class="fa fa-circle-o meta-keywords"></i></td>
							</tr>
							<tr>
								<td><?php echo t('NLP Keyphrase Density')?></td>
								<td class="checkmark"><i class="fa fa-circle-o keyphrase"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Keyword Density')?></td>
								<td class="checkmark"><i class="fa fa-circle-o keyword"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Link Density')?></td>
								<td class="checkmark"><i class="fa fa-circle-o links"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Image Density')?></td>
								<td class="checkmark"><i class="fa fa-circle-o images"></i></td>
							</tr>
						</tbody>
					</table>
					
					<h3><?php echo t('Meta\'s Checklist')?>  <i class="icon icon-question-sign tooltips" title="<?php echo t('<p>Correlating Meta data is surprizingly often overlooked. </p><p>This Checklist is designed to help you keep your keyword phrases and keyword strategy consistent throughout your meta data</p>')?>"></i></h3>
					<table id="meta_stats" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?php echo t('Metric')?></th>
								<th><?php echo t('Status')?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo t('Meta Title contains a top used Keyphrase')?></td>
								<td class="checkmark"><i class="fa fa-circle-o meta-title"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Meta Description contains top 5 keywords')?></td>
								<td class="checkmark"><i class="fa fa-circle-o meta-description"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Meta Keywords contain top 5 keyphrases & top 5 keywords')?></td>
								<td class="checkmark"><i class="fa fa-circle-o meta-keywords"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Tag Attribute contains 3 keywords')?></td>
								<td class="checkmark"><i class="fa fa-circle-o post-tags"></i></td>
							</tr>
						</tbody>
					</table>
					
					<h3><?php echo t('HTML Checklist')?>  <i class="icon icon-question-sign tooltips" title="<?php echo t('<p>This Checklist is designed to optimize your use of HTML tags.</p><p>Search Engines now prioritize semantically structured content over older markup formatting.</p>')?>"></i></h3>
					<table id="html_stats" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?php echo t('Metric')?></th>
								<th><?php echo t('Status')?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo t('Page title contains a top used keyphrase')?></td>
								<td class="checkmark"><i class="fa fa-circle-o title"></i></td>
							</tr>
							<tr>
								<td><?php echo t('No H1 tags within your post')?></td>
								<td class="checkmark"><i class="fa fa-circle-o no-h1s"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Use of H2 tags')?></td>
								<td class="checkmark"><i class="fa fa-circle-o h2s"></i></td>
							</tr>
							<tr>
								<td><?php echo t('Use of Blockquote tags')?></td>
								<td class="checkmark"><i class="fa fa-circle-o blockquotes"></i></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<script type="text/javascript">
		
			var phraseWords = null;
			var keyWords = null;
			var linkUse = null;
			var imageUse = null;
			var t5kw = new Array();
			var t5pw = new Array();
			var checkUrl = '<?php echo BASE_URL.DIR_REL.Loader::helper('concrete/urls')->getToolsURL('check_url.php','problog')?>';
			
            $(document).ready(function(){ 
            
            	$('.close').click(function(){
	            	$(this).parent().remove();
            	});
     
                $('.seo-tools').click(function(){
	                var APIkey = '2783f6483f9d3742aff1a38c8849da4fa7f13a1c';
					var url = 'http://access.alchemyapi.com/';
					var content = getContent();
					var text = content.replace(/(<([^>]+)>)/ig,"");
					
					$.ajax({
						url: url+'calls/text/TextGetRankedKeywords',
						type: 'get',
						data: {
							apikey: APIkey,
							text: text,
							outputMode: 'json',
							jsonp: 'getKeywordsFromText',
							maxRetrieve: 10,
							keywordExtractMode: 'strict',
							sentiment: 1
						},
						dataType: 'jsonp',
						complete: function(){
							scrapeSingleKeywords();
							
							getArticleImages();
					
							doSeoChecks();
							
							doMetaChecks();
							
							doHtmlChecks();
							
							getArticleLinks();
						}
					});
					
                });
                
                $('.tooltips').tooltip();
                
                $('.save').click(function(){
	                $('#blog-form').append('<input type="hidden" name="save_post" value="1"/>');
                });
            });
			</script>

		</div>
	</div>
    <div class="ccm-pane-footer">
    	<?php      $ih = Loader::helper('concrete/interface'); ?>
    	<?php      print $ih->submit($title.t(' Blog Post'), 'blog-form', 'right', 'primary'); ?>
        <?php      print $ih->submit(t('Save & Continue'), 'blog-form', 'right', 'primary save'); ?>
        <?php      print $ih->button(t('Cancel'), $this->url('/dashboard/problog/list/'), 'left'); ?>
    </div>
    
    </form>
