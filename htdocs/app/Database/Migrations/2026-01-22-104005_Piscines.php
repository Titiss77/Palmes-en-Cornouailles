<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Piscines extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nom'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'adresse'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'type_bassin' => ['type' => 'ENUM', 'constraint' => ['25m', '50m'], 'null' => true],
            'image_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('image_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('piscines');
    }

    public function down()
    {
        $this->forge->dropTable('piscines');
    }
}