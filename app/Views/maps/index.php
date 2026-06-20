<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma première carte avec Leaflet</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        /* 2. On donne une taille obligatoire à la carte */
        #map { 
            height: 100vh; 
            width: 100%;
        }
    </style>
</head>
<body>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // C'est ici que nous allons écrire notre code JavaScript !
        // 1. Initialisation de la carte centrée sur le Royal Club (Majunga)
        const royalClub = [-15.7083331327509, 46.30394554850781];
        // Syntaxe : L.map('id_du_div').setView([latitude, longitude], niveau_de_zoom)
        const map = L.map('map').setView(royalClub, 15);

        // 2. Ajout du fond de carte OpenStreetMap
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // 3. Ajout d'un marqueur sur le Royal Club
        const marker = L.marker(royalClub).addTo(map);        

        // 4. Ajout d'une infobulle liée au marqueur
        marker.bindPopup("<b>Royal Club</b><br>Mahajanga, Madagascar.").openPopup();
    </script>
</body>
</html>