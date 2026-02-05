<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class DisciplinesModel extends Model
{
    protected $table = 'disciplines';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    // Champs modifiables
    protected $allowedFields = ['nom', 'description', 'image_id'];

    /**
     * Récupère les disciplines avec leur image d'illustration
     */
    public function getDisciplinesWithRelations($id = null)
    {
        $builder = $this
            ->select('disciplines.*, images.path as image_path, images.alt')
            ->join('images', 'disciplines.image_id = images.id', 'left');

        if ($id) {
            return $builder->where('disciplines.id', $id)->first();
        }

        // Tri alphabétique
        return $builder->orderBy('disciplines.nom', 'ASC')->findAll();
    }
}