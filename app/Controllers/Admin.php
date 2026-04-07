<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    protected $db, $builder;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }


    // get user roles and plants
    private function getUserWithRole(int $id = 0)
    {
        $builder = $this->db->table('users');
        $builder->select('users.id as userid, users.username, users.email, users.active, users.plant_id, auth_groups.name, plant.nama_plant, plant.kode_plant');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
        $builder->join('plant', 'plant.id = users.plant_id', 'left');

        if ($id > 0) {
            $builder->where('users.id', $id);
            return $builder->get()->getRow();
        }

        return $builder->get()->getResult();
    }

    // get user plants
    private function getPlants(): array
    {
        return $this->db->table('plant')
            ->orderBy('nama_plant', 'ASC')
            ->get()->getResult();
    }

    // create users
    public function create()
    {
        $data = [
            'title'  => 'Administrator | Tambah User',
            'errors' => session()->getFlashdata('errors') ?? [],
            'plants' => $this->getPlants(),
        ];
        return view('admin/user/create', $data);
    }

    // store data users
    public function store()
    {
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'errors' => [
                    'is_unique' => 'Username sudah digunakan.',
                ],
            ],

            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'is_unique' => 'Email sudah digunakan.',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]',
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok.',
                ],
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required|in_list[administrator,editor,viewer]',
            ],
            'plant_id' => [
                'label'  => 'Plant',
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Plant wajib dipilih.',
                    'integer'  => 'Plant tidak valid.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');
        $isActive = $this->request->getPost('is_active') ? 1 : 0;
        $plantId = (int) $this->request->getPost('plant_id');

        // Simpan user baru
        $this->db->table('users')->insert([
            'username'      => $username,
            'email'         => $email,
            'password_hash' => \Myth\Auth\Password::hash($password),
            'active'        => $isActive,
            'plant_id'      => $plantId,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        $newUserId = $this->db->insertID();

        // Assign role ke auth_groups_users
        $group = $this->db->table('auth_groups')
            ->where('name', $role)
            ->get()->getRow();

        if ($group) {
            $this->db->table('auth_groups_users')->insert([
                'user_id'  => $newUserId,
                'group_id' => $group->id,
            ]);
        }

        session()->setFlashdata('success', "Pengguna \"{$username}\" berhasil ditambahkan.");
        return redirect()->to('/admin/users');
    }


    // data users
    public function users()
    {
        $data = [
            'title' => 'Administrator | Data Users',
            'users' => $this->getUserWithRole(),
        ];
        return view('admin/user/users', $data);
    }

    // form edit user
    public function edit(int $id = 0)
    {
        $user = $this->getUserWithRole($id);

        if (empty($user)) {
            session()->setFlashdata('error', 'Pengguna tidak ditemukan.');
            return redirect()->to('/admin/users');
        }

        $data = [
            'title'  => 'Administrator | Edit User',
            'user'   => $user,
            'errors' => session()->getFlashdata('errors') ?? [],
            'plants' => $this->getPlants(),
        ];

        return view('admin/user/edit', $data);
    }

    // update users
    public function update(int $id = 0)
    {
        // Validasi input
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
                'errors' => [
                    'is_unique' => 'Username sudah digunakan oleh pengguna lain.',
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => "required|valid_email|is_unique[users.email,id,{$id}]",
                'errors' => [
                    'is_unique' => 'Email sudah digunakan oleh pengguna lain.',
                ],
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required|in_list[administrator,editor,viewer]',
            ],
            'plant_id' => [
                'label'  => 'Plant',
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Plant wajib dipilih.',
                    'integer'  => 'Plant tidak valid.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $username  = $this->request->getPost('username');
        $email     = $this->request->getPost('email');
        $role      = $this->request->getPost('role');
        $isActive  = $this->request->getPost('is_active') ? 1 : 0;
        $plantId = (int) $this->request->getPost('plant_id');


        // update table users
        $this->db->table('users')->where('id', $id)->update([
            'username'   => $username,
            'email'      => $email,
            'active'     => $isActive,
            'plant_id'   => $plantId,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Cari group id berdasarkan nama role
        $group = $this->db->table('auth_groups')
            ->where('name', $role)
            ->get()->getRow();

        if ($group) {
            // Cek apakah user sudah punya entri di auth_groups_users
            $existing = $this->db->table('auth_groups_users')
                ->where('user_id', $id)
                ->get()->getRow();

            if ($existing) {
                $this->db->table('auth_groups_users')
                    ->where('user_id', $id)
                    ->update(['group_id' => $group->id]);
            } else {
                $this->db->table('auth_groups_users')->insert([
                    'user_id'  => $id,
                    'group_id' => $group->id,
                ]);
            }
        }

        session()->setFlashdata('success', "Data pengguna \"{$username}\" berhasil diperbarui.");
        return redirect()->to('/admin/users');
    }

    // delete users
    public function delete(int $id = 0)
    {
        $user = $this->db->table('users')->where('id', $id)->get()->getRow();

        if (empty($user)) {
            session()->setFlashdata('error', 'Pengguna tidak ditemukan.');
            return redirect()->to('/admin/users');
        }

        // Jangan hapus diri sendiri
        if ($id === user_id()) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus akun sendiri.');
            return redirect()->to('/admin/users');
        }

        // Hapus relasi group dulu
        $this->db->table('auth_groups_users')->where('user_id', $id)->delete();

        // Hapus user
        $this->db->table('users')->where('id', $id)->delete();

        session()->setFlashdata('success', "Pengguna \"{$user->username}\" berhasil dihapus.");
        return redirect()->to('/admin/users');
    }

    // reset password
    public function resetPassword()
    {
        $rules = [
            'user_id'          => 'required|integer',
            'new_password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->back();
        }

        $userId      = (int) $this->request->getPost('user_id');
        $newPassword = $this->request->getPost('new_password');

        $this->db->table('users')->where('id', $userId)->update([
            'password_hash' => \Myth\Auth\Password::hash($newPassword),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Password berhasil direset.');
        return redirect()->to('/admin/users');
    }
}
