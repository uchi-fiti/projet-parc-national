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
}