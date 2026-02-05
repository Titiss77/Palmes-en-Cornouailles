<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Calendriers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'categorie' => ['type' => 'ENUM', 'constraint' => ['scolaire', 'vacances', 'competitions'], 'null' => true],
            'date' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'image_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('image_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('calendriers');
    }

    public function down()
    {
        $this->forge->dropTable('calendriers');
    }
}