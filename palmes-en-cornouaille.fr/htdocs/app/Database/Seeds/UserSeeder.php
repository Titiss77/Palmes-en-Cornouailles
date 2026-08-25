<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Récupération sécurisée depuis le .env ou valeur par défaut forte pour le dev local
        $adminPass = getenv('ADMIN_PASSWORD') ?: null;
        $userPass = getenv('USER_PASSWORD') ?: null;

        $data = [
            [
                'username' => getenv('ADMIN_LOGIN') ?: null,
                'nom' => 'Responsable PEC',
                'password' => "Pas de droits d'accès pour ce compte, mot de passe non défini.",
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => getenv('USER_LOGIN') ?: null,
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
