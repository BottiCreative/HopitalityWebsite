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
    <img src="/files/7613/9600/7646/headerimage1.jpg" alt="headerimage.jpg" width="2000" height="782" />
    <div class="orbit-caption">
          <div class="row">
          
          <div class="grid-6 column">
          
<h2 class="home-Left">Wake up!...</h2>
<p class="home-Left whiteText">It's time to join the new Club</p>
<p class="home-Left whiteText"> for independent hospitality</p>
<p class="home-Left whiteText">business owners</p>

<div class="clearfix"></div>

<a href="#" class="SlideButt videoButt" >Find Out More</a>

<div class="VideoHide">
<iframe width="853" height="480" src="//www.youtube.com/embed/vVUqpIRCLBs" frameborder="0" allowfullscreen></iframe>
</div>
          
          
          </div>
    </div>
    </div>
  </li>
  <li>
    <img src="/files/2813/9600/7653/headerimage4.jpg" alt="headerimage.jpg" width="2000" height="782" />
    <div class="orbit-caption">
          <div class="row">
          
          <div class="grid-6 column">
          
          <h2 class="home-Left">slide-2...</h2>
<p class="home-Left whiteText">It's time to join the new Club</p>
<p class="home-Left whiteText"> for independent hospitality</p>
<p class="home-Left whiteText">business owners</p>
<div class="clearfix"></div>

<a href="#" class="SlideButt">Find Out More</a>


          
          
          </div>
    </div>
    </div>
  </li>

  
    <li>
    <img src="/files/3713/9600/7651/headerimage3.jpg" alt="headerimage.jpg" width="2000" height="782" />
    <div class="orbit-caption">
          <div class="row">
          
          <div class="grid-6 column push-7">
          
          <h2 class="home-Right">Slide-3...</h2>
<p class="home-Right whiteText">It's time to join the new Club</p>
<p class="home-Right whiteText"> for independent hospitality</p>
<p class="home-Right whiteText">business owners</p>
<div class="clearfix"></div>

<a href="#" class="SlideButt RightButt" >Find Out More</a>


          
          
          </div>
    </div>
    </div>
  </li>
  
    <li>
    <img src="/files/2013/9600/7649/headerimage2.jpg" alt="headerimage.jpg" width="2000" height="782" />
    <div class="orbit-caption">
          <div class="row">
          
          <div class="grid-6 column">
          
          <h2 class="home-Left">Slide-4...</h2>
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


<div class="fullwidthtest">
	<div class="row">
    	<div class="grid-7 columns testimonial">
        <?php  
			$a = new Area('testimonial');
			$a->display($c);
			?>
            </div>
            
        <div class="grid-5 columns blog">
        	<?php  
			$a = new Area('blog');
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