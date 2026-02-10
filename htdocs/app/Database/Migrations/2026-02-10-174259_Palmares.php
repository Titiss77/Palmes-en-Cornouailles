<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Palmares extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // REMPLACEMENT DE membre_id PAR CES DEUX CHAMPS
            'nom_nageur' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'prenom_nageur' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            // ---------------------------------------------
            'competition' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'epreuve' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'temps' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'classement' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'date_epreuve' => [
                'type' => 'DATE',
            ],
            'image_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        // On enlève la clé étrangère vers membres
        $this->forge->addForeignKey('image_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('palmares');
    }

    public function down()
    {
        $this->forge->dropTable('palmares');
    }
}