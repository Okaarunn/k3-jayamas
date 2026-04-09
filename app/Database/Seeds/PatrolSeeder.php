<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PatrolSeeder extends Seeder
{
    public function run()
    {
        // get data user
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
                'kode' => 'K3-0001',
                'nama_petugas' => 'Agum',
                'lokasi' => 'kantor',

                'tanggal_patrol' => '2026-04-07',
                'temuan' => 'tinta basah jatuh',

                'tanggal_penyelesaian' => '2026-04-08',
                'penyelesaian' => 'sudah di pel dan dibersihkan',
                'status_patrol' => 1,

                'foto_before_filename' => '1775719908_521e723f6b14b0f7ea2c.jpg',
                'foto_before_original_name' => 'FB_IMG_1728743467909.jpg',
                'foto_before_mime' => 'image/jpeg',
                'foto_before_size' => 45461,
                'foto_after_filename' => '1775719908_b8c44c47049d28167405.jpg',
                'foto_after_original_name' => 'FB_IMG_1730463733655.jpg',
                'foto_after_mime' => 'image/jpeg',
                'foto_after_size' => 70607,

                'created_by' => $user->id,
                'updated_by' => $user->id,

                'created_at' => '2026-04-07 14:34:31',
                'updated_at' => '2026-04-07 14:34:31',
                'deleted_at' => null,
            ],
            [
                'kode' => 'K3-0002',
                'nama_petugas' => 'Agum',
                'lokasi' => 'kantor',

                'tanggal_patrol' => '2026-04-07',
                'temuan' => 'cat tumpah',

                'tanggal_penyelesaian' => '2026-04-08',
                'penyelesaian' => 'sudah dibersihkan',
                'status_patrol' => 1,

                'foto_before_filename' => '1775719908_521e723f6b14b0f7ea2c.jpg',
                'foto_before_original_name' => 'FB_IMG_1728743467909.jpg',
                'foto_before_mime' => 'image/jpeg',
                'foto_before_size' => 45461,
                'foto_after_filename' => '1775719908_b8c44c47049d28167405.jpg',
                'foto_after_original_name' => 'FB_IMG_1730463733655.jpg',
                'foto_after_mime' => 'image/jpeg',
                'foto_after_size' => 70607,

                'created_by' => $user->id,
                'updated_by' => $user->id,

                'created_at' => '2026-04-07 14:34:31',
                'updated_at' => '2026-04-07 14:34:31',
                'deleted_at' => null,
            ],
        ];

        $this->db->table('patrol')->insertBatch($data);
    }
}
