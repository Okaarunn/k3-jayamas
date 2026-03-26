<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = model(UserModel::class);

        // data users
        $users = [
            [
                'email'    => 'admin@mail.com',
                'username' => 'admin',
                'password' => 'jayamas2026',
                'active'   => 1,
                'group'    => 'administrator'
            ],
            [
                'email'    => 'editor@mail.com',
                'username' => 'editor',
                'password' => 'editor12345',
                'active'   => 1,
                'group'    => 'editor'
            ],
            [
                'email'    => 'viewer@mail.com',
                'username' => 'viewer',
                'password' => 'viewer12345',
                'active'   => 1,
                'group'    => 'viewer'
            ],
        ];

        foreach ($users as $user) {
            $userModel
                ->withGroup($user['group'])
                ->save([
                    'email'    => $user['email'],
                    'username' => $user['username'],
                    'password' => $user['password'],
                    'active'   => $user['active'],
                ]);
        }
    }
}
