document.addEventListener("DOMContentLoaded", function() 
{    
    const mappa = document.querySelector('.mappa');
    
    const studio = mappa.dataset.address;
    const citta = mappa.dataset.city;
    const nome = mappa.dataset.name;
    const id_mappa = mappa.id;

    const indirizzo = `${studio}, ${citta}`;

    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(indirizzo))
        .then(response => response.json())
        .then(data => 
        {
            if (data.length > 0) 
            {
                var lat = data[0].lat;
                var lon = data[0].lon;

                var map = L.map(id_mappa).setView([lat, lon], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                L.marker([lat, lon]).addTo(map)
                    .bindPopup(`<b>${nome}</b><br>${studio}`);
            } 
            else
            {
                document.getElementById(id_mappa).textContent = "Mappa non disponibile";
            }
        })
        .catch(err => console.error(err));
});