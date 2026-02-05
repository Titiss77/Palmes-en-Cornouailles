<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class CalendriersModel extends Model
{
    protected $table = 'calendriers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    // Champs définis dans la migration
    protected $allowedFields = ['categorie', 'date', 'image_id'];

    /**
     * Récupère les calendriers avec le chemin du fichier (image ou pdf)
     */
    public function getCalendriersWithRelations($id = null)
    {
        $builder = $this
            ->select('calendriers.*, images.path as image_path, images.alt')
            ->join('images', 'calendriers.image_id = images.id', 'left');

        if ($id) {
            return $builder->where('calendriers.id', $id)->first();
        }

        // Tri par catégorie pour regrouper visuellement, puis par date (descendant) pour avoir les récents
        return $builder
            ->orderBy('calendriers.categorie', 'ASC')
            ->orderBy('calendriers.id', 'DESC')
            ->findAll();
    }
}