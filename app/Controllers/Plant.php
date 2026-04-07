<?php

namespace App\Controllers;

use App\Controllers\BaseController;



class Plant extends BaseController
{

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function getPlants(): array
    {
        return $this->db->table('plant')
            ->orderBy('nama_plant', 'ASC')
            ->get()->getResult();
    }

    public function index()
    {
        $data = [
            'title' => 'Administrator | Data Plant',
            'plants' => $this->getPlants(),
        ];
        return view('admin/plant/plant', $data);
    }

    // form create data
    public function create()
    {
        $data = [
            'title' => 'Administrator | Tambah Plant',
            'plants' => $this->getPlants(),
        ];
        return view('admin/plant/create', $data);
    }

    // store data
    public function store()
    {
        // validation data
        $rules = [
            'kode_plant' => [
                'rules' => 'required|is_unique[plant.kode_plant]',
                'errors' => [
                    'required' => 'Kode plant wajib diisi',
                    'is_unique' => 'Kode plant sudah digunakan'
                ]
            ],
            'nama_plant' => [
                'rules' => 'required|is_unique[plant.nama_plant]',
                'errors' => [
                    'required' => 'Nama plant wajib diisi',
                    'is_unique' => 'Nama plant sudah digunakan'
                ]
            ]
        ];

        // handle error input
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        // get request input users
        $request = [
            'kode_plant' => $this->request->getPost('kode_plant'),
            'nama_plant' => $this->request->getPost('nama_plant'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // insert data
        $this->db->table('plant')->insert($request);

        // handle success input

        session()->setFlashdata('success', 'Data plant berhasil ditambahkan');
        return redirect()->to('/admin/plant');
    }

    // form edit data
    public function edit($id)
    {
        $data = [
            'title' => 'Administrator | Edit Plant',
            'plant' => $this->db->table('plant')->where('id', $id)->get()->getRow(),
            'plants' => $this->getPlants(),
        ];
        return view('admin/plant/edit', $data);
    }

    // update data
    public function update($id)
    {
        // validation data
        $rules = [
            'kode_plant' => [
                'rules' => "required|is_unique[plant.kode_plant,id,{$id}]",
                'errors' => [
                    'required' => 'Kode plant wajib diisi',
                    'is_unique' => 'Kode plant sudah digunakan'
                ]
            ],
            'nama_plant' => [
                'rules' => "required|is_unique[plant.nama_plant,id,{$id}]",
                'errors' => [
                    'required' => 'Nama plant wajib diisi',
                    'is_unique' => 'Nama plant sudah digunakan'
                ]
            ]
        ];

        // handle error input
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // get request input users
        $request = [
            'kode_plant' => $this->request->getPost('kode_plant'),
            'nama_plant' => $this->request->getPost('nama_plant'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // update data
        $this->db->table('plant')->where('id', $id)->update($request);

        // handle success
        session()->setFlashdata('success', 'Data plant berhasil diubah');

        return redirect()->to('/admin/plant');
    }

    // delete data
    public function delete($id)
    {
        try {
            // delete data
            $this->db->table('plant')->delete(['id' => $id]);

            // check query
            if ($this->db->affectedRows() === 0) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            // handle success
            return redirect()->to('/admin/plant')
                ->with('success', 'Data plant berhasil dihapus.');
        } catch (\Throwable $e) {
            // handle error
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server.');
        }
    }
}
