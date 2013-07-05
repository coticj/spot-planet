    var map;
    var items, gmarkers = [];
    // track marker that is currently bouncing
    var currentMarker = null;


    // A function to create the marker and set up the event window

    function createMarker(latlng, title, id, category, icon) {

        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: icon,
            title: title,
            zIndex: Math.round(latlng.lat() * -100000) << 5
        });
        // === Store the category and name info as a marker properties ===
        marker.mycategory = category;
        marker.myname = title;
        gmarkers.push(marker);

        google.maps.event.addListener(marker, 'click', function () {
            map.panTo(latlng);
            (jQuery)('#infoModal').modal({
                backdrop: false
            });
            (jQuery)('#infoModal').load(settings.url + 'wp-content/themes/spotplanet/functions/get_content.php?sid=' + id);
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
            center: new google.maps.LatLng(46.119461, 14.837716),
            mapTypeId: google.maps.MapTypeId.TERRAIN
        }
        map = new google.maps.Map(document.getElementById("b_map"), mapOptions);


        var h = (jQuery)(window).height(),
            offsetTop = 80; // Calculate the top offset

        (jQuery)('#b_map').css('height', (h - offsetTop));


        (jQuery).getJSON(settings.url + "wp-content/themes/spotplanet/functions/markers_json.php", function (data) {
                (jQuery).each(data, function (index, value) {
                    var lat = value.lat;
                    var lng = value.lng;
                    var point = new google.maps.LatLng(lat, lng);
                    var id = value.id;
                    var category = value.category;
                    var title = value.title;
                    var icon = value.icon;

                    // create the marker
                    var marker = createMarker(point, title, id, category, icon);
                });
            });

        (jQuery)('#infoModal').modal({
                show: true,
                backdrop: false
            })


    });