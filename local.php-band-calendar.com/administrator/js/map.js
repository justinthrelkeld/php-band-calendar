    var map;
    var latlng = new google.maps.LatLng(36.15853, -86.77497);
    var markers = [];
    var geocoder;
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var mapOptions = {
            zoom: 10,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        google.maps.event.addListener(map, 'click', function(evt) {
            addMarker(evt.latLng);
            showLatLng(evt);
        });
    }
    // Add a marker to the map and push to the array.
    function addMarker(location) {
        marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true
        });
        google.maps.event.addListener(marker, 'dragstart', function() {
            console.log('dragging');
        });
        google.maps.event.addListener(marker, 'dragend', function(evt) {
            showLatLng(evt);
        });
        deleteOverlays();
        markers.push(marker);
    }
    function codeAddress() {
        var address = document.getElementById('address').value;
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                addMarker(results[0].geometry.location);
                document.getElementsByName("lat")[0].value = results[0].geometry.location.lat().toFixed(6);
                document.getElementsByName("lng")[0].value = results[0].geometry.location.lng().toFixed(6);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    function showLatLng(evt){
        var lat = evt.latLng.lat().toFixed(6);
        var lng = evt.latLng.lng().toFixed(6);
        document.getElementsByName("lat")[0].value = lat;
        document.getElementsByName("lng")[0].value = lng;
        console.log('Marker dropped: Current Lat: ' + lat + ' Current Lng: ' + lng);
    }
    // Sets the map on all markers in the array.
    function setAllMap(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }
    // Removes the overlays from the map, but keeps them in the array.
    function clearOverlays() {
        setAllMap(null);
    }

    // Shows any overlays currently in the array.
    function showOverlays() {
        setAllMap(map);
    }

    // Deletes all markers in the array by removing references to them.
    function deleteOverlays() {
        clearOverlays();
        markers = [];
    }
    google.maps.event.addDomListener(window, 'load', initialize);