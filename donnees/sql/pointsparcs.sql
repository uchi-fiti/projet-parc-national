
CREATE DATABASE parc_national_db;


\c parc_national_db;


CREATE EXTENSION IF NOT EXISTS postgis;


DROP TABLE IF EXISTS public.pointsparcs CASCADE;


CREATE TABLE public.pointsparcs (
    ogc_fid SERIAL PRIMARY KEY,

    id INTEGER,

    nom VARCHAR(80),

    latitude NUMERIC(11,6),

    longitude NUMERIC(11,6),

    observation VARCHAR(254),

    score NUMERIC(4,2),

    wkb_geometry geometry(Point,4326)
);

ALTER TABLE pointsparcs
ADD CONSTRAINT pointsparcs_id_unique UNIQUE(id);

CREATE TABLE espece (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(80)
);

DROP TABLE IF EXISTS faune_flore CASCADE;

CREATE TABLE faune_flore (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    nom_scientifique VARCHAR(100),
    id_espece INTEGER REFERENCES espece(id)
);


DROP TABLE IF EXISTS parc_faune_flore CASCADE;

CREATE TABLE parc_faune_flore (
    id SERIAL PRIMARY KEY,
    parc_id INTEGER REFERENCES pointsparcs(id),
    faune_flore_id INTEGER REFERENCES faune_flore(id)
);

INSERT INTO espece (nom) VALUES
('Lemur'),
('Oiseau'),
('Poisson'),
('Reptile'),
('Plante');

INSERT INTO faune_flore (nom, id_espece) VALUES


('Golden Lemur',1),
('Red-tailed Lemur',1),
('Bamboo Lemur',1),


('Vanga',2),
('Coua',2),
('Aigle pecheur',2),


('Poisson clown',3),
('Poisson perroquet',3),


('Camaleon panthere',4),
('Boa de Madagascar',4),


('Orchidee noire',5),
('Nepenthes',5),
('Ravintsara',5);



INSERT INTO public.pointsparcs
(id, nom, latitude, longitude, observation, score, wkb_geometry)
VALUES
(
    1,
    'Parc national de Ranomafana',
    -21.425011,
    47.371117,
    NULL,
    NULL,
    ST_SetSRID(ST_MakePoint(47.371117, -21.425011),4326)
),
(
    2,
    'Parc national de Bemaraha',
    -18.942264,
    44.793337,
    NULL,
    NULL,
    ST_SetSRID(ST_MakePoint(44.793337, -18.942264),4326)
),
(
    3,
    'Reserve forestirere d''Ampijoroa',
    -16.376363,
    47.145413,
    NULL,
    NULL,
    ST_SetSRID(ST_MakePoint(47.145413, -16.376363),4326)
),
(
    4,
    'Parc national d''Isalo',
    -22.434741,
    45.292262,
    NULL,
    NULL,
    ST_SetSRID(ST_MakePoint(45.292262, -22.434741),4326)
),
(
    5,
    'Parc national Masoala',
    -15.734888,
    50.115206,
    NULL,
    NULL,
    ST_SetSRID(ST_MakePoint(50.115206, -15.734888),4326)
);


CREATE INDEX pointsparcs_wkb_geometry_idx
ON public.pointsparcs
USING GIST (wkb_geometry);

UPDATE pointsparcs
SET observation = 'Tsingy de pierre calcaire (labyrinthe karstique UNESCO 1990), 11 lémuriens dont Avahi cleesei CR endémique, 103 oiseaux dont Aigle pêcheur CR, 88 reptiles/amphibiens (17 endémiques du massif), 650 plantes',
    score = 96
WHERE id = 5;

UPDATE pointsparcs
SET observation = 'Forêt dense sèche de l Ouest, 820 espèces de plantes (89% endémiques), 8 lémuriens dont Sifaka de Coquerel, 127 oiseaux, 64 reptiles',
    score = 92
WHERE id = 2;

UPDATE pointsparcs
SET observation = 'Reliefs de grès, canyons et savanes sèches avec piscines naturelles',
    score = 88
WHERE id = 4;

UPDATE pointsparcs
SET observation = 'Plus grand parc de Madagascar (240 000 ha), forêt humide primaire, 11 lémuriens dont Vari roux CR, 136 oiseaux, 1 201 plantes (939 endémiques), récifs coralliens et mangroves',
    score = 98
WHERE id = 3;

UPDATE pointsparcs
SET observation = 'Parc tropical humide à forte biodiversité, forêt dense et espèces endémiques',
    score = 95
WHERE id = 1;

INSERT INTO parc_faune_flore (parc_id, faune_flore_id) VALUES
(1,1), -- Golden Lemur
(1,3), -- Bamboo Lemur
(1,4), -- Vanga
(1,10), -- Orchidee noire
(1,11); -- Ravintsara
INSERT INTO parc_faune_flore (parc_id, faune_flore_id) VALUES
(2,2), -- Red-tailed Lemur
(2,4), -- Vanga
(2,7), -- Camaleon panthere
(2,8), -- Boa de Madagascar
(2,11); -- Ravintsara
INSERT INTO parc_faune_flore (parc_id, faune_flore_id) VALUES
(3,2), -- Red-tailed Lemur
(3,5), -- Coua
(3,7), -- Camaleon panthere
(3,11); -- Ravintsara

INSERT INTO parc_faune_flore (parc_id, faune_flore_id) VALUES
(4,2), -- Red-tailed Lemur
(4,7), -- Camaleon panthere
(4,8), -- Boa de Madagascar
(4,12); -- Nepenthes

INSERT INTO parc_faune_flore (parc_id, faune_flore_id) VALUES
(5,1), -- Golden Lemur
(5,3), -- Bamboo Lemur
(5,4), -- Vanga
(5,6), -- Aigle pecheur
(5,9), -- Poisson-clown
(5,10), -- Orchidee noire
(5,11); -- Ravintsara