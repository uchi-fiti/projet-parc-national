<?php

namespace App\Controllers;

use App\Models\PointsParcsModel;

class Api extends BaseController
{
    public function allParcs()
    {
        $model = new PointsParcsModel();
        $parcs = $model->getAllParcs();

        return $this->response->setJSON($parcs);
    }
    public function allEspeces()
{
    $db = \Config\Database::connect();

    $especes = $db->table('espece')
                  ->select('id, nom')
                  ->orderBy('nom')
                  ->get()
                  ->getResultArray();

    return $this->response->setJSON($especes);
}

public function parcsByEspece($especeId)
{
    $db = \Config\Database::connect();

    $parcs = $db->query("
        SELECT DISTINCT p.*
        FROM pointsparcs p
        JOIN parc_faune_flore pff
            ON p.id = pff.parc_id
        JOIN faune_flore ff
            ON ff.id = pff.faune_flore_id
        WHERE ff.id_espece = ?
    ", [$especeId])->getResultArray();

    return $this->response->setJSON($parcs);
}

public function toutesLesRoutes()
{
    $db = \Config\Database::connect();

    $routes = $db->query("
        SELECT
            id,
            nom,
            depart,
            arrivee,
            distance,
            idparc,
            ST_AsGeoJSON(wkb_geometry) AS geometry
        FROM routesparcs
    ")->getResultArray();

    return $this->response->setJSON($routes);
}

public function routesLeadingToParcWithEspece($especeId)
{
    $db = \Config\Database::connect();

    $routes = $db->query("
        SELECT DISTINCT
            r.id,
            r.nom,
            r.depart,
            r.arrivee,
            r.distance,
            r.idparc,
            ST_AsGeoJSON(r.wkb_geometry) AS geometry
        FROM routesparcs r
        JOIN pointsparcs p
            ON p.id = r.idparc
        JOIN parc_faune_flore pff
            ON p.id = pff.parc_id
        JOIN faune_flore ff
            ON ff.id = pff.faune_flore_id
        WHERE ff.id_espece = ?
    ", [$especeId])->getResultArray();

    return $this->response->setJSON($routes);
}
}