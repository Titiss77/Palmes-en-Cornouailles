<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PalmaresSeeder extends Seeder
{
    public function run()
    {
        // 1. Définition des images à créer
        $imagesToSeed = [
            'img1' => [
                'path' => 'palmares/Frances_Mathis_50SF.jpeg',
                'alt' => 'Mathis Frances 50SF'
            ],
            'img2' => [
                'path' => 'palmares/Frances_Mathis_100SF.jpeg',
                'alt' => 'Mathis Frances 100SF'
            ]
        ];

        $imageIds = [];

        // 2. Insertion des images et récupération des IDs
        foreach ($imagesToSeed as $key => $imgData) {
            // On vérifie si l'image existe déjà (via son path qui est unique)
            $existing = $this
                ->db
                ->table('images')
                ->select('id')
                ->where('path', $imgData['path'])
                ->get()
                ->getRow();

            if ($existing) {
                $imageIds[$key] = $existing->id;
            } else {
                // Insertion de l'image
                $this->db->table('images')->insert([
                    'path' => $imgData['path'],
                    'alt' => $imgData['alt'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                // On récupère l'ID fraîchement créé
                $imageIds[$key] = $this->db->insertID();
            }
        }

        // 3. Insertion des palmarès avec les bons IDs (Clés Étrangères)
        $data = [
            [
                'nom_nageur' => 'Frances',
                'prenom_nageur' => 'Mathis',
                'competition' => 'Lorient',
                'epreuve' => '50SF',
                'temps' => '00:21.61',
                'classement' => '2',
                'date_epreuve' => '2026-02-07',
                // Correction : Utilisation de l'ID entier et correction de la typo 'image_id ' (espace en trop)
                'image_id' => $imageIds['img1'],
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
                'image_id' => $imageIds['img2'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('palmares')->insertBatch($data);
    }
}