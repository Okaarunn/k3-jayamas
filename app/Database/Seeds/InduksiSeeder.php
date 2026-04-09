<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InduksiSeeder extends Seeder
{
    public function run()
    {
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
