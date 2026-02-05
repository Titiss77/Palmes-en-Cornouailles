<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DisciplineSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nom' => 'Surface (SF)', 'description' => "La discipline reine de la vitesse. Équipé d'une monopalme et d'un tuba frontal, le nageur évolue à la surface de l'eau en utilisant un mouvement d'ondulation dauphin. C'est une pratique spectaculaire qui allie puissance musculaire, souplesse et un hydrodynamisme parfait pour atteindre des records de vitesse.", 'image' => 'disciplines/monopalme.jpg'],
            ['nom' => 'Bi-palmes (BI)', 'description' => "Proche de la natation classique mais avec une propulsion décuplée. Les nageurs utilisent deux palmes distinctes et pratiquent le battement de jambes. Cette discipline met l'accent sur la technique de nage, l'endurance et le renforcement des membres inférieurs, offrant une glisse fluide et naturelle.", 'image' => 'disciplines/bipalmes.jpg'],
            ['nom' => 'Apnée (AP)', 'description' => "Le sprint pur en immersion. Cette discipline consiste à parcourir une distance le plus rapidement possible en apnée totale avec une monopalme. C'est un effort explosif qui demande une gestion parfaite de l'hypoxie sous haute intensité, une technique d'ondulation puissante et un mental d'acier pour maintenir la vitesse jusqu'au mur.", 'image' => 'disciplines/apnee.jpg'],
            ['nom' => 'L’immersion (IS)', 'description' => "Une fusion entre la nage avec palmes et la plongée. Le nageur parcourt une distance sous l'eau à l'aide d'une monopalme et d'une petite bouteille d'air (bloc) tenue à bout de bras. Elle exige une technique de nage impeccable et une gestion précise de sa trajectoire en immersion totale.", 'image' => 'disciplines/is.jpg'],
        ];

        $newData = [];
        foreach ($data as $row) {
            $imagePath = $row['image'];
            unset($row['image']); // On enlève l'ancienne clé
            $row['image_id'] = $this->getImageId($imagePath); // On ajoute la nouvelle relation
            $newData[] = $row;
        }

        $this->db->table('disciplines')->insertBatch($newData);
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