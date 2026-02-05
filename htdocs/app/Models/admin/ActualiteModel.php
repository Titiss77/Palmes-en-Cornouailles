<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class ActualiteModel extends Model
{
    protected $table            = 'actualites';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Champs modifiables
    protected $allowedFields    = [
        'titre', 'slug', 'type', 'statut', 
        'description', 'image_id', 'date_evenement', 
        'id_auteur'
    ];

    // Dates automatiques
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Récupère les actualités avec les infos jointes (Image, Auteur)
     */
    public function getActualitesWithRelations($id = null)
    {
        $builder = $this->select('actualites.*, images.path as image_path, images.alt, membres.nom as auteur_nom')
                        ->join('images', 'actualites.image_id = images.id', 'left')
                        ->join('membres', 'actualites.id_auteur = membres.id', 'left');

        if ($id) {
            return $builder->where('actualites.id', $id)->first();
        }

        return $builder->orderBy('actualites.created_at', 'DESC')->findAll();
    }
}