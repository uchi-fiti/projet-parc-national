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

}