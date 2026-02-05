<?php

namespace App\Models\Public;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table            = 'utilisateurs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Champs autorisés pour les insert/update
    protected $allowedFields    = ['username', 'password', 'nom', 'role'];

    /**
     * Récupère un utilisateur par son identifiant (username)
     */
    public function getUtilisateur($identifiant)
    {
        return $this->where('username', $identifiant)->first();
    }
}