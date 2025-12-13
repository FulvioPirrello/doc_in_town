document.addEventListener("DOMContentLoaded", function() {
    
    const mapElement = document.querySelector('.mappa');
    
    if (!mapElement) return;

    const studio = mapElement.dataset.address;
    const city = mapElement.dataset.city;
    const name = mapElement.dataset.name;
    const mapId = mapElement.id;

    const fullAddress = `${studio}, ${city}`;

    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(fullAddress))
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                var lat = data[0].lat;
                var lon = data[0].lon;

                var map = L.map(mapId).setView([lat, lon], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                L.marker([lat, lon]).addTo(map)
                    .bindPopup(`<b>${name}</b><br>${studio}`);
            } else {
                document.getElementById(mapId).innerHTML = "Mappa non disponibile";
            }
        })
        .catch(err => console.error(err));
});