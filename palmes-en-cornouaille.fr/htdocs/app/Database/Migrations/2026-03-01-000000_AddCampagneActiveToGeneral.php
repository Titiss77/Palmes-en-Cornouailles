<?php declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCampagneActiveToGeneral extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('general', [
            'campagne_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'lienDecatPro'
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('general', 'campagne_active');
    }
}
