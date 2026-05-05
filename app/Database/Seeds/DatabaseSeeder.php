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

        // pekerjaan
        $this->call('KategoriPekerjaanSeeder');

        // work permit
        $this->call('WorkPermitSeeder');

        // checklist work permit
        $this->call('ChecklistWorkPermitSeeder');

        $this->call('JobSafetyAnalystSeeder');

        // izin lembur
        $this->call('IzinLemburSeeder');
    }
}
