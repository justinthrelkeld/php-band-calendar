var map;
var geocoder;
var marker;

geocoder = new google.maps.Geocoder();

var eventList = [ // this is a parsed JSON object
{
  "id":"0",
  "title":"band is here",
  "time":"1363125225",
  "address":"Grace Chapel Tullahoma 315 NW Atlantic St, TN, 37388, USA",
  "description":"description of band performance "
},
{
  "id":"1",
  "title":"asdkj",
  "time":"123456789",
  "address":"the corner of medical center and thompson lane",
  "description":"algoiwg ckasadkaba ad"
}];

function initialize() {
  $('body').append('<div id="escape" class="hidden"></div>');
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

  function showEventDetails(address) {
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
        console.log('Geocode was not successful for the following reason: ' + status);
      };
    });

  };
  $('.eventlink').bind('click', function() {
    thisId = this.id;
    thisIndex = thisId.split('-')[1];
    console.log('you want to know about ' + thisId);
    console.log('it has an index of ' + thisIndex);
    showEventDetails(eventList[thisIndex].address);
    $('#map_canvas').addClass('show');
    $('#event-' + thisIndex).addClass('enlarged');
    $('#escape').removeClass('hidden');
  });
  $('#escape').bind('click', function() {
    $('#map_canvas').removeClass('show');
    $('#event-' + thisIndex).removeClass('enlarged');
    $('#escape').addClass('hidden');
  });
};
