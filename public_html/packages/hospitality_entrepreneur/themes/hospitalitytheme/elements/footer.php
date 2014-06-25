<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="fullwidthfooter">
	<div class="row">
    	<div class="grid-6 columns">
        	<img src="<?php  echo $this->getThemePath(); ?>/images/footerLogo.gif" alt="Hospitality Entrepreneur"/>
            <p>Hospitality Entrepreneur is a collaboration of leading industry professionals and companies, with proven expertise in building successful hospitality businesses. Our goal is to ensure you get better profits, better knowledge and better peace of mind.</p>
        <p class="footCopy">&copy;<?php  echo date('Y')?> Hospitality Entrepreneur ~ All rights reserved</p>
        </div>
        
        <div class="grid-6 columns FootLinks">
        
        <ul>
        <li><a class="headLink" href="/about/">Why Join</a></li>
        <li><a href="/about/">About Us</a></li>
        <li><a href="/partners/">Partners</a></li>
        <li><a href="/membership/">Membership</a></li>
        <li><a href="/what-people/">What people say</a></li>
        <li><a href="/blog/">Blog</a></li>
        </ul>
        
       <ul>
       	<li><a class="headLink" href="/resources">Start Learning</a></li>
        <li><a href="/resources/entrepreneur-skills">Entrepreneur Skills</a></li>
        <li><a href="/resources/food-drink/">Food &amp; Drink</a></li>
        <li><a href="/resources/marketing/">Marketing</a></li>
        <li><a href="/resources/operations/">Operations</a></li>
        <li><a href="/resources/people/">People</a></li>
        <li><a href="/resources/profit/">Profit</a></li>
        <li><a href="/resources/video/">Videos</a></li>

        </ul>
        
        <ul>
       	<li><a class="headLink" href="/about">Get in touch</a></li>
        <li><a href="/contact-us">Ask a question</a></li>
        <li><a href="=tel;01865 739 174">01865 739 174</a></li>
        <li><a href="mailto@info@hospitalityentrepreneur.com">info@hospitalityentrepreneur.com</a></li>

        </ul>
        
        
                <div class="social">
        		<p><a href="https://www.facebook.com/pages/Hospitality-Entrepreneur/449799375102971?ref=hl" target="_blank" class="fbLink" rel="nofollow" ></a>
              	<a href="https://twitter.com/hospitalitypete" target="_blank" class="twitLink" rel="nofollow" ></a>
              	<!--<a href="http://uk.linkedin.com/pub/peter-austen/34/36b/6a" target="_blank" class="inLink" rel="nofollow" ></a>-->
                <a href="https://www.youtube.com/channel/UCPk91_CerE_J_F8IMBJ9hiw" target="_blank" class="youLink" rel="nofollow" ></a></p>
                </div>
        
        
        
        

        </div>

        </div>
    </div>
</div>

<div id="VideoModal" class="reveal-modal" data-reveal>
<div class="row">


<iframe width="853" height="480" src="//www.youtube.com/embed/XnAoBOpfds4" frameborder="0" allowfullscreen></iframe>


  <a class="close-reveal-modal">&#215;</a>
</div>
</div>



    <!--<script src="js/foundation.min.js"></script>-->
    <script src="<?php  echo $this->getThemePath(); ?>/js/foundation.min.js"></script>
    <!--<script src="js/foundation/foundation.orbit.js"></script>-->
    <script src="<?php  echo $this->getThemePath(); ?>/js/foundation/foundation.reveal.js"></script>
    
  
  

<script src="<?php  echo $this->getThemePath(); ?>/js/foundation/foundation.orbit.js"></script>
<script>
$(document).foundation({
  orbit: {
    animation: 'fade',
    timer_speed: 5000,
    pause_on_hover: true,
    animation_speed: 650,
    navigation_arrows: true,
    bullets: false
  }
});
</script>


    
    
    
   <script>
      $(document).foundation({
  orbit: {
    animation: 'slide',
    timer_speed: 8000,
    pause_on_hover: true,
    animation_speed: 500,
    navigation_arrows: true,
    bullets: true
  	}
	});
    </script>

  
<script type="text/javascript" src="<?=$this->getThemePath()?>/js/jquery.watermark.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.watermark').watermark();
		$('.watermark1').watermark();
	});
</script>

</script><script src="<?=$this->getThemePath()?>/js/watermarkform.js" type="text/javascript"></script>
<script type="text/javascript">// <![CDATA[
jQuery(function($){
		$("#first").Watermark("First");
		$("#mi").Watermark("MI");
		$("#last").Watermark("Last");
		$("#suffix").Watermark("Suffix");
		$("#textarea").Watermark("Your Message","#666");
		
});
// ]]&gt;</script>
  
  
  <script src="<?=$this->getThemePath()?>/js/jquery.fitvids.js"></script>
   <script>
        // Basic FitVids Test
        $(".fitvid").fitVids();
        // Custom selector and No-Double-Wrapping Prevention Test
        $(".fitvid").fitVids({ customSelector: "iframe[src^='http://socialcam.com']"});
      </script>
    
   


<?php   Loader::element('footer_required'); ?>

</body>
</html>



