var map;

      var points = [
          [35.849, -86.362, 'Marker X', 'stop1'],
          [35.846, -86.362, 'Marker Y', 'stop2'],
          [35.852, -86.362, 'Marker Z', 'stop3'],
          [35.852, -86.360, 'Marker A', 'stop4'],
          [35.852, -86.355, 'Marker B', 'stop5'],
          [35.852, -86.350, 'Marker C', 'stop6'],
          [35.852, -86.347, 'Marker D', 'stop7']
        ];
        //need to add arraygen logic, possibly with JSON?

      function initialize() {
        console.log('initializing Google map');

        var myLatlng = new google.maps.LatLng(35.849057,-86.362374);

        var mapOptions = {
          zoom: 15,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          mapTypeControl: false,
          streetViewControl: false,
        }

        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        google.maps.event.addListener(map, 'click', function(e) {
          openMapDrawer();
          map.panTo(myLatlng);
          map.setZoom(15);
        })

        // Add markers to the map from array points.
        for (var i = 0; i < points.length; i++) {
          var location = new google.maps.LatLng(points[i][0],points[i][1]);
          var title = points[i][2];
          var marker = new google.maps.Marker({
            position: location,
            title: title,
            map: map
          });
          attachPoints(marker, i);
        }


      $('#mapDrawer').waypoint(function() {
        console.log('Top collided');
      }, {offset: 1});

      $('#mapDrawer').waypoint(function() {
        console.log('bottom collided');
      }, { 
        offset: function() {
          return -$(this).height();
        }});

      originalMapHeight = $('#mapDrawer').height(); 

    };

      function attachPoints(marker, number) {
        var currentTourStop = points[number][3];
        google.maps.event.addListener(marker, 'click', function() {
          //goto point logic
          console.log('going to ' + currentTourStop);
          //window.location.assign('#' + currentTourStop);
          $.smoothScroll({
            scrollTarget: '#' + currentTourStop
          });
        });
      };

      function toggleMapDrawer() {
        $('#mapDrawer').slideToggle(400);
      }; 

      function openMapDrawer() {
        $.smoothScroll({
            scrollTarget: '#mapDrawer'
          });
        $('#mapDrawer').toggleClass('open', 400);

      };

      function foldMapDrawer() {

        $('#mapDrawer.open').height(originalMapHeight);
      }

      function unfoldMapDrawer() {
        $('#mapDrawer').effect('size', {
          to: {height: $(window).height() },
          scale: 'box'
        }, 1000);
      }
