<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthGroupsSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            ['name' => 'administrator', 'description' => 'administrator - akses penuh dan kelola semua pengguna'],
            ['name' => 'editor',        'description' => 'editor - akses ke semua fitur tetapi tidak bisa menambah pengguna'],
            ['name' => 'viewer',        'description' => 'viewer - hanya dapat melihat data dan export laporan'],
        ];

        foreach ($groups as $group) {
            if (!$this->db->table('auth_groups')->where('name', $group['name'])->get()->getRow()) {
                $this->db->table('auth_groups')->insert($group);
            }
        }
    }
}
