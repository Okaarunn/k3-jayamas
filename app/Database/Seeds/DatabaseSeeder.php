<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // urutan penting
        $this->call('AuthGroupsSeeder');
        $this->call('AuthPermissionsSeeder');
        $this->call('UserSeeder'); // kalau ada
    }
}
