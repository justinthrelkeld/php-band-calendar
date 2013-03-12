var map;

var geocoder;

geocoder = new google.maps.Geocoder();


// need the following information
// var events = [
// [eventID, date, time, "address of event", "Event Short Description"]
// [eventID, date, time, "address of event", "Event Short Description"]
// [eventID, date, time, "address of event", "Event Short Description"]
// ]

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
  }

  map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);


  function codeAddresses(address) {
    alert(address);
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });



  };
      $('.eventlink').bind('click', function() {
      alert($(this).ID());
    });
}
