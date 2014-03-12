<?php defined('C5_EXECUTE') or die('Access Denied'); ?>

<?php
	
	$uh = Loader::helper('concrete/urls');
	$bt = Loader::model('block_types');
	$bt = BlockType::getByHandle('moo_music_area_search');
?>
<div class="FormInside">

<h3>Where Can We Doo Moo?</h3>
<p>Search for Moo Music sessions in your area.</p>
<p></p>
<form action="" method="get">
<input name="search" id="search" class="watermark" value="Enter a postcode, area or city"/>
<input type="submit"  value="Search My Area" class="SignUpButton" id="SignUpButton"/>
<img src="/concrete/images/loader_intelligent_search.gif" id="pleaseWait" style="text-align: center;margin: auto auto;display:none;" />
<div id="searchresults">


</div>

<!--p>OR</p>
<a href="<?php echo View::url('/find-your-area'); ?>" class="SignUpButton">Use Our Map</a>
-->

</form>

<script type="text/javascript" >
	
	jQuery('#SignUpButton').click(function() {
		
		jQuery('#pleaseWait').show('slow');
		
		var searchResultPane;
				
		
		jQuery.get(
		
		"<?php echo $uh->getBlockTypeToolsURL($bt); ?>/searchareas",
		{ search: jQuery('#search').val() },
		function(data, status,misc) {
			if(status == "success" && data.trim() != '')
			{
				searchResultPane = jQuery('#searchresults');
				searchResultPane.css('display','block');
				//var pleaseWaitPosition = jQuery('#pleaseWait').position();
				//searchResultPane.css('top',pleaseWaitPosition.top);
				searchResultPane.html(data);
				var searchResultDialog = searchResultPane.dialog({
					title: 'Your Moo Music Available Areas',
					position: 'top',
					width: '800px',
					show: {
						duration: '1000',
						effect: 'fade'
						
					},
					hide: {
						duration: '1000',
						effect: 'fade'
					}
					
					
				});
				
				
				
			}
			
			jQuery('#pleaseWait').hide('slow');
			
			/*jQuery('#searchresults ul li').each(function() {
				
				
				
				
			})*/
			
			/*jQuery('html body').animate({
				
				scrollTop: jQuery('#searchresults').offset().top
				
			}, 2000) */
			
		}
	
	
	);	
	
	return false;
	
	});

//create the center for polygon
google.maps.Polygon.prototype.my_getBounds=function(){
    var bounds = new google.maps.LatLngBounds()
    this.getPath().forEach(function(element,index){bounds.extend(element)})
    return bounds;
}

	
function mooMusicAreaInitialize(mapID,polyGon,latLngCenter) {
  
  google.maps.visualRefresh = true;
  
    // Construct the polygon.
  polyGonToCreate = new google.maps.Polygon({
    paths: polyGon,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 1,
    fillColor: '#FF0000',
    fillOpacity: 0.2
  });
  
  var mapOptions = {
    zoom: 12,
    center: polyGonToCreate.my_getBounds().getCenter(), //new google.maps.LatLng(24.886436490787712, -70.2685546875),
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };

  var polyGonToCreate;

  map = new google.maps.Map(document.getElementById(mapID),
      mapOptions);

  polyGonToCreate.setMap(map);			
	
	
	
	return map;				
			
}

	
	
	
	
	
</script>
</div>