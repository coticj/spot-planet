<?php
get_header(); ?>
<script type="text/javascript">
    var map;
	var items, gmarkers = [];
	// track marker that is currently bouncing
var currentMarker = null;


	      // A function to create the marker and set up the event window
function createMarker(latlng,title,id,category,icon) {
    
    var marker = new google.maps.Marker({
        position: latlng,
         map: map,
		 icon:icon,
        title: title,
        zIndex: Math.round(latlng.lat()*-100000)<<5
        });
        // === Store the category and name info as a marker properties ===
        marker.mycategory = category;                                 
        marker.myname = title;
        gmarkers.push(marker);

    google.maps.event.addListener(marker, 'click', function() {
		map.panTo(latlng);
		(jQuery)('#infoModal').modal({
							backdrop: false
						});
		(jQuery)('#infoModal').load('<?php echo esc_url( home_url( ' / ' ) ); ?>wp-content/themes/spotplanet/functions/get_content.php?sid='+id);
         if (currentMarker) currentMarker.setAnimation(null);
        // set this marker to the currentMarker
        currentMarker = marker;
        // add a bounce to this marker
        marker.setAnimation(google.maps.Animation.BOUNCE);
  
        });
}
	
	

	
    (jQuery)(window).resize(function () {
        var h = (jQuery)(window).height(),
            offsetTop = 80; // Calculate the top offset

        (jQuery)('#b_map').css('height', (h - offsetTop));
    }).resize();

	



    (jQuery)(document).ready(function () {
        var mapOptions = {
      zoom: 8,
      center: new google.maps.LatLng(46.119461,14.837716),
      mapTypeId: google.maps.MapTypeId.TERRAIN
    }
    map = new google.maps.Map(document.getElementById("b_map"), mapOptions);


        var h = (jQuery)(window).height(),
            offsetTop = 80; // Calculate the top offset

        (jQuery)('#b_map').css('height', (h - offsetTop));

        		
		(jQuery).getJSON("<?php echo esc_url( home_url( ' / ' ) ); ?>wp-content/themes/spotplanet/functions/markers_json.php", function(data){
    (jQuery).each(data, function (index, value) {
          var lat = value.lat;
          var lng = value.lng;
          var point = new google.maps.LatLng(lat,lng);
          var id = value.id;
          var category = value.category;
		  var title = value.title;
		  var icon = '<?php echo esc_url( home_url( ' / ' ) ); ?>media/' + value.category + '.png';
		  
          // create the marker
          var marker = createMarker(point,title,id,category,icon);
    });
});
		
		(jQuery)('#infoModal').modal({show: true, backdrop: false})


    });
</script>
	<div class="row-fluid">
		<div class="span12">
			<div id="b_map"></div>
		</div>
	</div>
	
    <div class="modal hide fade" id="infoModal" tabindex="-1">
        <div class="modal-header">
            <button class="close" data-dismiss="modal" type="button">×</button>

            <h3 id="infoModalLabel">Welcome to Spot-Planet</h3>
        </div>

        <div class="modal-body">
            <p id="pLabel">blababalbalblabla</p>
        </div>

        <div class="modal-footer">
            <button class="btn" data-dismiss="modal">Close</button>
        </div>
    </div>
	

<?php
get_footer(); ?>