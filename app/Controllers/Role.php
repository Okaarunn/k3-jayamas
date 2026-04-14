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
        // validasi
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

        $name        = $this->request->getPost('name');
        $description = $this->request->getPost('description');

        // update role
        $this->db->table('auth_groups')->where('id', $id)->update([
            'name'        => $name,
            'description' => $description,
        ]);

        // update permissions (mirip logic user-role)
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

            // insert batch biar lebih cepat & clean
            $this->db->table('auth_groups_permissions')->insertBatch($insertData);
        }

        // clear cache Myth\Auth
        cache()->delete("{$id}_permissions");
        cache()->delete("{$id}_users");

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

        $usersInRole = $this->db->table('auth_groups_users')
            ->where('group_id', $id)
            ->countAllResults();

        if ($usersInRole > 0) {
            session()->setFlashdata('error', 'Tidak dapat menghapus role yang masih memiliki pengguna.');
            return redirect()->to('/admin/roles');
        }


        if (! $this->groupModel->delete($id)) {
            session()->setFlashdata('error', 'Gagal menghapus role.');
            return redirect()->to('/admin/roles');
        }

        session()->setFlashdata('success', 'Role berhasil dihapus.');
        return redirect()->to('/admin/roles');
    }
}
