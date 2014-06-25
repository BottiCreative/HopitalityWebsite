<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="clearfix"></div>

<div class="fullwidthfooter">
	<div class="rowWide">

        <div class="grid-4 columns">

            <a href="">01865 739 174</a><br>
            <a href="">info@hospitalityentrepreneur.com</a>
        </div>
        <div class="grid-8 columns end">
                
                <div class="social">
        		<p><a href="https://www.facebook.com/pages/Hospitality-Entrepreneur/449799375102971?ref=hl" target="_blank" class="fbLink" rel="nofollow" ></a>
              	<a href="https://twitter.com/hospitalitypete" target="_blank" class="twitLink" rel="nofollow" ></a>
              	<a href="http://uk.linkedin.com/pub/peter-austen/34/36b/6a" target="_blank" class="inLink" rel="nofollow" ></a>
                <a href="https://www.youtube.com/channel/UCPk91_CerE_J_F8IMBJ9hiw" target="_blank" class="youLink" rel="nofollow" ></a></p>
                </div>
        </div>
    </div>
</div>

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



