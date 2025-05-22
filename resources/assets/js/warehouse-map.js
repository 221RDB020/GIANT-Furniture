const mapContainer = document.querySelector('#map');
let map;
let userMarker;
let warehouseMarker;
const warehouseLocation = {
    lat: 56.958,
    lng: 24.037
};

if (mapContainer && 'geolocation' in navigator) {
    map = L.map('map').setView([warehouseLocation.lat, warehouseLocation.lng], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    warehouseMarker = new L.Marker([warehouseLocation.lat, warehouseLocation.lng])
        .addTo(map)
        .bindPopup('GIANT Warehouse')
        .openPopup();

    navigator.geolocation.getCurrentPosition((position) => {
        const currentLocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        map.setView([currentLocation.lat, currentLocation.lng], 13);

        userMarker = L.marker([currentLocation.lat, currentLocation.lng])
            .addTo(map)
            .bindPopup('Your current location')
            .openPopup();
    }, (err) => {
        console.log(err);
    }, {
        timeout: 10000,
    });
}
