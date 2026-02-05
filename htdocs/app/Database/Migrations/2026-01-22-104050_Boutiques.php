<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Boutiques extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nom' => ['type' => 'VARCHAR', 'constraint' => 50],
            'url' => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'TEXT'],
            'tranchePrix' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('boutique');
    }

    public function down()
    {
        $this->forge->dropTable('boutique');
    }
}