var map;
var markers = [];

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: new google.maps.LatLng(42.39, 12.75),
    zoom: 2,
    minZoom: 3,
  });
}

function getMarkers() {
  // Get radios
  var radio = document.getElementsByName("region");

  // Get selected radio button
  for(var i = 0; i < radio.length; i++)
    if(radio[i].checked)
      break

  var region = radio[i].value;

  // Get date range
  var to_day = document.getElementById("to_day").value;
  var from_day = document.getElementById("from_day").value;

  // Fill url
  var url = 'http://localhost:8000/earthquakes/' + region;

  if(from_day != "")
    url += "?starttime=" + from_day + "&endtime=" + to_day;
  else if(to_day != "")
    url += "?endtime=" + to_day;

  // Remove old markers
  deleteMarkers();

  // JSON request
  fetch(url)
  .then(res => res.json())
  .then((results) => {
    results.features.forEach(function(event) {
      // Get coordinates
      var coords = event.geometry.coordinates;
      var latLng = new google.maps.LatLng(coords[1],coords[0]);

      // Format date
      var date = new Date(event.properties.time);
      
      // Add marker text
      var infowindow = new google.maps.InfoWindow({
        content: '<div class="marker_textbox">' +
                 '<p><b>Luogo:</b> ' + event.properties.description + '</p>' +
                 '<p><b>Magnitudine:</b> ' + event.properties.magnitude + '</p>' +
                 '<p><b>Profondità:</b> ' + (event.properties.depth/1000) + 'km</p>' +
                 '<p><b>Data:</b> ' + date + '</p>' +
                 '</div>'
      });

      // Create new marker instance
      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: "img/earthquake0.png",
      });

      // Add marker to array
      markers.push(marker);

      // Add onclick event to marker
      marker.addListener('click', function() {
        infowindow.open(map, marker);
      });
    });
  })
  .catch(err => { throw err });
}

function deleteMarkers() {
  //Loop through all the markers and remove them
  for (var i = 0; i < markers.length; i++)
    markers[i].setMap(null);

  markers = [];
};
