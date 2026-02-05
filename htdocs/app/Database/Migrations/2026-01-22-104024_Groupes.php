<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Groupes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nom' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'description' => ['type' => 'TEXT', 'null' => true],
            'tranche_age' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
            'horaire_resume' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'prix' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => false],
            'image_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'ordre' => ['type' => 'INT', 'constraint' => 2, 'default' => 0],
            'codeCouleur' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => null],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('image_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('groupes');
    }

    public function down()
    {
        $this->forge->dropTable('groupes');
    }
}