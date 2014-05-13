<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>





<div class="fullwidthSlider">
	<div class="grid-12 columns nopad">
    
     	<?php  
			$a = new Area('HomeSlider');
			$a->display($c);
			?>
    
             <!--slider-->   
  
  <ul class="example-orbit" data-orbit>
  <li>
    <img src="/files/2713/9654/3309/headerimage-slide1.jpg" alt="headerimage.jpg" width="2000" height="782" />
    <div class="orbit-caption">
          <div class="row">
          
          <div class="grid-6 column push-6 sliderCopy">
          
          
<p class="home-Right whiteText">It's time to join the new Club</p>
<p class="home-Right whiteText"> for independent hospitality</p>
<p class="home-Right whiteText">business owners</p>

<div class="clearfix"></div>

<a href="#" data-reveal-id="VideoModal" class="SlideButt videoButt RightButt" >Find Out More</a>
          
          
          </div>
    </div>
    </div>
  </li>
  <li>

    <img src="/files/5513/9895/9619/headerimage-slide2.jpg" alt="headerimage.jpg" width="2000" height="782" />
    <div class="orbit-caption">
          <div class="row">
          
          <div class="grid-6 column sliderCopy">
          
         
<p class="home-Left whiteText">It's time to join the new Club</p>
<p class="home-Left whiteText"> for independent hospitality</p>
<p class="home-Left whiteText">business owners</p>
<div class="clearfix"></div>

<a href="#" data-reveal-id="VideoModal" class="SlideButt">Find Out More</a>


          
          
          </div>
    </div>
    </div>
  </li>

  
    <li>
    <img src="/files/2113/9895/9622/headerimage-slide3.jpg" alt="headerimage.jpg" width="2000" height="782" />
    <div class="orbit-caption">
          <div class="row">
          
          <div class="grid-6 column push-7 sliderCopy">
          
         
<p class="home-Right whiteText">It's time to join the new Club</p>
<p class="home-Right whiteText"> for independent hospitality</p>
<p class="home-Right whiteText">business owners</p>
<div class="clearfix"></div>

<a href="#" data-reveal-id="VideoModal" class="SlideButt RightButt" >Find Out More</a>


          
          
          </div>

    </div>
    </div>
  </li>
  
    <li>
    <img src="/files/1013/9895/9624/headerimage-slide4.jpg" alt="headerimage.jpg" width="2000" height="782" />
    <div class="orbit-caption">
          <div class="row">
          
          <div class="grid-6 column sliderCopy">
         
<p class="home-Left whiteText">It's time to join the new Club</p>
<p class="home-Left whiteText"> for independent hospitality</p>
<p class="home-Left whiteText">business owners</p>
<div class="clearfix"></div>

<a href="#" class="SlideButt">Find Out More</a>

 
          
          </div>
    </div>
    </div>
  </li>
  
  
  
</ul>

 <!--slider--> 
    
   
    
    
    
    
    </div>
</div>

<div class="videoResponsive">
<div class="row">
<div class="grid-12 columns">
<h2>It's time to join the new Club</h2>
<p> for independent hospitality <br />business owners</p>

<iframe width="853" height="480" src="//www.youtube.com/embed/vVUqpIRCLBs" frameborder="0" allowfullscreen></iframe>
</div>
</div><!--end row-->
</div><!--end videoResponsive-->


<div class="fullwidthform">
	<div class="row Homeform">
    

    	<?php  
			$a = new Area('wideform');
			$a->display($c);
			?>
    </div>
</div>

<div class="row">
	
    	<div class="grid-12 columns">
        	<?php  
			$a = new Area('homeintro');
			$a->display($c);
			?>
        </div>

</div><!--row-->

<div class="fullwidthgreen">
	<div class="row Homeform">
    

    	<?php  
			$a = new Area('Giveaway');
			$a->display($c);
			?>
    </div>
</div>


<div class="fullwidthtest">
	<div class="row">
      <div class="grid-12 columns">
        	<?php  
			$a = new Area('Content Title');
			$a->display($c);
			?>
        
        </div>
    
      <div class="grid-7 columns blog">
        	<?php  
			$a = new Area('blog');
			$a->display($c);
			?>
        
        </div>
        
          <div class="grid-5 columns videoContent">
        	<?php  
			$a = new Area('video');
			$a->display($c);
			?>
        
        </div>
    
    	<div class="grid-12 columns testimonial">
        <?php  
			$a = new Area('testimonial');
			$a->display($c);
			?>
            </div>
            
      
    </div>
</div>

<div class="row">
	<div class="grid-12 columns partners">
    	<?php  
			$a = new Area('partnersintro');
			$a->display($c);
			?>
        <?php  
			$a = new Area('partnersimages');
			$a->display($c);
			?>
    </div>
</div>


<div class="fullwidthmembers">
            <?php  
			$a = new Area('Full Wide');
			$a->display($c);
			?>
     
</div>

<div class="clearfix"></div>






<?php  $this->inc('elements/footer.php'); ?>