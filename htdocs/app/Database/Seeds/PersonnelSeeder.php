<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PersonnelSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // 1. Insertion des membres (Migration de 'photo' vers 'image_id')
        $membres = [
            ['nom' => 'Yves PRIGENT', 'photo' => 'personnel/Yves_PRIGENT.jpg'],
            ['nom' => 'Marie LANDOLSI', 'photo' => 'personnel/Marie_LANDOLSI.jpg'],
            ['nom' => 'Tifenn GAUDIN', 'photo' => 'personnel/Tifenn_GAUDIN.jpg'],
            ['nom' => 'Anne Catherine CAPITAINE', 'photo' => 'personnel/Anne_Catherine_CAPITAINE.jpg'],
            ['nom' => 'Rodolphe LESPAGNOL', 'photo' => 'personnel/Rodolphe_LESPAGNOL.jpg'],
            ['nom' => 'Thierry HENRI', 'photo' => 'personnel/Thierry_HENRI.jpg'],
            ['nom' => 'Martin LESPAGNOL', 'photo' => 'personnel/Martin_LESPAGNOL.jpg'],
            ['nom' => 'Zacharie LEDUC', 'photo' => 'personnel/Zacharie_LEDUC.jpg'],
            ['nom' => 'Célian PRIGENT', 'photo' => 'personnel/Celian_PRIGENT.jpg'],
            ['nom' => 'Luca SOLLAZZO LE MOIGNE', 'photo' => 'personnel/Luca_SOLLAZZO_LE_MOIGNE.jpg'],
            ['nom' => 'Killian TORCH', 'photo' => 'personnel/Killian_TORCH.jpg'],
            ['nom' => 'Florie BOUTOUILLER', 'photo' => 'personnel/vide.jpg'],
            ['nom' => 'Eloise KERJEAN', 'photo' => 'personnel/Eloise_KERJEAN.jpg'],
            ['nom' => 'Maëlys LE BIGOT', 'photo' => 'personnel/vide.jpg'],
        ];

        $membresData = [];
        foreach ($membres as $m) {
            $photoPath = $m['photo'];
            unset($m['photo']);
            $m['image_id'] = $this->getImageId($photoPath);
            $membresData[] = $m;
        }
        
        $db->table('membres')->insertBatch($membresData);

        // 2. Insertion des fonctions (Inchangé)
        $fonctions = [
            ['titre' => 'President'], //1
            ['titre' => 'Vice-Président'], //2
            ['titre' => 'Comptable'], //3
            ['titre' => 'Secrétaire'],//4
            ['titre' => 'Sponsoring'],//5
            ['titre' => 'Informatique'],//6
            ['titre' => 'Coach'],//7
            ['titre' => 'Coach en formation'],//8
        ];
        $db->table('fonctions')->insertBatch($fonctions);
        
        // 3. Liaisons (Inchangé)
        $liaisons = [
            ['membre_id' => 1, 'fonction_id' => 1],
            ['membre_id' => 2, 'fonction_id' => 2],
            ['membre_id' => 3, 'fonction_id' => 3],
            ['membre_id' => 4, 'fonction_id' => 4],
            ['membre_id' => 5, 'fonction_id' => 5],
            ['membre_id' => 6, 'fonction_id' => 7],
            ['membre_id' => 7, 'fonction_id' => 7],
            ['membre_id' => 2, 'fonction_id' => 7],
            ['membre_id' => 8, 'fonction_id' => 8],
            ['membre_id' => 9, 'fonction_id' => 8],
            ['membre_id' => 10, 'fonction_id' => 8],
            ['membre_id' => 11, 'fonction_id' => 8],
            ['membre_id' => 12, 'fonction_id' => 8],
            ['membre_id' => 13, 'fonction_id' => 8],
            ['membre_id' => 14, 'fonction_id' => 8],
        ];
        $db->table('membre_fonction')->insertBatch($liaisons);
    }

    private function getImageId($path)
    {
        if (empty($path)) return null;
        $existing = $this->db->table('images')->where('path', $path)->get()->getRow();
        if ($existing) return $existing->id;
        $this->db->table('images')->insert(['path' => $path, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        return $this->db->insertID();
    }
}