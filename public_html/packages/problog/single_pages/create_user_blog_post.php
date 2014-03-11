<?php       defined('C5_EXECUTE') or die("Access Denied."); ?>
<style type="text/css">
#message { width: 740px; }

/*td {vertical-align: top; }*/
.blog_sidebar { padding: 10px; background: #FFF; -webkit-box-shadow: 0px 0px 2px 1px #9e9e9e; -moz-box-shadow: 0px 0px 2px 1px #9e9e9e; box-shadow: 0px 0px 2px 1px #9e9e9e; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; margin-bottom: 10px; width: 220px; float: right; -moz-border-radius: 12px 12px 12px 12px; border-radius: 12px 12px 12px 12px; }

.ccm-input-text { z-index: 1!important; }

#blogDate_dw { float: left; clear: both!important; }

#blogDate_tw { float: left; clear: both!important; padding-top: 8px; }

.blog_sidebar .ccm-input-text { width: 120px!important; }

.mceListBoxMenu { position: absolute!important; }

.error, .alert, .notice, .success, .info { padding: 0.8em; margin-bottom: 1em; border: 2px solid #ddd; }

.error, .alert { background: #fbe3e4; color: #8a1f11; border-color: #fbc2c4; }

.notice { background: #fff6bf; color: #514721; border-color: #ffd324; }

.success { background: #e6efc2; color: #264409; border-color: #c6d880; }

.ccm-ui label{text-align: left!important;}
</style>
<?php        
$df = Loader::helper('form/date_time');
$u = new User();
$uID = $u->getUserID();
$ui = UserInfo::getByID($u->getUserID());
//default use
if($ui->getAttribute('blog_group')){
	if($ui->getAttribute('blog_group') != ''){
		$userDepartment = $ui->getAttribute('blog_group')->get(0)->getSelectAttributeOptionValue();
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
	foreach($eb as $b) {
		if($b->getBlockTypeHandle()=='content'){
			$blogBody = $b->getInstance()->getContent();
		}
	}
	$task = 'editthis';
	$buttonText = t('Update Blog Entry');
	$title = 'Update';
} else {
	$task = 'addthis';
	$buttonText = t('Add Blog Entry');
	$title= 'Add';
	$cParentID = $ui->getUserBlogLocation();
}

?>
<?php        if ($this->controller->getTask() == 'editthis') { ?>
<form method="post" action="<?php       echo $this->action($task,$blog->getCollectionID())?>" id="blog-form">
<?php       echo $form->hidden('blogID', $blog->getCollectionID())?>
<?php        }else{ ?>
<form method="post" action="<?php       echo $this->action($task)?>" id="blog-form">
  <?php       } ?>
<div id="ccm-profile-wrapper" class="ccm-ui">
    <?php      if (isset($error)) { ?>
    <?php      
		if ($error instanceof Exception) {
			$_error[] = $error->getMessage();
		} else if ($error instanceof ValidationErrorHelper) {
			$_error = array();
			if ($error->has()) {
				$_error = $error->getList();
			}
		} else {
			$_error = $error;
		}
		
		if (count($_error) > 0) {
			?>
    <div class="message error"> <strong>
      <?php     echo t('The following errors occurred when attempting to process your request:')?>
      </strong>
      <ul>
        <?php      foreach($_error as $e) { ?>
        <li>
          <?php     echo $e?>
        </li>
        <?php      } ?>
      </ul>
    </div>
    <?php      
		}
	}
	
	if (isset($message)) { ?>
      <div class="message success">
        <?php     echo $message?>
      </div>
      <?php      } ?>
    <div id="ccm-profile-body">
		<div class="blog_sidebar"> 
			<strong>
			<?php       echo $form->label('blogDate', t('Date/Time'))?>
			</strong>
			<div>
			  <?php       echo $df->datetime('blogDate', $blogDate)?>
			</div>
			<br style="clear: both;"/>
			<br style="clear: both;"/>
			<?php        
				Loader::model("attribute/categories/collection");
				$akt = CollectionAttributeKey::getByHandle('tags');
				if (is_object($blog)) {
					$tvalue = $blog->getAttributeValueObject($akt);
				}
				?>
			<div class="blog-attributes">
			  <div> <strong>
			    <?php       echo $akt->render('label');?>
			    </strong>
			    <?php       echo $akt->render('form', $tvalue, true);?>
			  </div>
			</div>
			<br/>
			<div class="blog-attributes">
			  <?php     
				$co = new Config;
				$pkg = Package::getByHandle('problog');
				$co->setPackageObject($pkg);
				$share_attribute = $co->get("USER_BLOG_SHARE_ATTRIBUTE");
				$share_attribute = ucwords(str_replace('_',' ',$share_attribute));
				
				$shareOptions = array('all'=>"All", 'me' =>'Me Only','selected ' => "Selected $share_attribute");
				?>
			  <div> <strong>
			    <?php       echo $form->label('share_with', t('Share With'))?>
			    </strong>
			    <?php        if ($this->controller->getTask() == 'editthis') { ?>
			    <?php      $blogShareWith = $blog->getCollectionAttributeValue('share_with')->get(0)->getSelectAttributeOptionValue();?>
			    <?php      echo $form->select('share_with', $shareOptions, $blogShareWith);?>
			    <?php      } else { ?>
			    <?php      echo $form->select('share_with', $shareOptions, 'all');?>
			    <?php      } ?>
			  </div>
			</div>
			<br/>
			<strong>
			<?php       echo $form->label('blogCategory', t('Blog Category'))?>
			</strong>
			<?php        
				$akct = CollectionAttributeKey::getByHandle('blog_category');
				if (is_object($blog)) {
					$tcvalue = $blog->getAttributeValueObject($akct);
				}
				?>
			<div class="blog-attributes">
			  <div>
			    <?php       echo $akct->render('form', $tcvalue, true);?>
			  </div>
			</div>
			<input type="hidden" name="cParentID" value="<?php     echo  $cParentID;?>" />
			<br/>
			<!--
				<div class="blog-attributes" style="display: none;">
				-->
			<?php      /*
				<div class="blog-attributes">
					<div>	
						<strong><?php      echo t('Draft Copy')?></strong><br/>
						<?php      
						if($blog){
							$pa = $blog->getVersionObject();
							if($pa->isApproved()==1){$draft = 0;}else{$draft = 1;}
						}else{
							$draft = 0;
						}
						//var_dump($draft);
						//exit;
						$values = array(0=>'no',1=>'yes');
						?>
						<?php     echo $form->select('draft',$values,$draft)?><?php      echo t(' This is a Draft')?>
					</div>
				</div>
				<br/>
				*/
				?>
			<input type="hidden" name="draft" value="0" />
			<?php      
				
			$ctID = CollectionType::getByHandle("user_blog_post")->getCollectionTypeID();?>
			<input type="hidden" name="ctID" value="<?php     echo  $ctID;?>">
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
						if(is_object($event)) {
							$aValue = $event->getAttributeValueObject($ak);
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
		<div class="White_BG" style="float: left; margin-right: 20px; margin-left:10px; width: 490px;">
	        <h1>
	          	<span>
	      		<?php       echo t($title.' Blog')?>
	      		</span>
	      	</h1>
	      	<p>
	      		<?php       echo t('Blog Title')?>
	      	</p>
	      	<div>
	        	<?php       echo $form->text('blogTitle', $blogTitle, array('style' => 'width: 230px'))?>
	      	</div>
	      	<br/>
	      	<?php        
					Loader::model("attribute/categories/collection");
					$auth = CollectionAttributeKey::getByHandle('blog_author');
					$authID = $auth->getAttributeKeyID();
					if (is_object($blog)) {
						$authvalue = $blog->getCollectionAttributeValue($auth);
					} else {
						$authvalue = $uID;
					}
					?>
	      	<input type="hidden" name="blog_author" value="<?php     echo  $authvalue;?>" />
	      	<input type="hidden" name="user_pick_<?php     echo  $authID;?>" value="<?php     echo  $authvalue;?>" />
	      	<?php      
					Loader::model("attribute/categories/collection");
					$akt = CollectionAttributeKey::getByHandle('thumbnail');
					if (is_object($blog)) {
						$tvalue = $blog->getAttributeValueObject($akt);
					}
					?>
	      	<div class="blog-attributes">
	        	<div style="width: 230px;"> 
	        		<p>
	         		<?php       echo t('Thumbnail Image')?>
	          		</p>
	          		<?php       echo $akt->render('form', $tvalue, true);?>
	        	</div>
	      	</div>
	      	<br/>
			<p>
			<?php       echo $form->label('blogDescription', t('Blog Description'))?>
			</p>
			<div>
			<?php       echo $form->textarea('blogDescription', $blogDescription, array('style' => 'width: 98%; height: 90px; font-family: sans-serif;'))?>
			</div>
			<br/>
			<p>
			<?php       echo $form->label('blogBody', t('Blog Content'))?>
			</p>
			<?php        Loader::packageElement('editor_init','problog'); ?>
			<?php        Loader::packageElement('editor_config_blog','problog'); ?>
			<?php        //Loader::element('editor_controls', array('mode'=>'full')); ?>
			<?php        Loader::packageElement('editor_controls_users','problog',array('mode'=>'full'));?>
			<?php       echo $form->textarea('blogBody', $blogBody, array('style' => 'width: 100%; font-family: sans-serif;', 'class' => 'ccm-advanced-editor'))?>
			<br/>
			<br style="clear: both;" />
			<?php     
			$ih = Loader::helper('concrete/interface');
			$nh = Loader::helper('navigation');
			$u = new User();
			$ui = UserInfo::getByID($u->getUserID());
			$userBlogPage = Page::getByID($ui->getUserBlogLocation());
			//$link = $nh->getLinkToCollection($userBlogPage, true);
			$link = '/profile/user_blog';
			print $ih->button(t('Cancel'), $link, 'left','danger');
			print $ih->submit($buttonText, 'blog-form','right','success');
			?>
		</div>
	</div>
  <div class="ccm-spacer"></div>
</div>
</form>
