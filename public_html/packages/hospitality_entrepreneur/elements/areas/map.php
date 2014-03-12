<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<?php
	$json = Loader::helper('json');
?>


<!--NOTE: needs a reference to map.js in moo_music package.-->
<div id="map"></div>

<script type="text/javascript">
	
	window.onload = function() {
		
		
		var script = document.createElement("script");
	  script.type = "text/javascript";
	  script.src = "https://maps.google.com/maps/api/js?sensor=true&key=AIzaSyDw7irck_KNNx1gYHriiKD6PITWpTnZdp0&callback=loadScript";
	  document.body.appendChild(script);
	 
	
	};
	
	function loadScript()
	{
		mooMusicMap(<?php echo $json->encode($products); ?>);
	}
	//loadScript();	
	//enable the new google look
	

</script>
