<?php       defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php      
  if (isset($_GET['pageno'])) {
   	$pageno = $_GET['pageno'];
	} else {
   	$pageno = 1;
	} // if
?>
<div>
	<?php      echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Blog Comments'), false, false, false);?>
		<div class="ccm-pane-body">
			<!--
			<ul class="breadcrumb">
			  <li><a href="/index.php/dashboard/problog/list/">List</a> <span class="divider">|</span></li>
			  <li><a href="/index.php/dashboard/problog/add_blog/">Add/Edit</a> <span class="divider">|</span></li>
			  <li class="active">Comments <span class="divider">|</span></li>
			  <li><a href="/index.php/dashboard/problog/settings/">Settings</a></li>
			</ul>
			-->
			<?php     
			$blogify = Loader::helper('blogify','problog');
			$settings = $blogify->getBlogSettings();
			if($settings['disqus']){
				print '<div id="recentcomments" class="dsq-widget"><h2 class="dsq-widget-title">Latest Comments</h2><script type="text/javascript" src="http://'.$settings['disqus'].'.disqus.com/recent_comments_widget.js?num_items='.$limit.'&hide_avatars=0&avatar_size=22&excerpt_length=100"></script></div><a href="http://disqus.com/">Powered by Disqus</a>';
			}else{
			?>
			<form name="do_comment" action="<?php      echo $this->action('comment_proccess')?>" method="post">
			<br/>
			<div id="comment_action">
				<select name="comment_todo">
					<option value="approve"><?php     echo t('Approve')?></option>
					<option value="unapprove"><?php     echo t('Unapprove')?></option>
					<option value="remove"><?php     echo t('Remove')?></option>
				</select>
				<input type="submit" name="do" value="<?php     echo t('submit')?>" class="btn"/>
			</div>
			<br/>
			<table class="ccm-results-list" cellspacing="1" cellpadding="4">
				<tr>
					<td class="subheader"></td>
					<td class="subheader"><?php      echo t('Status')?></td>
					<td class="subheader"><?php      echo t('User Info')?></td>
					<td class="subheader"><?php      echo t('Date')?></td>
					<td class="subheader" style="width: 400px;"><?php      echo t('Comment')?></td>
				</tr>
			<?php       		
				//count the number of current posts returned
					$num = 15;	
					$pcount = count($comments);
					
				//now calc the last page	
					$lastpage = ceil($pcount/$num);
					
				
				//set the current page min max keys -1 as array key's start @ 0
					$sKey = $num * ($pageno-1) ;
					$eKey = ($num * ($pageno-1)) + ($num-1) ;
					
				foreach($comments as $key => $comment){
					if($key >= $sKey && $key <= $eKey){
					?>
						<tr>
							<td>
								<input type="checkbox" name="comment_do[<?php      echo $comment['entryID']?>]" value="1"/>
							</td>
							<td>
								<?php    
								if($comment['approved']==true){
								?>
						 		<img src="<?php      echo ASSETS_URL_IMAGES?>/icons/success.png" width="16" height="16"/>
						 		<?php    
						 		}else{
							 	?>
							 	<img src="<?php      echo ASSETS_URL_IMAGES?>/icons/warning.png" width="16" height="16"/>
							 	<?php    
						 		}
						 		?>
						 	</td>
						 	<td>
						 		<?php      echo $comment['user_name']?><br/>
						 		<?php      echo $comment['user_email']?>
						 	</td>
						 	<td>
						 		<?php      echo date(DATE_APP_GENERIC_MDYT_FULL,strtotime($comment['entryDate']))?>
						 	</td>
						 	<td>
						 		<?php      
						 		$parent = Page::getByID($comment['cID']);
						 		$nh = Loader::helper('navigation');
						 		$path = $nh->getLinkToCollection($parent);
						 		?>
						 		<a href="<?php      echo $path?>" target="_blank"><?php      echo $path?></a><br style="margin-bottom: 12px!important;"/>
						 		<?php      echo $comment['commentText']?>
						 	</td>
						</tr>
					<?php      
					}
				}
			?>
			</table>
			</form>
			<br/>
			<?php       
				if ($pcount > $num) {
					echo '<div id="pagination">';
				
					if ($pageno == 1) {
							echo t(" FIRST PREV ");
					} else {
							echo '<a href="?pageno=1">'.t('FIRST ').'</a>';
							$prevpage = $pageno-1;
							echo '<a href="?pageno='.$prevpage.'">'.t(' PREV').'</a>';
					} // if
				
					echo ' ( Page '.$pageno.' of '.$lastpage.' ) ';
				
					if ($pageno == $lastpage) {
							echo t(" NEXT LAST ");
					} else {
							$nextpage = $pageno+1;
							echo '<a href="?pageno='.$nextpage.'">'.t('NEXT ').'</a>';
							echo '<a href="?pageno='.$lastpage.'">'.t(' LAST').'</a>';
					} // if		
					echo '</div>';
				}	
			}
			?>
			<br/>
		</div>
		<div class="ccm-pane-footer">
	    </div>
	</div>