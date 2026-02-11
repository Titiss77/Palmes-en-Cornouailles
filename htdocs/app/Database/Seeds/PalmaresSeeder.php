<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PalmaresSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nom_nageur' => 'Frances',
                'prenom_nageur' => 'Mathis',
                'competition' => 'Lorient',
                'epreuve' => '50SF',
                'temps' => '00:21.61',
                'classement' => '2',
                'date_epreuve' => '2026-02-07',
                'image_id ' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nom_nageur' => 'Frances',
                'prenom_nageur' => 'Mathis',
                'competition' => 'Lorient',
                'epreuve' => '100SF',
                'temps' => '00:48.84',
                'classement' => '2',
                'date_epreuve' => '2026-02-07',
                'image_id ' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('palmares')->insertBatch($data);
    }
}