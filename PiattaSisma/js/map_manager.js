var map;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(42.39, 12.75),
        zoom: 2,
    }); 
    map.setOptions({ maxZoom: null, minZoom: 1.5,});
    // TODO: Get this dynamically from page
    var url = 'http://localhost:8000/terremoti/italy';
    fetch(url)
  . then(res => res.json())
  . then((out) => {
        out['events'].forEach(function(event) {
            var latLng = new google.maps.LatLng(event.latitude, event.longitude);
            var marker = new google.maps.Marker({
                position: latLng,
                map: map
                // TODO: Make them clickableeee (and smaller is possible)
            });
        })
    })
    .catch(err => { throw err });
}
