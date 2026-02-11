<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PalmaresSeeder extends Seeder
{
    public function run()
    {
        // 3. Insertion des palmarès avec les bons IDs (Clés Étrangères)
        $data = [
            ['nom_nageur' => '', 'prenom_nageur' => 'Mathis', 'epreuve' => '50SF', 'classement' => '2',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Sandra', 'epreuve' => '50SF', 'classement' => '2',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Thomas', 'epreuve' => '50SF', 'classement' => '3',],

            ['nom_nageur' => '', 'prenom_nageur' => 'Garance', 'epreuve' => '200IS', 'classement' => '2',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Maxime', 'epreuve' => '200IS', 'classement' => '2',],

            ['nom_nageur' => '', 'prenom_nageur' => 'Maxime', 'epreuve' => '800SF', 'classement' => '1',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Céline', 'epreuve' => '800SF', 'classement' => '2',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Christophe', 'epreuve' => '800SF', 'classement' => '3',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Thierry', 'epreuve' => '800SF', 'classement' => '1',],
            
            ['nom_nageur' => '', 'prenom_nageur' => 'Mathis', 'epreuve' => '100SF', 'classement' => '2',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Zach', 'epreuve' => '100SF', 'classement' => '3',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Thomas', 'epreuve' => '100SF', 'classement' => '3',],

            ['nom_nageur' => '', 'prenom_nageur' => 'Zach', 'epreuve' => '400BI', 'classement' => '1',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Luca', 'epreuve' => '400BI', 'classement' => '2',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Thierry', 'epreuve' => '400BI', 'classement' => '1',],

            ['nom_nageur' => '', 'prenom_nageur' => 'Sandra', 'epreuve' => '100BI', 'classement' => '3',],
            ['nom_nageur' => '', 'prenom_nageur' => 'Zach', 'epreuve' => '100BI', 'classement' => '3',],
            
        ];

        $newData = [];
        foreach ($data as $entry) {
            $entry += [
                'temps' => '00:00.00',
                'competition' => 'Lorient',
                'date_epreuve' => '2025-02-07',
                'image_id' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $newData[] = $entry;
        }

        $this->db->table('palmares')->insertBatch($newData);
    }
}