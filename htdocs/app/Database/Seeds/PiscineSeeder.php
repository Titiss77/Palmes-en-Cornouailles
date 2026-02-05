<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PiscineSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nom'         => 'Kerlan vian',
                'adresse'     => '47 Av. des Oiseaux, 29000 Quimper, France',
                'type_bassin' => '25m',
                'photo'       => 'piscines/kerlan_vian.jpg'
            ],
            [
                'nom'         => 'Aquarive',
                'adresse'     => "159 Bd de Créac'h Gwen, 29000 Quimper, France",
                'type_bassin' => '25m',
                'photo'       => 'piscines/aquarive.png'
            ],
            [
                'nom'         => 'Aquaform',
                'adresse'     => "Piscine aqua forme, Av. du Rouillen, 29500 Ergué-Gabéric, France",
                'type_bassin' => '25m',
                'photo'       => 'piscines/aquaform.jpg'
            ],
        ];

        $newData = [];
        foreach ($data as $row) {
            $imagePath = $row['photo']; // Attention, ici c'était 'photo'
            unset($row['photo']);
            $row['image_id'] = $this->getImageId($imagePath);
            $newData[] = $row;
        }

        $this->db->table('piscines')->insertBatch($newData);
    }

    private function getImageId($path)
    {
        if (empty($path)) return null;

        $existing = $this->db->table('images')->where('path', $path)->get()->getRow();
        if ($existing) {
            return $existing->id;
        }

        $this->db->table('images')->insert([
            'path'       => $path,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insertID();
    }
}