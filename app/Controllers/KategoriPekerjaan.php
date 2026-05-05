<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriPekerjaanModel;
use CodeIgniter\HTTP\ResponseInterface;

class KategoriPekerjaan extends BaseController
{
    public function index()
    {
        // get data pekerjaan
        $kategoriPekerjaanModel = new KategoriPekerjaanModel();
        $kategoriPekerjaan = $kategoriPekerjaanModel->findAll();
    }

    public function store()
    {
        $kategoriPekerjaan = new KategoriPekerjaanModel();

        $namaKategoriPekerjaan = $this->request->getPost('nama_kategori_pekerjaan_baru');

        if (empty($namaKategoriPekerjaan)) {
            return redirect()->back()->with('error', 'Nama pekerjaan wajib diisi');
        }

        $kategoriPekerjaan->insert([
            'nama_kategori_pekerjaan' => $namaKategoriPekerjaan
        ]);

        return redirect()->to('/work-permit-request')
            ->with('success', 'Pekerjaan berhasil ditambahkan');
    }
}
