<?php

namespace App\Models\Public;

use CodeIgniter\Model;

class GroupeModel extends Model
{
    protected $table = 'groupes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'description', 'tranche_age', 'horaire_resume', 'prix', 'image_id', 'ordre', 'codeCouleur'];

    public function getGroupes()
    {
        return $this
            ->select('groupes.nom, groupes.description, groupes.tranche_age, groupes.horaire_resume, groupes.prix, groupes.codeCouleur')
            ->select('images.path as image')
            ->join('images', 'groupes.image_id = images.id', 'left')
            ->orderBy('groupes.ordre', 'ASC')
            ->findAll();
    }

    /**
     * Récupère un groupe spécifique par son ID
     */
    public function getGroupeById(int $id)
    {
        return $this
            ->select('groupes.*, images.path as image')
            ->join('images', 'groupes.image_id = images.id', 'left')
            ->where('groupes.id', $id)
            ->first();
    }
}