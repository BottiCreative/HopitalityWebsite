<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php   $textHelper = Loader::helper("text"); ?>
<?php 
$pkg = Package::getByHandle('discussion');
?>

<!--check mobile -->

<?php 
	if(defined('MOBILE_THEME_IS_ACTIVE') && MOBILE_THEME_IS_ACTIVE === true) { ?>
	<!--begin mobile layout -->

	<div class="ccm-discussion-container-mobile">
	<!-- begin displaying posts -->
	<?php 
		if (count($topics) > 0) {
			foreach($topics as $cat) { ?>
				<div class="ccm-discussion-post-mobile<?php   if ($cat->isPostPinned()) { ?> '-pinned'<?php   } ?>">
					<!-- <div>
						<?php 
						/*
						$ui = $cat->getUserObject();
						if(ENABLE_USER_PROFILES) { ?>
							<a href="<?php  echo $this->url("/profile",$ui->getUserID())?>"
							   rel="<?php  echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php  echo $ui->getUserID()?>"
							   class="<?php   if ($pkg->config('ENABLE_BADGES_OVERLAY')) { ?>ccm-show-badges-trigger<?php   } ?>" >
								<?php  echo  $av->outputUserAvatar($ui); ?>
							</a>
						<?php   }else{ ?>
							<a rel="<?php  echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php  echo $ui->getUserID()?>"
							   class="<?php   if ($pkg->config('ENABLE_BADGES_OVERLAY')) { ?>ccm-show-badges-trigger<?php   } ?>" >
								<?php  echo  $av->outputUserAvatar($ui); ?>
							</a>
						<?php   } */ ?>
					</div> -->

					<div class="ccm-discussion-category-name-mobile">
						<h2><a href="<?php  echo $nav->getLinkToCollection($cat)?>"><?php  echo $cat->getCollectionName()?></a></h2>
					</div>

					<div class="ccm-discussion-category-original-post-mobile">
						<?php 
							/*
							print 'Posted by  ' . $cat->getUserName() . '<br />on ' . date(DATE_APP_GENERIC_MDY_FULL, strtotime($cat->getCollectionDatePublic())) . ' at ' . date(DATE_APP_GENERIC_MDY_FULL, strtotime($cat->getCollectionDatePublic()));
							*/
						?>
						<?php 
							print 'Posted by  ' . $cat->getUserName();
						?>
					</div>

					<div class="ccm-discussion-category-post-count-mobile"><span><?php  echo 'Replies: ' . number_format($cat->getTotalReplies())?></span></div>

					<div class="ccm-discussion-category-last-post-mobile">
						<?php 
							/*
							$rpm = $cat->getLatestReply();
							if (!is_object($rpm)) {
								$rpm = $cat;
							}
							print $rpm->getUserName() . '<br />on ' . date(DATE_APP_GENERIC_MDY_FULL, strtotime($rpm->getCollectionDatePublic())) . ' at ' . date(DATE_APP_GENERIC_T, strtotime($rpm->getCollectionDatePublic()));
							*/
						?>
						<?php 
							$rpm = $cat->getLatestReply();
							if (!is_object($rpm)) {
								$rpm = $cat;
							}
							print 'Latest: ' . date(DATE_APP_GENERIC_MDY, strtotime($rpm->getCollectionDatePublic())) . ' at ' . date(DATE_APP_GENERIC_T, strtotime($rpm->getCollectionDatePublic()));
						?>
					</div>

				</div>

			<?php   }
		} else { ?>

		<div>
			<div colspan="6" style="text-align: center"><?php  echo t('There are no topics in this discussion')?></div>
		</div>

		<?php   } ?>
	</div>

	<?php 
	}else{
?>
<!-- here come the tables -->
<table border="0" cellspacing="0" cellpadding="0" class="ccm-discussion-category-list">
<thead>
<tr>
	<th colspan="2" class="<?php  echo $topicList->getSearchResultsClass('cvName')?>"><a href="<?php  echo $topicList->getSortByURL('cvName', 'asc')?>"><?php echo t('Topic')?></a></th>
	<th class="<?php  echo $topicList->getSearchResultsClass('cvDatePublic')?>"><a href="<?php  echo $topicList->getSortByURL('cvDatePublic', 'desc')?>"><?php  echo t('Original Post')?></a></th>
	<th class="<?php  echo $topicList->getSearchResultsClass('cvDatePublicLastPost')?>"><a href="<?php  echo $topicList->getSortByURL('cvDatePublicLastPost', 'desc')?>"><?php  echo t('Last Post')?></a></th>
	<th class="<?php  echo $topicList->getSearchResultsClass('totalViews')?>"><a href="<?php  echo $topicList->getSortByURL('totalViews', 'desc')?>"><?php echo t('Views')?></a></th>
	<th class="<?php  echo $topicList->getSearchResultsClass('totalPosts')?>"><a href="<?php  echo $topicList->getSortByURL('totalPosts', 'desc')?>"><?php echo t('Replies')?></a></th>
</tr>
</thead>
<tbody>
<?php 
if (count($topics) > 0) {
	foreach($topics as $cat) { ?>
		<tr <?php   if ($cat->isPostPinned()) { ?> class="ccm-discussion-post-pinned" <?php   } ?>>
			<td>
				<?php 
				$ui = $cat->getUserObject();
				if(ENABLE_USER_PROFILES) { ?>
					<a href="<?php  echo $this->url("/profile",$ui->getUserID())?>"
					   rel="<?php  echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php  echo $ui->getUserID()?>"
					   class="<?php   if ($pkg->config('ENABLE_BADGES_OVERLAY')) { ?>ccm-show-badges-trigger<?php   } ?>" >
						<?php  echo  $av->outputUserAvatar($ui); ?>
					</a>
				<?php   }else{ ?>
					<a rel="<?php  echo Loader::helper('concrete/urls')->getToolsURL('get_badges_content', 'discussion')?>?uID=<?php  echo $ui->getUserID()?>"
					   class="<?php   if ($pkg->config('ENABLE_BADGES_OVERLAY')) { ?>ccm-show-badges-trigger<?php   } ?>" >
						<?php  echo  $av->outputUserAvatar($ui); ?>
					</a>
				<?php   } ?>
			</td>
			<td class="ccm-discussion-category-name">
			<h2><a href="<?php  echo $nav->getLinkToCollection($cat)?>"><?php  echo $cat->getCollectionName()?></a></h2>
			</td>
			<td class="ccm-discussion-category-last-post"><?php 
				print $cat->getUserName() . ' on<br/>' . date(DATE_APP_GENERIC_MDY_FULL, strtotime($cat->getCollectionDatePublic())) . ' at<br/>' . date(DATE_APP_GENERIC_T, strtotime($cat->getCollectionDatePublic()));
			?></td>

			<td class="ccm-discussion-category-last-post"><?php 
				$rpm = $cat->getLatestReply();
				if (!is_object($rpm)) {
					$rpm = $cat;
				}

				print $rpm->getUserName() . ' on<br/>' . date(DATE_APP_GENERIC_MDY_FULL, strtotime($rpm->getCollectionDatePublic())) . ' at<br/>' . date(DATE_APP_GENERIC_T, strtotime($rpm->getCollectionDatePublic()));
			?></td>
			<td><?php  echo $cat->getTotalViews()?></td>
			<td><?php  echo number_format($cat->getTotalReplies())?></td>
		</tr>
	<?php   }
} else { ?>
<tr>
	<td colspan="6" style="text-align: center"><?php  echo t('There are no topics in this discussion')?></td>
</tr>
<?php   } ?>
</tbody>
</table>
<?php   $topicList->displayPaging()?>

<!-- end mobile check -->
<?php  } ?>
