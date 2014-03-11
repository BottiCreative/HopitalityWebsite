<style type="text/css">
a:hover {text-decoration:none;} /*BG color is a must for IE6*/
a.tooltip span {display:none; padding:2px 3px; margin-left:8px; margin-top: -20px;}
a.tooltip:hover span{display:inline; position:absolute; background:#ffffff; border:1px solid #cccccc; color:#6c6c6c;}
th {text-align: left;}
.align_top{vertical-align: top;}
.ccm-results-list tr td{ border-bottom-color: #dfdfdf; border-bottom-width: 1px; border-bottom-style: solid;}
.icon {
display: block;
float: left;
height:20px;
width:20px;
background-image:url('<?php       echo ASSETS_URL_IMAGES?>/icons_sprite.png'); /*your location of the image may differ*/
}
.edit {background-position: -22px -2225px;margin-right: 6px!important;}
.copy {background-position: -22px -439px;margin-right: 6px!important;}
.delete {background-position: -22px -635px;}
</style>
<?php      echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('View/Search Blog'), false, false, false);?>
	<div class="ccm-pane-body">
		<?php      
		if($remove_name){
		?>
		<div class="alert-message block-message error">
		  <a class="close" href="<?php       echo $this->action('clear_warning');?>">×</a>
		  <p><strong><?php       echo t('Holy guacamole! This is a warning!');?></strong></p><br/>
		  <p><?php       echo t('Are you sure you want to delete ').$remove_name.'?';?></p>
		  <p><?php       echo t('This action may not be undone!');?></p>
		  <div class="alert-actions">
		    <a class="btn small" href="<?php       echo BASE_URL.DIR_REL;?>/index.php/dashboard/problog/list/deletethis/<?php       echo $remove_cid;?>/<?php       echo $remove_name;?>/"><?php       echo t('Yes Remove This');?></a> <a class="btn small" href="<?php       echo $this->action('clear_warning');?>"><?php       echo t('Cancel');?></a>
		  </div>
		</div>
		<?php      
		}
		?>
		<?php      
		$ublog = Page::getByPath('/user_blogs');
		if($ublog->cID != ''){
		?>
		<ul class="breadcrumb">
		  <li class="active"><?php       echo t('Blog Posts');?> <span class="divider">|</span></li>
		  <li><a href="/index.php/dashboard/problog/list/show_user_blogs"><?php       echo t('User Blogs');?></a></li>
		</ul>
		<?php      
		}
		?>
		<form method="get" action="<?php       echo $this->action('view')?>" id="blog_search">
		<?php       
		$sections[0] = '** All';
		asort($sections);
		?>
		<table border="0" cellspacing="0" cellpadding="0" class="ccm-results-list" >
			<tr>
				<th><strong><?php       echo $form->label('cParentID', t('Section'))?></strong></th>
				<th><strong><?php       echo t('by Name')?></strong></th>
				<th><strong><?php       echo t('by Category')?></strong></th>
				<th><strong><?php       echo t('by Tag')?></strong></th>
				<th></th>
			</tr>
			<tr>
				<td><?php       echo $form->select('cParentID', $sections, $cParentID)?></td>
				<td><?php       echo $form->text('like', $like)?></td>
				<td>
				<select name="cat" style="width: 110px!important;">
					<option value=''>--</option>
				<?php       
				foreach($cat_values as $cat){
					if($_GET['cat']==$cat['value']){$selected = 'selected="selected"';}else{$selected=null;}
					echo '<option '.$selected.'>'.$cat['value'].'</option>';
				}	
				?>
				</select>
				</td>
				<td>
				<select name="tag" style="width: 110px!important;">
					<option value=''>--</option>
				<?php       
				foreach($tag_values as $tag){
					if($_GET['tag']==$tag['value']){$selected = 'selected="selected"';}else{$selected=null;}
					echo '<option '.$selected.'>'.$tag['value'].'</option>';
				}	
				?>
				</select>
				</td>
				<td>
				<?php       echo $form->submit('submit_form', t('Search'))?>
				</td>
			</tr>
		</table>
		

		<br/>
		<div style="float: right;">
			<input type="checkbox" name="only_unaproved" id="only_unaproved" value="1" <?php      if($_GET['only_unaproved']==1){echo 'checked';}?>> <?php     echo t('Only Show Unapproved')?>
		</div>
			<div style="float: left;">
			<?php       
			$nh = Loader::helper('navigation');
			if ($blogList->getTotal() > 0) { 
				$blogList->displaySummary();
				?>
			</div>
		</form>
		<br/>
		<table border="0" class="ccm-results-list zebra-striped" cellspacing="0" cellpadding="0">
			<tr>
				<th>&nbsp;</th>
				<th class="<?php       echo $blogList->getSearchResultsClass('cvName')?>"><a href="<?php       echo $blogList->getSortByURL('cvName', 'asc')?>"><?php       echo t('Name')?></a></th>
				<th class="<?php       echo $blogList->getSearchResultsClass('cvDatePublic')?>"><a href="<?php       echo $blogList->getSortByURL('cvDatePublic', 'asc')?>"><?php       echo t('Date')?></a></th>
				<th><?php       echo t('Page Owner')?></th>
				<th class="<?php       echo $blogList->getSearchResultsClass('blog_category')?>"><a href="<?php       echo $blogList->getSortByURL('blog_category', 'asc')?>"><?php       echo t('blog Category')?></a></th>
				<th><?php       echo t('In Draft')?></th>
			</tr>
			<?php       
			$pkt = Loader::helper('concrete/urls');
			$pkg= Package::getByHandle('problog');
			foreach($blogResults as $cobj) { 
			
				Loader::model('attribute/categories/collection');
						
				$akct = CollectionAttributeKey::getByHandle('blog_category');
				$blog_category = $cobj->getCollectionAttributeValue($akct);
				
			?>
			<tr>
				<td width="60px">
				<a href="<?php       echo $this->url('/dashboard/problog/add_blog', 'edit', $cobj->getCollectionID())?>" class="icon edit"></a> &nbsp;
				<a href="<?php       echo $this->url('/dashboard/problog/list', 'delete_check', $cobj->getCollectionID(),$cobj->getCollectionName())?>" class="icon delete"></a>
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
				<td>
					<?php       
					$user = UserInfo::getByID($cobj->getCollectionUserID());
					if($user){
						echo $user->getUserName();
					}
					?>
				</td>
				<td><?php       echo $blog_category;?></td>
				<td>
				<?php       
				if(!$cobj->isActive()){
				echo '<a href="'.$this->url('/dashboard/problog/list', 'approvethis', $cobj->getCollectionID(),$cobj->getCollectionName()).'">Approve This</a>';
				}
				?>
				</td>
			</tr>
			<?php       } ?>
			
			</table>
			<br/>
			<?php       
			$blogList->displayPaging();
		} else {
			print t('No Blog entries found.');
		}
		?>
	</div>
    <div class="ccm-pane-footer">

    </div>
	<script type="text/javascript">
	/*<![CDATA[*/
		$('#only_unaproved').click(function(){
			$('form#blog_search').submit();
		});
	/*]]>*/
	</script>