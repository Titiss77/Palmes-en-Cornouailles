<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Public\Donnees;
use App\Models\Public\InscriptionModel;

class Root extends BaseController
{
    public function getRootStyles()
    {
        $db = \Config\Database::connect();
        $settings = $db->table('root')->get()->getResultArray();

        $rootData = [];
        foreach ($settings as $setting) {
            // Remplace 'primary_color' par 'primary' (ou garde tel quel selon votre préférence)
            $key = str_replace('_', '-', $setting['libelle']);
            $rootData[$key] = $setting['value'];
        }
        return $rootData;
    }
    
}