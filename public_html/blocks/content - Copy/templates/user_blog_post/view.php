<?php       
	defined('C5_EXECUTE') or die(_("Access Denied."));
	global $c;
	$blogify = Loader::helper('blogify','problog');
	Loader::model("attribute/categories/collection");
	//get this install's blog settings
	$blog_settings = $blogify->getBlogSettings();
	$BASE_URL = BASE_URL;
	
	//link url to page
	$url = Loader::helper('navigation')->getLinkToCollection($c);
	
	//this pages collection ID
	$cID = $c->getCollectionID();
	
	//get post title
	$blogTitle = $c->getCollectionName();
	//get post public date
	$blogDate = $c->getCollectionDatePublic(DATE_APP_GENERIC_MDYT_FULL);
	
	//get author
	$authorID = $c->getAttribute('blog_author');
	if(!$authorID){
		$authorID = $c->getCollectionUserID();
	}
	//if editing via page_type defaults, set bogus author
	if(!$authorID){
		$authorID = '1';
	}
	//grab the user info object
	$ui = UserInfo::getByID($authorID); 
	
	$u = new User();
	if ($u->getUserID() == $ui->getUserID()){
		$canEdit = 1;
		$editURL = $this->url('/create_user_blog_post', 'editthis', $c->getCollectionID());
	} else {
		$canEdit = 0;
	}
	
	//get tags
	$tags = $c->getAttribute('tags');
	//get category
	$cat = $c->getAttribute('blog_category');
	?>
	<?php      if ($canEdit){?>
	<h5 style="float: right; margin-top: 15px;"><a class="BTN Small" style="width:80" href="<?php     echo  $editURL;?>" title="<?php     echo  t("Edit this post");?>">
	  <?php     echo  t("Edit");?>
	  </a> &nbsp; | &nbsp;<a class="BTN Small deletethis" style="width:80 href="javascript:;" title="<?php     echo  t("remove this post");?>">
	  <?php     echo  t("Remove");?>
	  </a></h5>
	<?php      }?>
	<div class="blog-attributes">
		<div>
			<h1><?php       echo $blogTitle; ?> </h1>
		</div>
	</div>
	<h4><?php       echo $blogDate ?></h4>
	<?php      
	//go get the content block
	$content = $controller->getContent();
	print $content;
	?>
	<div id="twee">
		<br/>
		<?php      
		//check the settings for each social link and display
		if($blog_settings['tweet']>0){
		?>
			<span class='st_twitter_hcount' displayText='Tweet'></span>
		<?php       }
		if($blog_settings['fb_like']==1){
		?>
			<span class='st_facebook_hcount' displayText='Facebook'></span>
		
		<?php     
		}
		if($blog_settings['google']==1){
		?>
			<span class="st_plusone_hcount" displayText="Plusone"></span>
		<?php     
		}
		?>
			<script type="text/javascript">var switchTo5x=true;</script>
			<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
	</div>
	<br/>
	<div class="taglist">
		<?php     echo t('Tags')?>: <i><?php       echo $tags; ?></i>
	</div>
	<div class="taglist">
		<?php     echo t('Category')?>: <i><?php       echo $cat; ?></i>
	</div>
	<?php      
	if($blog_settings['author'] == 1){
		//if show author is set in settings,
		//grab each info object
		//the nab the avatar
		$aboutBio = $ui->getUserUserBio();
		$firstName = $ui->getUserFirstName();
		$lastName = $ui->getUserLastName();
		$uName = $ui->getUserUname();
		$uEmail = $ui->getUserUemail();
		$uLocation = $ui->getUserUlocation();
		$uAvatar = $blogify->getPosterAvatar($authorID);
    	
	?>
	<div id="bio">
		<h2><?php       echo $aboutTitle ; ?></h2>
	    <div id="bioInfo">
	    <h3><?php       echo $firstName.' '.$lastName; ?></h3>
	    <h5><?php       echo $uLocation ; ?></h5>
	    	<div id="avatar">
	    		<?php      	echo  $uAvatar; ?>
	    	</div>
	    	<p>
	    	<?php       
	    	if(isset($aboutBio)){
	    		echo $aboutBio ; 
	    	}else{
	    		echo '<i> Please add your bio info through your member profile page, or through your dashboard.</i>';
	    	}
	    	?>
	    	</p> 		
	    </div>
	</div>
	<?php        
	}
	?>
 <br style="clear: both;"/>
 <script type="text/javascript">
 	$('.deletethis').click(function(){
 		var answer = confirm('Are you sure you want to delete this? \n\r This action may not be undone!');
 		if(answer){
 			var url = '<?php     echo $remove?>/?ccID=<?php     echo $c->getCollectionID()?>';
 			$.get(url,function(response){
 				window.location.replace("/index.php/?cID=<?php     echo $c->getCollectionParentID()?>");
 			});
 		}
 	})
 </script>