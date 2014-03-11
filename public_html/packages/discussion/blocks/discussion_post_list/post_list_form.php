<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?> 
<?php  $c = Page::getCurrentPage(); ?>
<ul id="ccm-discussion-postlist-tabs" class="ccm-dialog-tabs">
	<li class="ccm-nav-active"><a id="ccm-discussion-postlist-tab-add" href="javascript:void(0);"><?php echo ($bID>0)? t('Edit') : t('Add') ?></a></li>
	<li class=""><a id="ccm-discussion-postlist-tab-preview"  href="javascript:void(0);"><?php echo t('Preview')?></a></li>
</ul>

<input type="hidden" name="pageID" value="<?php echo $c->getCollectionID()?>/" />
<input type="hidden" name="postListToolsDir" value="<?php echo $uh->getBlockTypeToolsURL($bt)?>/" />
<div id="ccm-discussion-postlistPane-add" class="ccm-discussion-postlistPane">
	<div class="ccm-block-field-group">
	  <h2><?php echo t('Number of Posts')?></h2>
	  <?php echo t('Display')?>
	  <input type="text" name="num" value="<?php echo $num?>" style="width: 30px">
	  <?php echo t('Posts')?>
	   
	  <?php  // pinned, closed etc? 
	  /* 
	  <h2><?php echo t('Filter')?></h2>
	  <?php 
	  
	  Loader::model('attribute/categories/collection');
	  $cadf = CollectionAttributeKey::getByHandle('is_featured');
	  ?>
	  <input <?php  if (!is_object($cadf)) { ?> disabled <?php  } ?> type="checkbox" name="displayFeaturedOnly" value="1" <?php  if ($displayFeaturedOnly == 1) { ?> checked <?php  } ?> style="vertical-align: middle" />
	  <?php echo t('Featured pages only.')?>
		<?php  if (!is_object($cadf)) { ?>
			 <?php echo t('(<strong>Note</strong>: You must create the "is_featured" page attribute first.)');?></span>
		<?php  } ?>
		<br/>
		<input type="checkbox" name="displayAliases" value="1" <?php  if ($displayAliases == 1) { ?> checked <?php  } ?> />
		<?php echo t('Display page aliases.')?>
		<br/>
		*/ ?>
	</div>
	<div class="ccm-block-field-group">
	  <h2><?php echo t('Location in Website')?></h2>
	  <?php echo t('Display posts that are located')?>:<br/>
	  <br/>
	  <div>
			<input type="radio" name="cParentID" id="cEverywhereField" value="0" <?php  if ($cParentID == 0) { ?> checked<?php  } ?> />
			<?php echo t('everywhere')?>
			
			&nbsp;&nbsp; 
			<input type="radio" name="cParentID" id="cThisPageField" value="<?php echo $c->getCollectionID()?>" <?php  if ($cParentID == $c->getCollectionID() || $cThis) { ?> checked<?php  } ?>>
			<?php echo t('beneath this page')?>
			
			&nbsp;&nbsp;
			<input type="radio" name="cParentID" id="cOtherField" value="OTHER" <?php  if ($isOtherPage) { ?> checked<?php  } ?>>
			<?php echo t('beneath another page')?> </div>
			
			<div class="ccm-post-list-page-other" <?php  if (!$isOtherPage) { ?> style="display: none" <?php  } ?>>
			
			<?php 
			if ($isOtherPage) {
				print $form_page_selector->selectPage('cParentIDValue', $cParentID);
			} else {
				print $form_page_selector->selectPage('cParentIDValue');
			}
			?>
			
			</div>
	</div>
	<div class="ccm-block-field-group">
		<h2><?php echo t('Post Info')?></h2>
		<input type="checkbox" name="postInfo" value="1" <?php  if ($postInfo == 1) { ?> checked <?php  } ?> />
		<?php echo t('Display post info (user posted by and date posted)'); ?>
	</div>
	<div class="ccm-block-field-group">
		<h2><?php echo t('Pagination')?></h2>
		<input type="checkbox" name="paginate" value="1" <?php  if ($paginate == 1) { ?> checked <?php  } ?> />
		<?php echo t('Display pagination interface if more items are available than are displayed.')?>
	</div>
	
	<input type="hidden" name="orderBy" value="chrono_dec"/>
	<?php  /*  
	<div class="ccm-block-field-group">
	  <h2><?php echo t('Sort Posts')?></h2>
	  <?php echo t('Pages should appear')?>
	  <select name="orderBy">
		<!--  <option value="display_asc" <?php  if ($orderBy == 'display_asc') { ?> selected <?php  } ?>><?php echo t('in their sitemap order')?></option>  -->
		<option value="chrono_desc" <?php  if ($orderBy == 'chrono_desc') { ?> selected <?php  } ?>><?php echo t('with the most recent first')?></option>
		<option value="chrono_asc" <?php  if ($orderBy == 'chrono_asc') { ?> selected <?php  } ?>><?php echo t('with the earlist first')?></option>
		<option value="alpha_asc" <?php  if ($orderBy == 'alpha_asc') { ?> selected <?php  } ?>><?php echo t('in alphabetical order')?></option>
		<option value="alpha_desc" <?php  if ($orderBy == 'alpha_desc') { ?> selected <?php  } ?>><?php echo t('in reverse alphabetical order')?></option>
	  </select>
	</div>
	*/ ?>
	<style type="text/css">
		#ccm-discussion-postlist-truncateTxt.faintText{ color:#999; }
	</style>	
	<?php  if(truncateChars==0 && !$truncateSummaries) $truncateChars=128; ?>
	<div class="ccm-block-field-group">
	   <h2><?php echo t('Truncate Summaries')?></h2>	  
	   <input id="ccm-discussion-postlist-truncateSummariesOn" name="truncateSummaries" type="checkbox" value="1" <?php echo ($truncateSummaries?"checked=\"checked\"":"")?> /> 
	   <span id="ccm-discussion-postlist-truncateTxt" <?php echo ($truncateSummaries?"":"class=\"faintText\"")?>>
	   		<?php echo t('Truncate descriptions after')?> 
			<input id="ccm-discussion-postlist-truncateChars" <?php echo ($truncateSummaries?"":"disabled=\"disabled\"")?> type="text" name="truncateChars" size="3" value="<?php echo intval($truncateChars)?>" /> 
			<?php echo t('characters')?>
	   </span>
	</div>
	<?php  
	// only display the tag filtering stuff if the discussion_post_tags attribute exists 
	Loader::model('attribute/categories/collection');
	$tagAk = CollectionAttributeKey::getByHandle(DISCUSSION_POST_TAG_HANDLE);
	if($tagAk instanceof AttributeKey) { ?>
	<div class="ccm-block-field-group">
	   <h2><?php echo t('Filter By Tags')?></h2>	  
		<label>
			<?php echo $form->radio('tagFilter','none',$tagFilter);?> <?php  echo t('None')?>
		</label><br/>
		<label>
			<?php echo $form->radio('tagFilter','page', $tagFilter);?> <?php  echo t('Matching Tags From This Page')?>
		</label><br/>
		<label>
			<?php echo $form->radio('tagFilter','specific', $tagFilter);?> <?php  echo t('Matching Specific Tags')?>
		</label><br/>	
		<div id="tag-selector-form" style="display:none; padding-left: 24px;">
			<?php 
				if(strlen($tagValues)) {
					$existingTags = $json->decode($tagValues);
					if(is_array($existingTags)) {
						foreach($existingTags as $t) {
							echo '<div class="newAttrValue">';
							echo $form->hidden('akID['.$tagAk->akID.'][atSelectNewOption][]',$t);
							echo $t;
							echo ' <a href="javascript:void(0)" onclick="ccmAttributeTypeSelectTagHelper'.$tagAk->akID.'.remove(this)">x</a>'.
							'</div>';
						} 
					}
				}
				echo $tagAk->render('form',$value,true);
			?>
		</div>
	</div>
	<?php  } ?>
	
	<div class="ccm-block-field-group">
		<h2><?php echo t('Discussion Posting')?></h2>
		<input type="checkbox" name="enablePosting" onclick="if($(this).attr('checked')) { $('#select-discussion-location').show(); }else{ $('#select-discussion-location').hide(); }" value="1" <?php  if ($postToCID > 0) { ?> checked="checked"<?php  } ?> />
		Include Post Button
		<div id="select-discussion-location" style="<?php  if (!$postToCID) { ?>display:none;<?php  }?> padding-top:4px;">
			<strong>Select Discussion:</strong>
			<?php  
			$form = Loader::helper('form/page_selector');
			if ($postToCID) {
				print $form->selectPage('postToCID', $postToCID);
			} else {
				print $form->selectPage('postToCID');
			}
			?>
		</div>
	</div>
	
</div>

<div id="ccm-discussion-postlistPane-preview" style="display:none" class="ccm-preview-pane ccm-discussion-postlistPane">
	<div id="postlist-preview-content"><?php echo t('Preview Pane')?></div>
</div>
