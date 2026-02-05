<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class MembresModel extends Model
{
    protected $table = 'membres';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'image_id'];

    /**
     * Récupère les membres avec leur image et la liste de leurs fonctions concaténées
     */
    public function getMembresWithRelations($id = null)
    {
        $builder = $this
            ->select('membres.*, images.path as image_path, images.alt')
            // 1. Pour l'affichage "Rôles": On trie par ID pour avoir "Président, Coach" et non l'inverse
            ->select('GROUP_CONCAT(fonctions.titre ORDER BY fonctions.id ASC SEPARATOR " - ") as roles_string')
            ->select('GROUP_CONCAT(fonctions.id) as roles_ids')
            // 2. Colonne de tri "Magique" : On attribue un score manuel à chaque poste
            // On utilise MIN() pour que si un membre a plusieurs rôles, c'est son "meilleur" rôle qui compte pour le tri
            ->select('MIN(CASE 
            WHEN fonctions.titre = "President" THEN 1 
            WHEN fonctions.titre = "Vice-Président" THEN 2 
            WHEN fonctions.titre = "Comptable" THEN 3 
            WHEN fonctions.titre = "Secrétaire" THEN 4 
            WHEN fonctions.titre = "Sponsoring" THEN 5 
            WHEN fonctions.titre = "Coach" THEN 6 
            WHEN fonctions.titre = "Coach en formation" THEN 7
            ELSE 99 
        END) as ordre_affichage')
            ->join('images', 'membres.image_id = images.id', 'left')
            ->join('membre_fonction', 'membres.id = membre_fonction.membre_id', 'left')
            ->join('fonctions', 'membre_fonction.fonction_id = fonctions.id', 'left')
            ->groupBy('membres.id');

        if ($id) {
            return $builder->where('membres.id', $id)->first();
        }

        // 3. On trie sur notre colonne calculée
        return $builder->orderBy('ordre_affichage', 'ASC')->findAll();
    }

    /**
     * Gère la mise à jour des rôles (Table pivot)
     */
    public function updateRoles($membreId, $fonctionIds)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('membre_fonction');

        // 1. On nettoie les anciens rôles pour ce membre
        $builder->where('membre_id', $membreId)->delete();

        // 2. On insère les nouveaux (si y'en a)
        if (!empty($fonctionIds)) {
            $data = [];
            foreach ($fonctionIds as $fId) {
                $data[] = [
                    'membre_id' => $membreId,
                    'fonction_id' => $fId
                ];
            }
            $builder->insertBatch($data);
        }
    }
}