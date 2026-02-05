<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GeneralSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nomClub' => 'Palmes en Cornouailles',
            'image_id' => $this->getImageId('favicon.ico'),
            'image_groupe_id' => $this->getImageId('general/groupe.jpg'),
            'description' => "Nous sommes ravis de vous accueillir sur le site officiel de notre club de natation basé à Quimper. Que vous soyez un nageur débutant ou expérimenté, notre club offre une variété de disciplines et d'activités pour tous les âges et niveaux.",
            'mailClub' => getenv('CLUB_EMAIL') ?: NULL,
            'adresse' => getenv('CLUB_ADRESSE') ?: NULL,
            'philosophie' => 'La nage avec palmes apporte gainage et sensation de glisse incomparable.',
            'nombreNageurs' => 109,
            'nombreHommes' => 24,
            'projetSportif' => 'Decouvrir la natation avec Palmes et pour certains accèder à un niveau important de compétiton',
            'lienFacebook' => 'https://www.facebook.com/palmesencornouaille',
            'lienInstagram' => 'https://www.instagram.com/palmesencornouaille/',
            'lienffessm' => 'https://ffessm.fr/',
            'logoffessm_id' => $this->getImageId('general/logo_federation_ffessm.png'),
            'lienDrive' => 'https://drive.google.com/drive/folders/18GiIlRzP7rdLiQx8dArAoSjK9WJZDo3z?usp=drive_link',
            'lienDecatPro' => 'https://partnership.decathlonpro.fr/invitation/e09bce41-329d-4072-b8df-e591fc24e1a2',
        ];
        $this->db->table('general')->insert($data);
    }

    private function getImageId($path)
    {
        if (empty($path))
            return null;
        $existing = $this->db->table('images')->where('path', $path)->get()->getRow();
        if ($existing)
            return $existing->id;
        $this->db->table('images')->insert(['path' => $path]);
        return $this->db->insertID();
    }
}