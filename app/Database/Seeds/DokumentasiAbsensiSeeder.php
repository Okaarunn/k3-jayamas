<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DokumentasiAbsensiSeeder extends Seeder
{
    public function run()
    {
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
                'filename' => '1775717516_e5c941761c462616b80b.jpg',
                'original_name' => 'FB_IMG_1730463733655.jpg',
                'mime' => 'image/jpeg',
                'size' => 70607,
                'created_at' => '2026-04-07 14:33:34',
            ],

            [
                'induksi_id' => $induksi->id,
                'filename' => '1775717516_e5c941761c462616b80b.jpg',
                'original_name' => 'FB_IMG_1730463733655.jpg',
                'mime' => 'image/jpeg',
                'size' => 70607,
                'created_at' => '2026-04-07 14:33:34',
            ],
        ];

        $this->db->table('induksi_absensi')->insertBatch($data);
    }
}
