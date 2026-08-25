<?php

declare(strict_types=1);

namespace App\Models\admin;

use CodeIgniter\Model;

class FonctionsModel extends Model
{
    protected $table = 'fonctions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titre'];
    protected $returnType = 'array';
}
