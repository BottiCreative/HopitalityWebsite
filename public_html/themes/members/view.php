<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>



		<div class="sideStripNav">
        
        
			<ul class="tt-wrapper">
				<li><a class="he-home" href="<?php echo DIR_REL; ?>/profile"><span>Home</span></a></li>
				<li><a class="he-resources" href="#"><span>Resources</span></a></li>
				<li><a class="he-blog" href="#"><span>Blog</span></a></li>
				<li><a class="he-forum" href="#"><span>Forum</span></a></li>

			</ul>
            
       
            
            
            <div class="sideMemebersNav">
            <ul class="tt-wrapper footericonNav">
				<li><a class="he-logout" href="#"><span>Support</span></a></li>
				<li><a class="he-support" href="<?php echo DIR_REL; ?>/"><span>Log Out</span></a></li>
			</ul>
            </div>
            
            

        </div>
        
       
     <div class="rowWide" >
      
      <div class="grid-12 columns">
      
        <?php  
        	$a = new GlobalArea('Members Top Nav');
        	$a->display();
         ?>
      
      </div>

      
      </div>
        
     <div class="rowWide membersAreaWrapper">
     
     
        	<div class="grid-12 columns">
			<?php  print $innerContent; ?>
            

		</div>






	
	<!-- end full width content area -->
	
<?php  $this->inc('elements/footer.php'); ?>
