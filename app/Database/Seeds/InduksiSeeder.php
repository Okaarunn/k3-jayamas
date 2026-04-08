<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InduksiSeeder extends Seeder
{
    public function run()
    {
        // get user data
        $user = $this->db->table('users')
            ->where('username', 'editormojoagung')
            ->get()
            ->getRow();

        if (!$user) {
            echo 'Error: user tidak ditemukan, jalankan users seeder terlebih dahulu';
            return;
        }

        $data = [
            [
                'tanggal_induksi' => '2026-04-07',
                'jumlah_peserta' => 1,
                'keterangan' => 'Induksi karyawan baru',

                'dokumentasi_filename' => '1775547214_c18059d439f0a7555653.jpg',
                'dokumentasi_original_name' => 'FB_IMG_1728743467909.jpg',
                'dokumentasi_mime' => 'image/jpeg',
                'dokumentasi_size' => 45461,

                'dokumentasi_absensi_filename' => '1775547214_7366136967610b6225cd.jpg',
                'dokumentasi_absensi_original_name' => 'FB_IMG_1730463733655.jpg',
                'dokumentasi_absensi_mime' => 'image/jpeg',
                'dokumentasi_absensi_size' => 70607,

                'created_by' => $user->id,
                'updated_by' => $user->id,

                'created_at' => '2026-04-07 14:33:34',
                'updated_at' => '2026-04-07 14:33:34',
                'deleted_at' => null,
            ]
        ];

        $this->db->table('induksi')->insertBatch($data);
    }
}
