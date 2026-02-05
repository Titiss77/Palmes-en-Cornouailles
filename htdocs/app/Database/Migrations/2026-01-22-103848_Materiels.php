<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Materiels extends Migration
{
    public function up()
    {
        // Table Pret
        $this->forge->addField([
            'id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nom' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('pret');
        
        // Table Matériel
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nom'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT'],
            'idPret'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'image_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('idPret', 'pret', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('image_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('materiel');
    }

    public function down() {
        $this->forge->dropTable('materiel');
        $this->forge->dropTable('pret');
    }
}