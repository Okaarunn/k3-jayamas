<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PekerjaanModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pekerjaan extends BaseController
{
    public function index()
    {
        // get data pekerjaan
        $pekerjaanModel = new PekerjaanModel();
        $pekerjaan = $pekerjaanModel->findAll();
    }

    public function store()
    {
        $pekerjaan = new PekerjaanModel();

        $namaPekerjaan = $this->request->getPost('nama_pekerjaan_baru');

        if (empty($namaPekerjaan)) {
            return redirect()->back()->with('error', 'Nama pekerjaan wajib diisi');
        }

        $pekerjaan->insert([
            'nama_pekerjaan' => $namaPekerjaan
        ]);

        return redirect()->to('/work-permit-request')
            ->with('success', 'Pekerjaan berhasil ditambahkan');
    }
}
