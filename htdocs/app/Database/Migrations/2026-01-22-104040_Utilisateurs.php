<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Utilisateurs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 100
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'user'],
                'default'    => 'user'
            ],
            // --- Nouveaux champs de sécurité ---
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => '1=Actif, 0=Suspendu'
            ],
            'login_attempts' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 0,
                'unsigned'   => true,
                'comment'    => 'Compteur tentatives échouées'
            ],
            'lock_until' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Date de fin de blocage temporaire'
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('utilisateurs');
    }

    public function down()
    {
        $this->forge->dropTable('utilisateurs');
    }
}