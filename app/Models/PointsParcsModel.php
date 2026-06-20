<?php

namespace App\Models;

use CodeIgniter\Model;

class PointsParcsModel extends Model
{
    protected $table         = 'pointsparcs';
    protected $primaryKey    = 'ogc_fid';
    protected $allowedFields = ['id', 'nom', 'latitude', 'longitude', 'observation', 'score'];
    protected $returnType    = 'array';

    public function getAllParcs(): array
    {
        return $this->select('ogc_fid, id, nom, latitude, longitude, observation, score')
                     ->findAll();
    }
}