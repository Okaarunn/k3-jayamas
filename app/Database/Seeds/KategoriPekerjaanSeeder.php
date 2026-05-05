<?php

namespace App\Database\Seeds;

use App\Models\KategoriPekerjaanModel;
use CodeIgniter\Database\Seeder;

class KategoriPekerjaanSeeder extends Seeder
{
    public function run()
    {
        $model = new KategoriPekerjaanModel();
        $data = [
            ['nama_kategori_pekerjaan' => 'Penanganan Bahan Kimia'],
            ['nama_kategori_pekerjaan' => 'Pekerjaan Angkat Angkut'],
            ['nama_kategori_pekerjaan' => 'Area Tegangan Tinggi'],
            ['nama_kategori_pekerjaan' => 'Pekerjaan Penggalian'],
            ['nama_kategori_pekerjaan' => 'Pekerjaan Ketinggian'],
            ['nama_kategori_pekerjaan' => 'Area Ruang Terbatas'],
        ];

        $model->insertBatch($data);
    }
}
