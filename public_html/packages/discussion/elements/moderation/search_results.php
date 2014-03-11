<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
$uh = Loader::helper('concrete/urls');
$form = Loader::helper('form');
?> 
<div id="ccm-list-wrapper">
<?php 
	if (!$mode) {
		$mode = $_REQUEST['mode'];
	}
	$txt = Loader::helper('text');
	$keywords = $_REQUEST['keywords'];
	
	if (count($posts) > 0) { ?>	
		<table border="0" cellspacing="0" cellpadding="0" id="ccm-product-list" class="ccm-results-list">
		<tr>
			<th><input id="ccm-discussion-list-cb-all" type="checkbox" /></th>
			<th><select name="posts_action" id="ccm-discussion-list-multiple-operations" disabled>
				<option value="">**</option>
				<option value="approve"><?php  echo t('Approve')?></option>
				<option value="delete"><?php  echo t('Delete')?></option>
			</select>
			&nbsp;
			</th>
			<th><a href="<?php echo $postList->getSortByURL('post_title', 'asc')?>"><?php echo t('Post')?></a></th>
			<th><a href="<?php echo $postList->getSortByURL('post_user', 'asc')?>"><?php echo t('Username')?></a></th>
			<th><a href="<?php echo $postList->getSortByURL('date_added', 'asc')?>"><?php echo t('Date Posted')?></a></th>
		</tr>
	<?php  
	foreach($posts as $post) { 
		if (!isset($striped) || $striped == 'ccm-list-record-alt') {
			$striped = '';
		} else if ($striped == '') { 
			$striped = 'ccm-list-record-alt';
		} ?>
		<tr class="ccm-list-record <?php echo $striped?>">
			<td><?php  echo $form->checkbox('postIDs[]',$post->getCollectionID());?></td>
			<td colspan="2">
				<a href="javascript:void(0)" onclick="$(this).next('.ccm-discussion-post-body').toggle();" title="<?php  echo $post->getCollectionPath(); ?>">
				<?php  
					$d = $post->getDiscussion();
					if($d instanceof Page) { echo $d->getCollectionName()." :"; }
				?>
				<?php  echo $post->getCollectionName();?></a>
				<div style="display:none;" class="ccm-discussion-post-body">
					<div><?php  echo $post->getHTMLBody(); ?></div>
					<div>
						<?php  
						$a = new Area('Attachments'); 
						$attachments = $a->getAreaBlocksArray($post);
						if (count($attachments) > 0) { ?>
							<strong><?php echo t('Attachments')?>:</strong>
							<?php  $a->display($post); ?>
						<?php  } ?>
					</div>
				</div>
			</td>
			<td><?php 
				$ui = $post->getUserObject();
				if($ui->getUserID() > 0) {
					echo '<a href="'.View::url('/dashboard/users/search').'?uID='.$ui->getUserID().'">'.$ui->getUserName().'</a>';	
				} else { echo $ui->getUserName(); }
			?></td>
			<td><?php  echo $post->getCollectionDateAdded();?></td>
		</tr>
	<?php  } ?>
	</table>
	<?php  } else { ?>
		<div id="ccm-list-none"><?php echo t('No posts found.')?></div>
	<?php  } 
	$postList->displayPaging(); ?>
	
</div>