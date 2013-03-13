var map;
var geocoder;
var marker;

geocoder = new google.maps.Geocoder();

var eventList = [
[0, 'January 30th', '7 in the afternoon', '3920 Puckett Creek Xing, murfreesboro TN 37128', "event 1"],
[1, 'January 30th', '7 in the afternoon', '23 march mill road, fayetteville TN', "event 1"],
[2, 'January 30th', '7 in the afternoon', 'Corner of medical center and thompson lane, murfreesboro tn', "event 1"],
[3, 'January 30th', '7 in the afternoon', 'JoZoara Coffee Shop, Murfreesboro TN', "event 1"],
];

function initialize() {
  console.log('initializing Google map');

  var myLatlng = new google.maps.LatLng(35.849057,-86.362374);

  var mapOptions = {
    zoom: 15,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    mapTypeControl: false,
    streetViewControl: false,
  };

  map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

  function codeAddress(address) {
    console.log('build a marker at ' + address);
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
        });
        var infowindow = new google.maps.InfoWindow({
          content: 
            '<a target="_blank" href="https://www.google.com/maps?daddr=' + 
            address + 
            '">get directions to ' + 
            address + 
            '.</a>'
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker);
        });

      } else {
        concole.log('Geocode was not successful for the following reason: ' + status);
      };
    });

  };
  $('.eventlink').bind('click', function() {
    thisId = this.id;
    thisIndex = thisId.split('-')[1];
    console.log('you want to know about ' + thisId);
    console.log('it has an index of ' + thisIndex);
    codeAddress(eventList[thisIndex][3]);

  });
};
