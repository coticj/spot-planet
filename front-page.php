<?php
get_header(); ?>
<script type="text/javascript">
    var map;
	var items, gmarkers = [];
	// track marker that is currently bouncing
var currentMarker = null;
	
    function loadResults(data) {
        
        if (data.posts.length > 0) {
            items = data.posts;

            for (var i = 0; i < items.length; i++) {
                var item = items[i];

			var lat = item.custom_fields.lat;
          var lng = item.custom_fields.lng;
          var point = new google.maps.LatLng(lat,lng);
          var html = item.excerpt;
          var category = item.categories[0].title;
		  var title = item.title_plain;
		  var icon = '<?php echo esc_url( home_url( ' / ' ) ); ?>media/' + item.categories[0].id + '.png';
		  
          // create the marker
          var marker = createMarker(point,title,html,category,icon);
            }
        }
        

    }

	      // A function to create the marker and set up the event window
function createMarker(latlng,title,html,category,icon) {
    var contentString = html;
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
		(jQuery)('#infoModalLabel').html(title);
        (jQuery)('#pLabel').html(html);
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

        var xhr = (jQuery).getJSON('<?php echo esc_url( home_url( ' / ' ) ); ?>?json=1');

        xhr.done(loadResults);
		
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