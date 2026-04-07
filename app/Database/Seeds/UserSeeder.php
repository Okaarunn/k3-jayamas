<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\GroupModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $groupModel = new GroupModel();

        // get plant krian
        $plantKrian = $this->db->table('plant')
            ->where('nama_plant', 'krian')
            ->get()->getRow();

        if (! $plantKrian) {
            echo "Error: Plant 'krian' tidak ditemukan. Jalankan PlantSeeder terlebih dahulu.\n";
            return;
        }

        $users = [
            [
                'data' => [
                    'email'         => 'admin@jayamas.com',
                    'username'      => 'admin',
                    'password_hash' => \Myth\Auth\Password::hash('jayamas2026'),
                    'active'        => 1,
                    'plant_id'      => $plantKrian->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ],
                'role' => 'administrator',
            ],
            [
                'data' => [
                    'email'         => 'editor@jayamas.com',
                    'username'      => 'editor',
                    'password_hash' => \Myth\Auth\Password::hash('editor12345'),
                    'active'        => 1,
                    'plant_id'      => $plantKrian->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ],
                'role' => 'editor',
            ],
            [
                'data' => [
                    'email'         => 'viewer@jayamas.com',
                    'username'      => 'viewer',
                    'password_hash' => \Myth\Auth\Password::hash('viewer12345'),
                    'active'        => 1,
                    'plant_id'      => $plantKrian->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ],
                'role' => 'viewer',
            ],
        ];

        // check if the username already exists
        foreach ($users as $user) {
            $exists = $this->db->table('users')
                ->where('email', $user['data']['email'])
                ->orWhere('username', $user['data']['username'])
                ->get()->getRow();

            if ($exists) {
                echo "Skip: {$user['data']['username']} sudah ada.\n";
                continue;
            }

            // insert users
            $this->db->table('users')->insert($user['data']);
            $userId = $this->db->insertID();

            // get role
            $group = $this->db->table('auth_groups')
                ->where('name', $user['role'])
                ->get()->getRow();

            if ($group) {
                $groupModel->addUserToGroup($userId, $group->id);
                echo "Berhasil: {$user['data']['username']} ({$user['role']}) ditambahkan.\n";
            } else {
                echo "Peringatan: Role '{$user['role']}' tidak ditemukan di auth_groups.\n";
            }
        }
    }
}
