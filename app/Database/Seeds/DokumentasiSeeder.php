<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DokumentasiSeeder extends Seeder
{
    public function run()
    {
        // ambil induksi pertama (atau bisa by tanggal)
        $induksi = $this->db->table('induksi')
            ->where('tanggal_induksi', '2026-04-07')
            ->get()
            ->getRow();

        if (!$induksi) {
            echo 'Error: data induksi tidak ditemukan';
            return;
        }

        $data = [
            [
                'induksi_id' => $induksi->id,
                'filename' => '1775717516_1c4d9d22faa99c42f15d.jpg',
                'original_name' => 'FB_IMG_1728743467909.jpg',
                'mime' => 'image/jpeg',
                'size' => 45461,
                'created_at' => '2026-04-07 14:33:34',
            ],
        ];

        $this->db->table('induksi_dokumentasi')->insertBatch($data);
    }
}
