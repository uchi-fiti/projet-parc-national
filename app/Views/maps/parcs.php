<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Parcs nationaux de Madagascar</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        html, body { height: 100%; margin: 0; }
        #map { height: 100vh; width: 100%; }
    </style>
</head>
<body>

<select id="especeFilter">
    <option value="">-- Toutes les espèces --</option>
</select>


<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const map = L.map('map').setView([-18.8792, 47.5079], 6); // centré sur Madagascar

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(map);

    fetch('<?= base_url('api/all-parcs') ?>')
        .then(response => {
            if (!response.ok) throw new Error('Erreur réseau : ' + response.status);
            return response.json();
        })
        .then(parcs => {
            parcs.forEach(parc => {
                const lat = parseFloat(parc.latitude);
                const lng = parseFloat(parc.longitude);

                if (isNaN(lat) || isNaN(lng)) return;

                L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(`<strong>${parc.nom}</strong>`).openPopup();
            });
        })
        .catch(err => console.error('Erreur lors du chargement des parcs :', err));
});
</script>

</body>
</html>