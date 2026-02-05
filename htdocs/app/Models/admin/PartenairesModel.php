<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class PartenairesModel extends Model
{
    protected $table            = 'partenaires';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Champs modifiables
    protected $allowedFields    = ['description', 'image_id', 'ordre'];

    /**
     * Récupère les partenaires avec leur logo
     */
    public function getPartenairesWithRelations($id = null)
    {
        $builder = $this->select('partenaires.*, images.path as image_path, images.alt')
                        ->join('images', 'partenaires.image_id = images.id', 'left');

        if ($id) {
            return $builder->where('partenaires.id', $id)->first();
        }

        // Tri par ordre défini, puis par nom (description)
        return $builder->orderBy('partenaires.ordre', 'ASC')
                       ->orderBy('partenaires.description', 'ASC')
                       ->findAll();
    }
}