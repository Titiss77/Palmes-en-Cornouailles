<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class GroupesModel extends Model
{
    protected $table = 'groupes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    // Champs modifiables
    protected $allowedFields = [
        'nom', 'description', 'tranche_age',
        'horaire_resume', 'prix', 'image_id',
        'ordre', 'codeCouleur'
    ];

    /**
     * Récupère les groupes avec le chemin de l'image (jointure)
     */
    public function getGroupesWithRelations($id = null)
    {
        $builder = $this
            ->select('groupes.*, images.path as image_path, images.alt')
            ->join('images', 'groupes.image_id = images.id', 'left');

        if ($id) {
            return $builder->where('groupes.id', $id)->first();
        }

        // Tri par ordre défini par l'admin, puis par nom
        return $builder->orderBy('groupes.ordre', 'ASC')->orderBy('groupes.nom', 'ASC')->findAll();
    }
}