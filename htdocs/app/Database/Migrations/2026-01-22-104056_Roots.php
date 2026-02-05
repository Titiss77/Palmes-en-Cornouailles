<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Roots extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'libelle' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'value' => ['type' => 'TEXT', 'NULL' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('root');
    }

    public function down()
    {
        $this->forge->dropTable('root');
    }
}