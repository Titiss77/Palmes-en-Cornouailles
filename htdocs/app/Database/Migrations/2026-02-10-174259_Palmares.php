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
            'membre_id' => [ // Lien avec le nageur
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'competition' => [ // Nom de la compétition (ex: Championnats de France)
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'epreuve' => [ // Ex: 100m Nage Libre
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'temps' => [ // Ex: 00:58.23 (Optionnel si c'est juste un podium)
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'classement' => [ // 1, 2, 3 pour podium, ou "Finaliste"
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'date_epreuve' => [
                'type' => 'DATE',
            ],
            'image_id' => [ // Photo du podium
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
        $this->forge->addForeignKey('membre_id', 'membres', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('image_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('palmares');
    }

    public function down()
    {
        $this->forge->dropTable('palmares');
    }
}