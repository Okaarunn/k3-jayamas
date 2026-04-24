<?php

namespace App\Database\Seeds;

use App\Models\PekerjaanModel;
use CodeIgniter\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    public function run()
    {
        $model = new PekerjaanModel();
        $data = [
            ['nama_pekerjaan' => 'Penanganan Bahan Kimia'],
            ['nama_pekerjaan' => 'Pekerjaan Angkat Angkut'],
            ['nama_pekerjaan' => 'Area Tegangan Tinggi'],
            ['nama_pekerjaan' => 'Pekerjaan Penggalian'],
            ['nama_pekerjaan' => 'Pekerjaan Ketinggian'],
            ['nama_pekerjaan' => 'Area Ruang Terbatas'],
        ];

        $model->insertBatch($data);
    }
}
