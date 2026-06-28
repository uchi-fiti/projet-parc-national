<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Parcs nationaux de Madagascar</title>

    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>
        html, body {
            margin: 0;
            height: 100%;
        }

        .toolbar {
            padding: 10px;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }

        #especeFilter {
            padding: 5px;
            min-width: 250px;
        }

        #map {
            height: calc(100vh - 55px);
            width: 100%;
        }
    </style>
</head>
<body>

<div class="toolbar">
    <label for="especeFilter">
        Faune / Flore :
    </label>

    <select id="especeFilter">
        <option value="">
            Toutes les espèces
        </option>
    </select>
</div>

<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

document.addEventListener('DOMContentLoaded', () => {

    const map = L.map('map').setView(
        [-18.8792, 47.5079],
        6
    );

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18
        }
    ).addTo(map);

    const markersLayer = L.layerGroup().addTo(map);
    let routesLayer = L.layerGroup().addTo(map);

    function afficherParcs(parcs)
    {
        markersLayer.clearLayers();

        parcs.forEach(parc => {

            const lat = parseFloat(parc.latitude);
            const lng = parseFloat(parc.longitude);

            if (isNaN(lat) || isNaN(lng))
                return;

            L.marker([lat, lng])
                .addTo(markersLayer)
               .bindPopup(`
    <div>
        <h3>${parc.nom}</h3>

        <p>
            <strong>Score :</strong>
            ${parc.score ?? 'N/A'}
        </p>

        <p>
            <strong>Observation :</strong>
            ${parc.observation ?? 'Aucune'}
        </p>

        <p>
            <strong>Latitude :</strong>
            ${parc.latitude}
        </p>

        <p>
            <strong>Longitude :</strong>
            ${parc.longitude}
        </p>
    </div>
`);
        });
    }
    

    function chargerTousLesParcs()
    {
        fetch('<?= base_url('api/all-parcs') ?>')
            .then(response => {

                if (!response.ok)
                    throw new Error(response.status);

                return response.json();
            })
            .then(parcs => {
                afficherParcs(parcs);
            })
            .catch(err => {
                console.error(
                    'Erreur chargement parcs :',
                    err
                );
            });
    }

    function chargerEspeces()
    {
        fetch('<?= base_url('api/all-especes') ?>')
            .then(response => {

                if (!response.ok)
                    throw new Error(response.status);

                return response.json();
            })
            .then(especes => {

                const select =
                    document.getElementById(
                        'especeFilter'
                    );

                especes.forEach(espece => {

                    const option =
                        document.createElement(
                            'option'
                        );

                    option.value = espece.id;
                    option.textContent =
                        espece.nom;

                    select.appendChild(option);
                });
            })
            .catch(err => {
                console.error(
                    'Erreur chargement espèces :',
                    err
                );
            });
    }

    function chargerToutesLesRoutes() {

    fetch("<?= base_url('api/routes') ?>")
        .then(response => response.json())
        .then(routes => afficherRoutes(routes))
        .catch(err => console.error(err));

}

    function afficherRoutes(routes) {

    routesLayer.clearLayers();

    routes.forEach(route => {

        const geojson = JSON.parse(route.geometry);

        L.geoJSON(geojson, {
            style: {
                color: "#e74c3c",
                weight: 4,
                opacity: 0.9
            },

            onEachFeature: function(feature, layer) {

                layer.bindPopup(`
                    <h5>${route.nom}</h5>
                    <b>Départ :</b> ${route.depart}<br>
                    <b>Arrivée :</b> ${route.arrivee}<br>
                    <b>Distance :</b> ${route.distance} km
                `);

            }

        }).addTo(routesLayer);

    });

}

    document
        .getElementById('especeFilter')
        .addEventListener(
            'change',
            function () {

                const especeId =
                    this.value;

                if (especeId === '') {
                    chargerTousLesParcs();
                    chargerToutesLesRoutes();
                    return;
                }
                
                fetch(
                    `<?= base_url('api/parcs/espece') ?>/${especeId}`
                )
                    .then(response => {

                        if (!response.ok)
                            throw new Error(
                                response.status
                            );

                        return response.json();
                    })
                    .then(parcs => {
                        afficherParcs(parcs);
                    })
                    .catch(err => {
                        console.error(
                            'Erreur filtre :',
                            err
                        );
                    });

                fetch(
                    `<?= base_url('api/routes/espece/') ?>/${especeId}`
                )
                    .then(response => {

                        if (!response.ok)
                            throw new Error(
                                response.status
                            );

                        return response.json();
                    })
                    .then(routes => {
                        afficherRoutes(routes);
                    })
                    .catch(err => {
                        console.error(
                            'Erreur filtre :',
                            err
                        );
                    });
            }
        );

    chargerEspeces();
    chargerTousLesParcs();
    chargerToutesLesRoutes();
});

</script>

</body>
</html>