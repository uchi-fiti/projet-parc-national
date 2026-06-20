# Parc National a Madagascar

## Technologie
- CI 4
- Postgres
- Javascript
- leaflet

## A faire
- Collecte de donnees:
    - localisation des 5parcs de nos choix
        - nom du parc
        - latitude: georeferencement sur QGIS 
        - longitude: georeferencement sur QGIS
        - observation
        - score
        - nature

    - chercher les donnees de faunes et de flores  sur internet



## Fonctionnalites
- Recherche de parc :
    - filtre par animal
        - espece
        - reference
    - filtre par flore
    - Itineraire vers le parc selectionné


## Base de Donnee
faune_flore
```
    id
    reference (AN001)
    nom
    nom_scientifique
    id_espece
```

espece
```
    id
    nom
```

type
```
    id
    type
```

parc
```
    id
    nom_parc
    longitude
    latitude
    score
    observation
```

parc_faune_flore
```
    id
    id_parc
    id_faune_flore
```

