<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthGroupsSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            ['name' => 'administrator', 'description' => 'Memberikan akses penuh terhadap data K3 dan kelola semua pengguna'],
            ['name' => 'k3',        'description' => 'Memberikan akses terhadap modifikasi data'],
            ['name' => 'p2k3',        'description' => 'Memberikan akses persetujuan pada data'],
            ['name' => 'viewer',        'description' => 'Memberikan akses hanya melihat data dan export laporan'],
        ];

        foreach ($groups as $group) {
            if (!$this->db->table('auth_groups')->where('name', $group['name'])->get()->getRow()) {
                $this->db->table('auth_groups')->insert($group);
            }
        }
    }
}
