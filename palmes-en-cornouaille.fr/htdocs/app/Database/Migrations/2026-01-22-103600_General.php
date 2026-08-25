<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class General extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'image_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'image_groupe_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'nomClub' => ['type' => 'VARCHAR', 'constraint' => 100],
            'mailClub' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'adresse' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description' => ['type' => 'TEXT'],
            'philosophie' => ['type' => 'TEXT'],
            'nombreNageurs' => ['type' => 'INT', 'constraint' => 11],
            'nombreHommes' => ['type' => 'INT', 'constraint' => 11],
            'projetSportif' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'lienFacebook' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'lienInstagram' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'lienffessm' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'logoffessm_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'lienDrive' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'lienDecatPro' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('image_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('image_groupe_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('logoffessm_id', 'images', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('general');
    }

    public function down(): void
    {
        $this->forge->dropTable('general');
    }
}
