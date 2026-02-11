<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class PalmaresModel extends Model
{
    protected $table = 'palmares';
    protected $primaryKey = 'id';
    
    // MAJ des champs autorisés
    protected $allowedFields = [
        'nom_nageur', 
        'prenom_nageur', 
        'competition', 
        'epreuve', 
        'temps', 
        'classement', 
        'date_epreuve', 
        'image_id'
    ];
    
    protected $useTimestamps = true;

    public function getPalmaresWithRelations($id = null)
    {
        $builder = $this->select('palmares.*, images.path as image_path, images.alt as image_alt')
                        ->join('images', 'images.id = palmares.image_id', 'left');

        if ($id) {
            return $builder->where('palmares.id', $id)->first();
        }

        return $builder->orderBy('date_epreuve', 'DESC')->orderBy('classement', 'ASC')->findAll();
    }
}