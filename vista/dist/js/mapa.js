var mymap = L.map('mapid').setView([14.191835, -87.12759], 10);
var marker = L.marker([14.191835, -87.12759]).addTo(mymap);


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(mymap);


L.marker([14.191835, -87.12759]).addTo(mymap)
    .bindPopup('La Trigra.<br> Fundacion AmiTigra.')
    .openPopup();

//pasar automaticamente la coordenada a una caja de texto
var popup = L.popup();

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(mymap);
}

mymap.on('click', onMapClick);