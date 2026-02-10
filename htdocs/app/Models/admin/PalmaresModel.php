<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class PalmaresModel extends Model
{
    protected $table = 'palmares';
    protected $primaryKey = 'id';
    protected $allowedFields = ['membre_id', 'competition', 'epreuve', 'temps', 'classement', 'date_epreuve', 'image_id'];
    protected $useTimestamps = true;

    // Récupère les palmarès avec le nom du nageur et le chemin de l'image
    public function getPalmaresWithRelations($id = null)
    {
        $builder = $this
            ->select('palmares.*, membres.nom as nom_nageur, membres.prenom as prenom_nageur, images.path as image_path, images.alt as image_alt')
            ->join('membres', 'membres.id = palmares.membre_id')
            ->join('images', 'images.id = palmares.image_id', 'left');

        if ($id) {
            return $builder->where('palmares.id', $id)->first();
        }

        // On trie par date la plus récente
        return $builder->orderBy('date_epreuve', 'DESC')->findAll();
    }
}