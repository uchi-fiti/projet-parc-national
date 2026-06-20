-- Create the database (execute this while connected to postgres)
CREATE DATABASE parc_national_db;

-- Connect to it
\c parc_national_db

-- Enable PostGIS
CREATE EXTENSION IF NOT EXISTS postgis;

-- Remove the table if it already exists
DROP TABLE IF EXISTS public.pointsparcs CASCADE;

-- Create the table
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

-- Insert the data
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

-- Spatial index
CREATE INDEX pointsparcs_wkb_geometry_idx
ON public.pointsparcs
USING GIST (wkb_geometry);