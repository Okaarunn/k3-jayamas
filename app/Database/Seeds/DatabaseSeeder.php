<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('AuthGroupsSeeder');
        $this->call('AuthPermissionsSeeder');
        $this->call('PlantSeeder');
        $this->call('UserSeeder');

        $this->call('PatrolSeeder');
        $this->call('InduksiSeeder');
        $this->call('DokumentasiSeeder');
        $this->call('DokumentasiAbsensiSeeder');
    }
}
