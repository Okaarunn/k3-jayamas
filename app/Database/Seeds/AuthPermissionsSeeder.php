<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'manage-users',  'description' => 'Kelola pengguna'],
            ['name' => 'manage-data',   'description' => 'CRUD data'],
            ['name' => 'manage-approval',   'description' => 'Persetujuan data'],
            ['name' => 'export-report', 'description' => 'Export laporan'],
        ];

        foreach ($permissions as $perm) {
            if (!$this->db->table('auth_permissions')->where('name', $perm['name'])->get()->getRow()) {
                $this->db->table('auth_permissions')->insert($perm);
            }
        }

        $groupPermissions = [
            'administrator' => ['manage-users', 'manage-data', 'export-report', 'manage-approval'],
            'k3'        => ['manage-data', 'export-report', 'manage-approval'],
            'p2k3'        => ['export-report', 'manage-approval'],
            'viewer'        => ['export-report'],
        ];

        foreach ($groupPermissions as $groupName => $perms) {
            $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getRow();
            if (!$group) continue;

            foreach ($perms as $permName) {
                $perm = $this->db->table('auth_permissions')->where('name', $permName)->get()->getRow();
                if (!$perm) continue;

                $exists = $this->db->table('auth_groups_permissions')
                    ->where('group_id', $group->id)
                    ->where('permission_id', $perm->id)
                    ->get()->getRow();

                if (!$exists) {
                    $this->db->table('auth_groups_permissions')->insert([
                        'group_id'      => $group->id,
                        'permission_id' => $perm->id,
                    ]);
                }
            }
        }
    }
}
