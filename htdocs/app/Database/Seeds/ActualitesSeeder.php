<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActualitesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'titre'           => 'Competition Angers',
                'slug'            => 'competition-angers',
                'type'            => 'actualite',
                'statut'          => 'publie',
                'description' => 'Le défi est lancé ! Ce 25 janvier, direction Angers pour une compétition de haut niveau. C\'est l\'occasion idéale pour nos champions de démontrer leur technique et leur détermination sur le terrain.',
                'image'           => null,
                'date_evenement'  => '2026-01-25',
                'id_auteur'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'titre'           => 'Compétition Lorient',
                'slug'            => 'competition-lorient',
                'type'            => 'actualite',
                'statut'          => 'publie',
                'description' => 'Championnat BPL jeunes et masters Manche 1',
                'image'           => null,
                'date_evenement'  => '2026-02-07',
                'id_auteur'       => 1,
                'created_at'      => '2026-02-03 19:35:08',
                'updated_at'      => '2026-02-03 19:35:08',
            ],
        ];

        $newData = [];
        foreach ($data as $row) {
            $imagePath = $row['image'];
            unset($row['image']);
            $row['image_id'] = $this->getImageId($imagePath);
            $newData[] = $row;
        }

        $this->db->table('actualites')->insertBatch($newData);
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