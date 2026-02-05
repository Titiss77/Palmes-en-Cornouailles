<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class MaterielModel extends Model
{
    protected $table = 'materiel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    // Champs définis dans la migration
    protected $allowedFields = ['nom', 'description', 'idPret', 'image_id'];

    /**
     * Récupère le matériel avec l'image et le type de prêt associé
     */
    public function getMaterielWithRelations($id = null)
    {
        // On récupère le nom du matériel, sa description, l'image, et le "nom" dans la table pret (ex: Disponible, En prêt...)
        $builder = $this
            ->select('materiel.*, images.path as image_path, images.alt, pret.nom as pret_nom')
            ->join('images', 'materiel.image_id = images.id', 'left')
            ->join('pret', 'materiel.idPret = pret.id', 'left');

        if ($id) {
            return $builder->where('materiel.id', $id)->first();
        }

        return $builder->orderBy('materiel.nom', 'ASC')->findAll();
    }

    /**
     * Récupère la liste des status/types de prêt pour le menu déroulant
     */
    public function getTypesPret()
    {
        return $this->db->table('pret')->orderBy('nom', 'ASC')->get()->getResultArray();
    }
}