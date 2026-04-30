<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

class Role extends BaseController
{
    protected $groupModel;
    protected $permissionModel;
    protected $db;

    public function __construct()
    {
        $this->groupModel      = new GroupModel();
        $this->permissionModel = new PermissionModel();
        $this->db              = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Roles',
            'roles' => $this->groupModel->findAll(),
        ];

        return view('admin/role/roles', $data);
    }


    public function create()
    {
        $data = [
            'title'       => 'Tambah Role Baru',
            'permissions' => $this->permissionModel->findAll(),
        ];

        return view('admin/role/create', $data);
    }

    public function store()
    {
        // validation
        $rules = [
            'name' => [
                'label' => 'name',
                'rules' => 'required|is_unique[auth_groups.name]',
                'errors' => [
                    'is_unique' => 'Role sudah digunakan.'
                ]
            ],
            'description' => [
                'label' => 'description',
                'rules' => 'required',
                'errors' => [
                    'Harap masukkan deskripsi role.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());

            return redirect()->back()->withInput();
        }


        $this->groupModel->insert([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        $roleId = $this->groupModel->getInsertID();

        $permissions = $this->request->getPost('permissions');
        if ($permissions) {
            foreach ($permissions as $permissionId) {
                $this->groupModel->addPermissionToGroup((int) $permissionId, $roleId);
            }
        }

        write_log(
            module: 'role',
            action: 'create',
            description: "Membuat role baru dengan id {$roleId}",
            targetId: $roleId,
            newData: $this->request->getPost()
        );

        session()->setFlashdata('success', 'Role berhasil ditambahkan.');
        return redirect()->to('/admin/roles');
    }

    public function edit($id)
    {
        $role = $this->groupModel->find($id);

        if (! $role) {
            session()->setFlashdata('error', 'Role tidak ditemukan.');
            return redirect()->to('/admin/roles');
        }

        $rolePermissions   = $this->groupModel->getPermissionsForGroup($id);
        $rolePermissionIds = array_keys($rolePermissions);

        $data = [
            'title'             => 'Edit Role',
            'role'              => $role,
            'permissions'       => $this->permissionModel->findAll(),
            'rolePermissionIds' => $rolePermissionIds,
        ];

        return view('admin/role/edit', $data);
    }


    public function update(int $id = 0)
    {
        $rules = [
            'name' => [
                'label' => 'Role',
                'rules' => "required|max_length[255]|is_unique[auth_groups.name,id,{$id}]",
                'errors' => [
                    'is_unique' => 'Role sudah digunakan.'
                ]
            ],
            'description' => [
                'label' => 'Description',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Harap masukkan deskripsi role.'
                ]
            ]
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        // ambil old data DULU
        $oldData = $this->db->table('auth_groups')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        $name        = $this->request->getPost('name');
        $description = $this->request->getPost('description');

        // update role
        $this->db->table('auth_groups')->where('id', $id)->update([
            'name'        => $name,
            'description' => $description,
        ]);

        // update permissions
        $this->db->table('auth_groups_permissions')
            ->where('group_id', $id)
            ->delete();

        $permissions = $this->request->getPost('permissions');

        if (!empty($permissions)) {
            $insertData = [];

            foreach ($permissions as $permissionId) {
                $insertData[] = [
                    'group_id'      => $id,
                    'permission_id' => (int) $permissionId,
                ];
            }

            $this->db->table('auth_groups_permissions')->insertBatch($insertData);
        }

        // clear cache
        cache()->delete("{$id}_permissions");
        cache()->delete("{$id}_users");

        // log
        write_log(
            module: 'role',
            action: 'update',
            description: "Mengubah role {$oldData['name']} menjadi {$name}",
            targetId: $id,
            oldData: $oldData,
            newData: [
                'name' => $name,
                'description' => $description,
                'permissions' => $permissions
            ]
        );

        session()->setFlashdata('success', "Role \"{$name}\" berhasil diperbarui.");
        return redirect()->to('/admin/roles');
    }

    public function delete($id)
    {
        $role = $this->groupModel->find($id);

        if (! $role) {
            session()->setFlashdata('error', 'Role tidak ditemukan.');
            return redirect()->to('/admin/roles');
        }

        // ubah ke array untuk log
        $roleData = $role->toArray();

        // cek apakah masih dipakai user
        $usersInRole = $this->db->table('auth_groups_users')
            ->where('group_id', $id)
            ->countAllResults();

        if ($usersInRole > 0) {

            // log gagal delete
            write_log(
                module: 'role',
                action: 'delete',
                description: "Gagal menghapus role {$role->name} (masih digunakan)",
                targetId: $id,
                oldData: $roleData
            );

            session()->setFlashdata('error', 'Tidak dapat menghapus role yang masih memiliki pengguna.');
            return redirect()->to('/admin/roles');
        }

        // hapus
        if (! $this->groupModel->delete($id)) {
            session()->setFlashdata('error', 'Gagal menghapus role.');
            return redirect()->to('/admin/roles');
        }

        // log sukses delete
        write_log(
            module: 'role',
            action: 'delete',
            description: "Menghapus role {$role->name}",
            targetId: $id,
            oldData: $roleData
        );

        session()->setFlashdata('success', 'Role berhasil dihapus.');
        return redirect()->to('/admin/roles');
    }
}
