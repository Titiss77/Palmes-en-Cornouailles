<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class GeneralModel extends Model
{
    protected $table = 'general';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    // Champs correspondant strictement à la migration
    protected $allowedFields = [
        'nomClub', 'description', 'philosophie',
        'nombreNageurs', 'nombreHommes', 'projetSportif',
        'lienFacebook', 'lienInstagram', 'lienffessm', 'lienDrive',
        'mailClub', 'adresse', 'image_id', 'image_groupe_id', 'logoffessm_id', 'lienDecatPro'
    ];

    /**
     * Récupère la configuration avec les 3 images jointes
     */
    public function getGeneralWithRelations()
    {
        // On utilise des alias pour récupérer les chemins des 3 images distinctes
        return $this
            ->select('
                    general.*, 
                    img_logo.path as logo_path, 
                    img_groupe.path as groupe_path,
                    img_ffessm.path as ffessm_path
                ')
            ->join('images as img_logo', 'general.image_id = img_logo.id', 'left')
            ->join('images as img_groupe', 'general.image_groupe_id = img_groupe.id', 'left')
            ->join('images as img_ffessm', 'general.logoffessm_id = img_ffessm.id', 'left')
            ->first();
    }
}