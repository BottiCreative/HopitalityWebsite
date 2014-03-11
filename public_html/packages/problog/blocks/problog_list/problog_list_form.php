<?php       defined('C5_EXECUTE') or die(_("Access Denied.")); ?> 
<?php     
$author_id = $author;
$blogify = Loader::helper('blogify','problog');
$blog_settings = $blogify->getBlogSettings();
extract($blog_settings);
?>
<?php       $c = Page::getCurrentPage(); ?>
<style type="text/css">
#ccm-block-fields .ccm-pane-body {padding: 0 12px!important;}
</style>
<input type="hidden" name="pageListToolsDir" value="<?php       echo $uh->getBlockTypeToolsURL($bt)?>/" />
<div class="ccm-ui">
	<div class="ccm-pane-body">
		<ul class="tabs">
			<li class="active"><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.content').show();"><?php      echo t('Content')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.filters').show();"><?php      echo t('Filters')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.sorting').show();"><?php      echo t('Sorting')?></a>
			</li>
			<li><a href="javascript:void(0)" onclick="$('ul.tabs li').removeClass('active'); $(this).parent().addClass('active'); $('.pane').hide(); $('div.options').show();"><?php      echo t('Options')?></a>
			</li>
		</ul>
		
		<div class="pane content" style="display: block;">
		
			<h4><?php       echo t('Blog Title')?></h4>
			<div class="input">
				 <input id="ccm-pagelist-rssTitle" type="text" name="title" style="width:250px" value="<?php       echo $title?>" />
			</div>

			<br/>
			<h4><?php       echo t('Number/Type of Pages')?></h4>
			<div class="input">
			  <?php       echo t('Display')?>
			  <input type="text" name="num" value="<?php       echo $num?>" style="width: 30px">
			  <?php       echo t('pages of type')?>
			  <?php       
					$ctArray = CollectionType::getList();
			
					if (is_array($ctArray)) { ?>
			  <select name="ctID" id="selectCTID">
				<option value="0">** All **</option>
				<?php       foreach ($ctArray as $ct) { ?>
				<option value="<?php       echo $ct->getCollectionTypeID()?>" <?php       if ($ctID == $ct->getCollectionTypeID()) { ?> selected <?php       } ?>>
				<?php       echo $ct->getCollectionTypeName()?>
				</option>
				<?php       } ?>
			  </select>
			  <?php       } ?>
			</div>
			
			<style type="text/css">
			#ccm-pagelist-truncateTxt.faintText{ color:#999; }
			<?php       if(truncateChars==0 && !$truncateSummaries) $truncateChars=128; ?>
			</style>
			
			<br/>
			<h4><?php       echo t('Truncate Sumaries?')?></h4>
			<div class="input">	  
				<input id="ccm-pagelist-truncateSummariesOn" name="truncateSummaries" type="checkbox" value="1" <?php       echo ($truncateSummaries?"checked=\"checked\"":"")?> /> 
				<span id="ccm-pagelist-truncateTxt" <?php       echo ($truncateSummaries?"":"class=\"faintText\"")?>>
					<?php       echo t('Truncate descriptions after')?> 
				<input id="ccm-pagelist-truncateChars" <?php       echo ($truncateSummaries?"":"disabled=\"disabled\"")?> type="text" name="truncateChars" size="3" value="<?php       echo intval($truncateChars)?>" /> 
				<?php       echo t('characters')?>
				</span>
			</div>
			
			<br/>
			<h4><?php       echo t('Page Break?')?></h4>
			<div class="input">	  
				<input id="ccm-pagelist-pageBreakOn" name="PageBreak" type="checkbox" value="1" <?php       echo ($PageBreak?"checked=\"checked\"":"")?> /> 
				<span id="ccm-pagelist-pageBreakVar" <?php       echo ($PageBreak?"":"class=\"faintText\"")?>>
					<?php       echo t('Page Break Syntax')?> 
				<input id="ccm-pagelist-pageBreakSyntax" <?php       echo "disabled=\"disabled\""?> type="text" name="PageBreakSyntax" size="3" value="<?php       echo ($breakSyntax?$breakSyntax:"<hr />")?>" /> 
				</span>
			</div>
			
			<br/>
			<h4><?php       echo t('Use Content instead of Description?')?></h4>	
			<div class="input">
				<input id="ccm-pagelist-content" name="use_content" type="checkbox" value="1" <?php       echo ($use_content?"checked=\"checked\"":"")?> /> 
				<span id="ccm-pagelist-contentTxt">
					<?php       echo t('Yes, use the page "content" block')?>
				</span>
			</div>
			
			<br/>
			<h4><?php       echo t('Display Aliases')?></h4>
			<div class="input">
				<input type="checkbox" name="displayAliases" value="1" <?php       if ($displayAliases == 1) { ?> checked <?php       } ?> />
	<?php       echo t('Display page aliases.')?>
			</div>
		</div>
		<div class="pane filters" style="display: none;">

			<h4><?php       echo t('By Categories')?></h4>
			<div class="input">
				<?php          	
					
	    		$selected_cat = explode(', ',$category);
	
				if(in_array(t('All Categories'), $selected_cat) || empty($selected_cat)){
					echo '<input type="checkbox" name="category[]" value="'.t('All Categories').'" checked/> '.t('All Categories').'</br>';
				}else{
					echo '<input type="checkbox" name="category[]" value="'.t('All Categories').'"/> '.t('All Categories').'</br>';
				}
				
				$blogify = Loader::helper('blogify','problog');	
				
				$options = $blogify->getBlogCats();
	
				foreach($options as $option){
					echo '<input type="checkbox" name="category[]" value="'.$option['value'].'"';
					if(in_array($option['value'], $selected_cat)){
						echo ' checked';
					}
					echo '/> '.$option['value'].' </br>';
				}
				?>
			</div>

			<br/>
			<h4><?php       echo t('Match All Categories')?></h4>
			<div class="input">
				<input type="checkbox" name="filter_strict" value="1" <?php       if ($filter_strict == 1) { ?> checked <?php       } ?> />
	<?php       echo t('Yes, posts must match all Category selections.')?>
			</div>

			<br/>

			<h4><?php       echo t('By Author')?></h4>
			<div class="input">
				</span><?php     echo Loader::helper('user_selector','problog')->selectUser('author', $author_id,'ccm_triggerSelectBlogUser')?>
			</div>
	
			<br/>

			
			<h4><?php       echo t('By Sitemap')?></h4>
			<div class="input">
				<input type="radio" name="cParentID" id="cEverywhereField" value="0" <?php       if ($cParentID == 0) { ?> checked<?php       } ?> />
				<?php       echo t('everywhere')?>
				
				&nbsp;&nbsp; 
				<input type="radio" name="cParentID" id="cThisPageField" value="<?php       echo $c->getCollectionID()?>" <?php       if ($cParentID == $c->getCollectionID() || $cThis) { ?> checked<?php       } ?>>
				<?php       echo t('beneath this page')?>
				
				&nbsp;&nbsp;
				<input type="radio" name="cParentID" id="cOtherField" value="OTHER" <?php       if ($isOtherPage) { ?> checked<?php       } ?>>
				<?php       echo t('beneath another page')?> </div>
				
				<div class="ccm-page-list-page-other" <?php       if (!$isOtherPage) { ?> style="display: none" <?php       } ?>>
				
				<?php       $page = Loader::helper('form/page_selector');
				if ($isOtherPage) {
					print $page->selectPage('cParentIDValue', $cParentID);
				} else {
					print $page->selectPage('cParentIDValue');
				}
				?>
			</div>
			
			
			 <?php     
			  Loader::model('attribute/categories/collection');
			  $cadf = CollectionAttributeKey::getByHandle('is_featured');
			  ?>
			<br/>
			<h4><?php       echo t('Filter only Featured Posts')?></h4>
			<div class="input">
				<input <?php      if (!is_object($cadf)) { ?> disabled <?php      } ?> type="checkbox" name="displayFeaturedOnly" value="1" <?php      if ($displayFeaturedOnly == 1) { ?> checked <?php      } ?> style="vertical-align: middle" />
				<?php     echo t('Featured pages only.')?>
				<?php      if (!is_object($cadf)) { ?>
				<?php     echo t('(<strong>Note</strong>: You must create the "is_featured" page attribute first.)');?>
				<?php      } ?>
			</div>
		<br/>
	
		</div>

		<div class="pane sorting" style="display: none;">
		
			<div class="ccm-block-field-group">
			  <h4><?php       echo t('Sort Pages')?></h4>
			  <?php       echo t('Pages should appear')?>
			  <select name="orderBy">
				<option value="display_asc" <?php       if ($orderBy == 'display_asc') { ?> selected <?php       } ?>><?php       echo t('in their sitemap order')?></option>
				<option value="chrono_desc" <?php       if ($orderBy == 'chrono_desc') { ?> selected <?php       } ?>><?php       echo t('with the most recent first')?></option>
				<option value="chrono_asc" <?php       if ($orderBy == 'chrono_asc') { ?> selected <?php       } ?>><?php       echo t('with the earlist first')?></option>
				<option value="alpha_asc" <?php       if ($orderBy == 'alpha_asc') { ?> selected <?php       } ?>><?php       echo t('in alphabetical order')?></option>
				<option value="alpha_desc" <?php       if ($orderBy == 'alpha_desc') { ?> selected <?php       } ?>><?php       echo t('in reverse alphabetical order')?></option>
			  </select>
			</div>
			
			<div class="ccm-block-field-group">
				<h4><?php       echo t('Pagination')?></h4>
				<input type="checkbox" name="paginate" value="1" <?php       if ($paginate == 1) { ?> checked <?php       } ?> />
				<?php       echo t('Display pagination interface if more items are available than are displayed.')?>
			</div>
		
		</div>
	
		<div class="pane options" style="display: none;">
		
			<div class="ccm-block-field-group">
			<h4><?php       echo t('Show Subscription link')?></h4>
			<input id="ccm-pagelist-rssSelectorOn" type="checkbox" name="subscribe" class="rssSelector" value="1" <?php       echo ($subscribe?"checked=\"checked\"":"")?>/> <?php       echo t('Yes, show subscribe link.')?> 
			</div>
			
			<div class="ccm-block-field-group">
			<h4><?php       echo t('Provide RSS Feed')?></h4>
			<input id="ccm-pagelist-rssSelectorOn" type="radio" name="rss" class="rssSelector" value="1" <?php       echo ($rss?"checked=\"checked\"":"")?>/> <?php       echo t('Yes')?>   
			&nbsp;&nbsp;
			<input type="radio" name="rss" class="rssSelector" value="0" <?php       echo ($rss?"":"checked=\"checked\"")?>/> <?php       echo t('No')?>   
			<br /><br />
			<div id="ccm-pagelist-rssDetails" <?php       echo ($rss?"":"style=\"display:none;\"")?>>
			   <strong><?php       echo t('RSS Feed Title')?></strong><br />
			   <input id="ccm-pagelist-rssTitle" type="text" name="rssTitle" style="width:250px" value="<?php       echo $rssTitle?>" /><br /><br />
			   <strong><?php       echo t('RSS Feed Description')?></strong><br />
			   <textarea name="rssDescription" style="width:250px" ><?php       echo $rssDescription?></textarea>
			</div>
			</div>
		
		</div>
	</div>
</div>