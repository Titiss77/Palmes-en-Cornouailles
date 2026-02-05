<?php

namespace App\Models\Public;

use CodeIgniter\Model;

class InscriptionModel extends Model
{
    public function getMateriel()
    {
        return $this->db->table('materiel m')
            ->join('images i', 'm.image_id = i.id', 'left')
            ->join('pret p', 'p.id = m.idPret', 'left')
            ->select('m.nom, m.description, m.idPret, i.path as image, p.nom as nomPret')
            ->get()->getResultArray();
    }
    
    public function getMail(string $poste)
    {
        $result = $this->db->table('general')->select('mailClub')->limit(1)->get()->getRow();
        return $result ? $result->mail : null;
    }
}