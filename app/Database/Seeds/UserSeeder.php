<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\GroupModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $groupModel = new GroupModel();

        $this->db->table('users')->insert([
            'email'         => 'aditya@mail.com',
            'username'      => 'aditya',
            'password_hash' => \Myth\Auth\Password::hash('aditya12345'),
            'active'        => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        $userId = $this->db->insertID();

        $group = $this->db->table('auth_groups')
            ->where('name', 'administrator')
            ->get()
            ->getRow();

        if ($group) {
            $groupModel->addUserToGroup($userId, $group->id);
        }
    }
}
