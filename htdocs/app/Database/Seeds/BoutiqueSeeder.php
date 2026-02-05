<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BoutiqueSeeder extends Seeder
{
    public function run()
    {
        $boutique = [
            [
                'nom' => 'Tenue Club',
                'url' => 'https://www.helloasso.com/associations/club-de-palmes-en-cornouaille/boutiques/tenue-club-2',
                'description'      => 'Équipez-vous avec le Tee-shirt et le short aux couleurs du PEC. Idéal pour les
                entraînements et les podiums.',
                'tranchePrix' => 'De 9€ à 40€',
            ],
            [
                'nom' => 'Destockage Boutique PEC',
                'url' => 'https://www.helloasso.com/associations/club-de-palmes-en-cornouaille/boutiques/boutique-pec-2',
                'description'      => 'Anciennes collections, fins de séries et accessoires de natation à prix réduits.
                Stocks limités !',
                'tranchePrix' => 'De 5€ à 20€',
            ],
        ];
        
        $this->db->table('boutique')->insertBatch($boutique);
    }
}