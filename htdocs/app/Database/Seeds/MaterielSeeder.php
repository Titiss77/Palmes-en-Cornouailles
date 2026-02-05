<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MaterielSeeder extends Seeder
{
    public function run()
    {
        // Table PRET (pas d'image)
        $pret = [
            ['nom' => "À acheter via le club"],
            ['nom' => 'À acheter en magasin'],
        ];
        $this->db->table('pret')->insertBatch($pret);
        
        // Table MATERIEL (avec image)
        $materiel = [
            [
                'nom' => 'Palmes (Bi-palmes)',
                'description' => 'Palmes de natation spécifiques NAP.',
                'idPret' => '1',
                'image' => 'materiel/bi-palmes.jpg',
            ],
            [
                'nom' => 'Masque',
                'description' => 'Masque de natation.',
                'idPret' => '1',
                'image' => 'materiel/masque.jpg',
            ],
            [
                'nom' => 'Tuba',
                'description' => "Tuba frontal indispensable pour l'alignement.",
                'idPret' => '1',
                'image' => 'materiel/tuba.jpg',
            ],
            [
                'nom' => 'Monopalme',
                'description' => 'La voile mythique pour la glisse pure.',
                'idPret' => '1',
                'image' => 'materiel/monopalmes.png',
            ],
            [
                'nom' => 'Maillot & Bonnet',
                'description' => 'Tenue de bain classique exigée.',
                'idPret' => '2',
                'image' => null,
            ],
            [
                'nom' => 'Lunettes',
                'description' => 'Lunettes de natation.',
                'idPret' => '2',
                'image' => 'materiel/lunettes.jpg',
            ],
            [
                'nom' => 'Palmes',
                'description' => 'Palmes de natation classiques decathlon.',
                'idPret' => '2',
                'image' => 'materiel/bi-palmes-decat.jpg',
            ],
        ];

        $newData = [];
        foreach ($materiel as $row) {
            $imagePath = $row['image'];
            unset($row['image']);
            $row['image_id'] = $this->getImageId($imagePath);
            $newData[] = $row;
        }

        $this->db->table('materiel')->insertBatch($newData);
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