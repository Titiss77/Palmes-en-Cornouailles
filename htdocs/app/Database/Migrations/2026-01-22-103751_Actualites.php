<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Actualites extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'titre' => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'type' => ['type' => 'ENUM', 'constraint' => ['actualite'], 'default' => 'actualite'],
            'statut' => ['type' => 'ENUM', 'constraint' => ['brouillon', 'publie', 'archive'], 'default' => 'brouillon'],
            'description' => ['type' => 'TEXT'],
            'image_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'date_evenement' => ['type' => 'DATE', 'null' => true],
            'id_auteur' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        
        // --- Clés étrangères existantes ---
        $this->forge->addForeignKey('id_auteur', 'membres', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('image_id', 'images', 'id', 'SET NULL', 'CASCADE');

        // --- Nouveaux Index de Performance/Sécurité ---
        // Permet des tris rapides sans scanner toute la table
        $this->forge->addKey('statut'); 
        $this->forge->addKey('type');
        $this->forge->addKey('date_evenement');

        $this->forge->createTable('actualites');
    }

    public function down()
    {
        $this->forge->dropTable('actualites');
    }
}