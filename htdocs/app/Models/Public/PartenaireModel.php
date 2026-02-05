<?php

namespace App\Models\Public;

use CodeIgniter\Model;

class PartenaireModel extends Model
{
    protected $table = 'partenaires';
    protected $primaryKey = 'id';
    protected $allowedFields = ['description', 'image_id', 'ordre'];

    public function getPartenaires()
    {
        return $this->select('partenaires.description, partenaires.ordre')
            ->select('images.path as image_url')
            ->join('images', 'partenaires.image_id = images.id', 'left')
            ->orderBy('partenaires.ordre', 'ASC')
            ->findAll();
    }
}