function myMap() {
    var mapOptions = {
        center: new google.maps.LatLng(42.39, 12.75),
        zoom: 6.5,
        // mapTypeId: google.maps.MapTypeId.HYBRID
    }
var map = new google.maps.Map(document.getElementById("map"), mapOptions);
}
