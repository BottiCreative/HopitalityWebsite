<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="fullwidthfooter">
	<div class="row">
    	<div class="grid-6 columns nopadRight">
        	<img src="<?php  echo $this->getThemePath(); ?>/images/footerLogo.gif" alt="Hospitality Entrepreneur"/>
            <p>Hospitality Entrepreneur is a collaboration of leading industry professionals and companies, with proven expertise in building successful hospitality businesses. Our goal is to ensure you get better profits, better knowledge and better peace of mind.</p>
        <p class="footCopy">&copy;<?php  echo date('Y')?> Hospitality Entrepreneur ~ All rights reserved</p>
        </div>
        
        <div class="grid-6 columns FootLinks">
        
        <ul>
        <li><a class="headLink" href="">A little Info</a></li>
        <li><a href="">About Us</a></li>
        <li><a href="">Partners</a></li>
        <li><a href="">Membership</a></li>
        <li><a href="">What people say</a></li>
        <li><a href="">Blog</a></li>
        </ul>
        
       <ul>
       	<li><a class="headLink" href="/resources">Start Learning</a></li>
        <li><a href="/resources/entrepreneur-skills">Entrepreneur Skills</a></li>
        <li><a href="/resources/food-drink/">Food &amp; Drink</a></li>
        <li><a href="/resources/marketing/">Marketing</a></li>
        <li><a href="/resources/operations/">Operations</a></li>
        <li><a href="/resources/people/">People</a></li>
        <li><a href="/resources/profit/">Profit</a></li>
        <li><a href="/resources/qualifications/">Qualifications</a></li>

        </ul>
        
        <ul>
       	<li><a class="headLink" href="/resources">Get in touch</a></li>
        <li><a href="=tel;01865 739 174">01865 739 174</a></li>
        <li><a href="mailto@info@hospitalityentrepreneur.com">info@hospitalityentrepreneur.com</a></li>

        </ul>
        
        
                <div class="social">
        		<p><a href="" target="_blank" class="fbLink" rel="nofollow" ></a>
              	<a href="" target="_blank" class="twitLink" rel="nofollow" ></a>
              	<a href="" target="_blank" class="inLink" rel="nofollow" ></a></p>
                </div>
        
        
        
        

        </div>

        </div>
    </div>
</div>

<div id="VideoModal" class="reveal-modal" data-reveal>
<div class="row">
<iframe width="853" height="480" src="//www.youtube.com/embed/vVUqpIRCLBs" frameborder="0" allowfullscreen></iframe>
  <a class="close-reveal-modal">&#215;</a>
</div>
</div>



    <!--<script src="js/foundation.min.js"></script>-->
    <script src="<?php  echo $this->getThemePath(); ?>/js/foundation.min.js"></script>
    <!--<script src="js/foundation/foundation.orbit.js"></script>-->
    <script src="<?php  echo $this->getThemePath(); ?>/js/foundation/foundation.reveal.js"></script>
    
      <script>
    $(document).foundation(
	
	
	);
  </script>
  
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



