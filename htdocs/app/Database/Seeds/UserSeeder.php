<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Récupération sécurisée depuis le .env ou valeur par défaut forte pour le dev local
        $adminPass = getenv('ADMIN_PASSWORD') ?: NULL;
        $userPass  = getenv('USER_PASSWORD') ?: NULL;

        $data = [
            [
                'username' => getenv('ADMIN_LOGIN') ?: NULL,
                'nom' => 'Responsable PEC',
                'password' => password_hash($adminPass, PASSWORD_DEFAULT),
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => getenv('USER_LOGIN') ?: NULL,
                'nom' => 'Adhérant du club',
                'password' => password_hash($userPass, PASSWORD_DEFAULT),
                'role' => 'user',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('utilisateurs')->insertBatch($data);
    }
}