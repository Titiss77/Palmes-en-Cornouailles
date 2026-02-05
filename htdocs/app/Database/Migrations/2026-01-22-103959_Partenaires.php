<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Partenaires extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'image_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'ordre' => ['type' => 'INT', 'constraint' => 5, 'default' => '1'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('image_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('partenaires');
    }

    public function down()
    {
        $this->forge->dropTable('partenaires');
    }
}