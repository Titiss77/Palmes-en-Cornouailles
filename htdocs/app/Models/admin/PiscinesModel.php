<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class PiscinesModel extends Model
{
    protected $table = 'piscines';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    // Champs modifiables selon la migration
    protected $allowedFields = ['nom', 'adresse', 'type_bassin', 'image_id'];

    /**
     * Récupère les piscines avec l'image associée
     */
    public function getPiscinesWithRelations($id = null)
    {
        $builder = $this
            ->select('piscines.*, images.path as image_path, images.alt')
            ->join('images', 'piscines.image_id = images.id', 'left');

        if ($id) {
            return $builder->where('piscines.id', $id)->first();
        }

        return $builder->orderBy('piscines.nom', 'ASC')->findAll();
    }
}