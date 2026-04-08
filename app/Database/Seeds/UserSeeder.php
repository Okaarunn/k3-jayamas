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


        // get plant mojoagung
        $plantMojoagung = $this->db->table('plant')
            ->where('nama_plant', 'mojoagung')
            ->get()->getRow();

        // get plant batang
        $plantBatang = $this->db->table('plant')
            ->where('nama_plant', 'batang')
            ->get()->getRow();

        if (! $plantKrian) {
            echo "Error: Plant 'krian' tidak ditemukan. Jalankan PlantSeeder terlebih dahulu.\n";
            return;
        }

        if (! $plantMojoagung) {
            echo "Error: Plant 'mojoagung' tidak ditemukan. Jalankan PlantSeeder terlebih dahulu.\n";
            return;
        }

        if (! $plantBatang) {
            echo "Error: Plant 'batang' tidak ditemukan. Jalankan PlantSeeder terlebih dahulu.\n";
            return;
        }

        $users = [

            // users krian
            [
                'data' => [
                    'email' => 'adminitkrian@jayamas.com',
                    'username' => 'itkrian',
                    'password_hash' => \Myth\Auth\Password::hash('@adminitkrian3241'),
                    'active' => 1,
                    'plant_id' => $plantKrian->id,
                ],
                'role' => 'administrator',
            ],
            [
                'data' => [
                    'email'         => 'editorkrian@jayamas.com',
                    'username'      => 'editorkrian',
                    'password_hash' => \Myth\Auth\Password::hash('@editorkrian2134'),
                    'active'        => 1,
                    'plant_id'      => $plantKrian->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ],
                'role' => 'editor',
            ],
            [
                'data' => [
                    'email'         => 'viewerkrian@jayamas.com',
                    'username'      => 'viewerkrian',
                    'password_hash' => \Myth\Auth\Password::hash('@viewerkrian4321'),
                    'active'        => 1,
                    'plant_id'      => $plantKrian->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ],
                'role' => 'viewer',
            ],

            // users mojoagung
            [
                'data' => [
                    'email' => 'adminitmojoagung@jayamas.com',
                    'username' => 'itmojoagung',
                    'password_hash' => \Myth\Auth\Password::hash('!adminitmojoagung3344'),
                    'active' => 1,
                    'plant_id' => $plantMojoagung->id,
                ],
                'role' => 'administrator',
            ],
            [
                'data' => [
                    'email'         => 'editormojoagung@jayamas.com',
                    'username'      => 'editormojoagung',
                    'password_hash' => \Myth\Auth\Password::hash('!editormojoagung5323'),
                    'active'        => 1,
                    'plant_id'      => $plantMojoagung->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ],
                'role' => 'editor',
            ],
            [
                'data' => [
                    'email'         => 'viewermojoagung@jayamas.com',
                    'username'      => 'viewermojoagung',
                    'password_hash' => \Myth\Auth\Password::hash('!viewermojoagung2324'),
                    'active'        => 1,
                    'plant_id'      => $plantMojoagung->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ],
                'role' => 'viewer',
            ],

            // users batang
            [
                'data' => [
                    'email'         => 'adminitbatang@jayamas.com',
                    'username'      => 'itbatang',
                    'password_hash' => \Myth\Auth\Password::hash('#adminitbatang2143'),
                    'active'        => 1,
                    'plant_id'      => $plantBatang->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ],
                'role' => 'administrator',
            ],
            [
                'data' => [
                    'email'         => 'editorbatang@jayamas.com',
                    'username'      => 'editorbatang',
                    'password_hash' => \Myth\Auth\Password::hash('#editorbatang2745'),
                    'active'        => 1,
                    'plant_id'      => $plantBatang->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ],
                'role' => 'editor',
            ],
            [
                'data' => [
                    'email'         => 'viewerbatang@jayamas.com',
                    'username'      => 'viewerbatang',
                    'password_hash' => \Myth\Auth\Password::hash('#viewerbatang2453'),
                    'active'        => 1,
                    'plant_id'      => $plantBatang->id,
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
