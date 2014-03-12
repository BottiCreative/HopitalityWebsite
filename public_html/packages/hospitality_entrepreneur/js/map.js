function mooMusicMap(arrayGoogleMapMarkers)
{
	//enable the new google look
	google.maps.visualRefresh = true;
	
	var mapOptions = {
            center: new google.maps.LatLng(54.559322,-4.174804),
            zoom: 6,
            mapTypeId: google.maps.MapTypeId.ROADMAP
    }
	
	var map = new google.maps.Map(document.getElementById("map"),
            mapOptions);
	
	var markersLength = arrayGoogleMapMarkers.length;
	
	var productMarker,
		latLong,
		infowindow,
		googleMarker;
	
	infowindow = new google.maps.InfoWindow({});
	
	
	for(var markerIndex = 0;markerIndex < markersLength;markerIndex += 1)
	{
		productMarker = arrayGoogleMapMarkers[markerIndex];
		latLong = new google.maps.LatLng(productMarker['latitude'],productMarker['longitude']);
		
		
		
		googleMarker = new google.maps.Marker({
		      position: latLong,
		      map: map,
		      title:productMarker['name'],
		      icon: productMarker['markerImage'],
		      animation: google.maps.Animation.DROP,
		      html: '<div class="moomusic-area-infowindow"><div class="ccm-core-commerce-add-to-cart"><form method="post"   id="ccm-core-commerce-add-to-cart-form-' + productMarker['prID'] + '" action="/cart/update/">' + 
		      		'<h2>' + productMarker['name'] + '</h2><p><img src="' + productMarker['infowindowImage'] + 
				'" class="infowindowImage" /><input type="hidden" name="rcID" value="' + productMarker['cID'] + '" />' + 
				'<a href="/cart/update/" onclick="return false;">Purchase <strong>Moo Music</strong> for this area</a>' + 
				'<img src="/updates/concrete5.6.1.2_updater/concrete/images/throbber_white_16.gif" width="16" height="16" class="ccm-core-commerce-add-to-cart-loader" style="display: none;" />' + 
				'<input type="hidden" name="productID" id="productID" value="' + productMarker['prID'] + '" /></p>' + 
				'</form></div>' + 
				'<script type="text/javascript"> ' + 
				'$(function() {' + 
				productMarker['cartLink'] +
				'});' + 
				' </script></div>'
				
		
		  });
		
		
		google.maps.event.addListener(googleMarker,'click',function(){
			
			infowindow.setContent(this.html);
			infowindow.setPosition(latLong);
			infowindow.open(map,this);
		});
		
		//add animations when hover over the marker.
		google.maps.event.addListener(googleMarker,'mouseover',function() {
			
			/*if (this.getAnimation() != null) {
			    this.setAnimation(null);
			  } else {
			  */  
			
			var that = this;
			
			that.setAnimation(google.maps.Animation.BOUNCE);
			
			
			setTimeout(function() {
		
				that.setAnimation(null);
				
					  
				  },2000);
			 
			  
			
		});
		
		
		
	}
	
	
		
	
	
}

function activateMooMusicMap(arrayGoogleMapMarkers)
{
	
	google.maps.event.addDomListener(window,'load',mooMusicMap(arrayGoogleMapMarkers));
	
	
	
}	
	

