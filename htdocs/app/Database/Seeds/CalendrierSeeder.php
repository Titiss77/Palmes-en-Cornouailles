<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CalendrierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'categorie' => 'scolaire',
                'date'      =>  '2025 - 2026',    
                'image'     => 'calendriers/planning_scolaire.jpg',
            ],
            [
                'categorie' => 'vacances',
                'date'      =>  'du 15/12 au 20/12',    
                'image'     => 'calendriers/planning_vacances.jpg',
            ],
            [
                'categorie' => 'competitions',
                'date'      =>  '2025 - 2026',    
                'image'     => 'calendriers/calendrier_competitions.pdf',
            ],
        ];

        $newData = [];
        foreach ($data as $row) {
            $imagePath = $row['image'];
            unset($row['image']);
            $row['image_id'] = $this->getImageId($imagePath);
            $newData[] = $row;
        }

        $this->db->table('calendriers')->insertBatch($newData);
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