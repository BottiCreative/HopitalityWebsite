<?php       
	defined('C5_EXECUTE') or die(_("Access Denied."));
	global $c;
	$blogify = Loader::helper('blogify','problog');
	extract($blogify->getBlogSettings());
	extract($blogify->getBlogVars($c));
	?>
	
		<h1><?php echo $blogTitle; ?> </h1>
	
	
    <div class="blog-attributes">
    
    <div class="grid-5 columns nopadLeft">
    <p><strong>Posted</strong> <?php echo date(t('M d, Y'),strtotime($blogDate));  ?></p>
    </div>
    <div class="grid-7 columns nopadRight">
    <div class="shareSocialPost">
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
<span class='st_linkedin_large' displayText='LinkedIn'></span>
<span class='st_pinterest_large' displayText='Pinterest'></span>
</div> 
    
    </div>
    


    
    </div>
	<?php       
	//go get the content block
	$content = $blogify->closetags(str_replace($breakSyntax,'',$controller->getContent()));
	print $content;
	?>
	<div id="twee">
		<br/>
		<?php       
		//check the settings for each social link and display
		if($tweet>0){
		?>
			<span class='st_twitter_hcount' displayText='Tweet'></span>
		<?php       }
		if($fb_like==1){
		?>
			<span class='st_facebook_hcount' displayText='Facebook'></span>
		
		<?php      
		}
		if($google==1){
		?>
			<span class='st_plusone_hcount' displayText='Plusone'></span>
		<?php      
		}
		?>
			<script type="text/javascript">var switchTo5x=true;</script>
			<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
			<?php       if($sharethis){ ?>
			<script type="text/javascript">stLight.options({publisher:'<?php       echo $sharethis;?>'});</script>
			<?php       } ?>
	</div>
	<br/>
    
    
       <div class="shareSocial">
<p>Share This</p>
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
<span class='st_linkedin_large' displayText='LinkedIn'></span>
<span class='st_pinterest_large' displayText='Pinterest'></span>
<span class='st_email_large' displayText='Email'></span>
</div> 
    
    
    
    
	<div class="taglist">
		<?php      echo t('Tags')?>:
		<?php       
		if(!empty($tag_list)){
			$x = 0;
			foreach($tag_list as $akct){
				if($x){echo ', ';}
				echo '<a href="'.BASE_URL.$search.str_replace(' ','_',$akct->getSelectAttributeOptionValue()).'/">'.$akct->getSelectAttributeOptionValue().'</a>';
				$x++;
					
			}
		}
		?>
	</div>
	<div class="taglist">
		<?php  echo t('Category').': '.'<a href="'.BASE_URL.$search.'categories/'.str_replace(' ','_',$cat).'/">'.$cat.'</a>';?>
	</div>
	<?php       
	if($author == 1){
		//if show author is set in settings,
		$ba = $c->getAttribute('blog_author');
		if($ba){
			$ui = UserInfo::getByID($ba);
			extract($blogify->getBlogAuthorInfo($ui));
			$uAvatar = $blogify->getPosterAvatar($ba);
		}
	?>
	<div id="bio" itemscope itemtype="https://data-vocabulary.org/Person">
    

		
	    <div id="bioInfo">
        
    <div class="grid-2 columns">
    
       	<div id="avatar"><span itemprop="photo">
	    		<?php       	echo  $uAvatar; ?>
	    	</span></div>
    </div>
    <div class="grid-10 columns">
    	
        <h3>Author:<span itemprop="name"> <?php  echo $firstName.' '.$lastName; ?></span></h3>
	    <h5><?php echo $uLocation ; ?></h5>
	 
	    	<p>
	    	<?php       
	    	if(isset($aboutBio)){
	    		echo "<span itemprop=\"title\">" . $aboutBio . "</span>"; 
	    	}else{
	    		echo t('<i> Please add your bio info through your member profile page, or through your dashboard.</i>');
	    	}
	    	?>
	    	</p> 
    
    </div>
    
			
	    </div>
	</div>
	<?php  } ?>
 <br style="clear: both;"/>