<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class BoutiquesModel extends Model
{
    protected $table = 'boutique';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // Champs modifiables
    protected $allowedFields = [
        'id', 'nom', 'url', 'description', 'tranchePrix'
    ];

    public function getBoutiquesWithRelations($id = null)
    {
        $builder = $this
            ->select('id, nom, url, description, tranchePrix');

        if ($id) {
            return $builder->where('id', $id)->first();
        }

        return $builder->orderBy('id', 'DESC')->findAll();
    }
}