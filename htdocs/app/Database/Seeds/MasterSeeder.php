<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run()
    {
        $this->call('GeneralSeeder');
        $this->call('DisciplineSeeder');
        $this->call('PiscineSeeder');
		$this->call('CalendrierSeeder');
        $this->call('MaterielSeeder');
        $this->call('PersonnelSeeder');
        $this->call('BoutiqueSeeder');
        $this->call('ActualitesSeeder');
        $this->call('UserSeeder');
        $this->call('RootSeeder');
        $this->call('GroupesSeeder');
        $this->call('PartenairesSeeder');
    }
}