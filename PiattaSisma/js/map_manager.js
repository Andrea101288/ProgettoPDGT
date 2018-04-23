var map;

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: new google.maps.LatLng(42.39, 12.75),
    zoom: 2,
    minZoom: 3,
  });

  // TODO: Get this dynamically from page
  var url = 'http://localhost:8000/terremoti/italy';

  // Richiede il JSON al server
  fetch(url)
  .then(res => res.json())
  .then((results) => {
    results.features.forEach(function(event) {
      // Get coordinates
      var coords = event.geometry.coordinates;
      var latLng = new google.maps.LatLng(coords[1],coords[0]);

      // Formatto la data
      var date = new Date(event.properties.time);
      
      // Aggiungo il testo del marker
      var infowindow = new google.maps.InfoWindow({
        content: '<div class="marker_textbox">' +
                 '<p><b>Luogo:</b> ' + event.properties.description + '</p>' +
                 '<p><b>Magnitudine:</b> ' + event.properties.magnitude + '</p>' +
                 '<p><b>Profondità:</b> ' + (event.properties.depth/1000) + 'km</p>' +
                 '<p><b>Data:</b> ' + date + '</p>' +
                 '</div>'
      });

      // Creo il marker
      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: "img/earthquake0.png",
      });

      // Aggiungo l'evento che visualizzia il testo
      marker.addListener('click', function() {
        infowindow.open(map, marker);
      });
    });
  })
  .catch(err => { throw err });
}
