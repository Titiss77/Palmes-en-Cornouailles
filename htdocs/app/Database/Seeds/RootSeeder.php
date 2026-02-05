<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RootSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['libelle' => 'primary', 'value' => '#002d5a'],
            //['libelle' => 'secondary', 'value' => '#ca258b88'],
            ['libelle' => 'secondary', 'value' => '#ca258b'],
            ['libelle' => 'accent', 'value' => '#ffcc00'],
            ['libelle' => 'text_dark', 'value' => '#1a1a1a'],
            ['libelle' => 'text_muted', 'value' => '#666'],
            //['libelle' => 'bg_light', 'value' => 'linear-gradient(160deg, #f8fbff 0%, #f8fbff 40%, var(--secondary) 50%, #f8fbff 60%, #f8fbff 100%)'],
            ['libelle' => 'bg_light', 'value' => '#f8fbff'],
            ['libelle' => 'white', 'value' => '#ffffff'],
            ['libelle' => 'shadow', 'value' => '0 4px 15px rgba(0, 45, 90, 0.1)'],
            ['libelle' => 'radius', 'value' => '12px'],
            ['libelle' => 'transition', 'value' => 'all 0.3s ease'],
            ['libelle' => 'grid-template-columns', 'value' => 'repeat(auto-fit, minmax(15rem, 1fr))'],
            ['libelle' => 'aspect-ratio', 'value' => '2/1'],
            ['libelle' => 'size-logo-top', 'value' => '80px'],
        ];

        $this->db->table('root')->insertBatch($data);
    }
}