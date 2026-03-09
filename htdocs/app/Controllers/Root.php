<?php

declare(strict_types=1);

namespace App\Controllers;

use Config\Database;

class Root extends BaseController
{
    public function getRootStyles()
    {
        $db = Database::connect();
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
