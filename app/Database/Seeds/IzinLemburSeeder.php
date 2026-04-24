<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IzinLemburSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'no_lembur' => 'LB-001',
                'tanggal_lembur' => '2026-04-01',
                'hari' => 'Senin',
                'jam_mulai_lembur' => '18:00:00',
                'jam_selesai_lembur' => '21:00:00',
                'uraian_pekerjaan' => 'Perbaikan panel listrik',
                'alasan_lembur' => 'Perbaikan mendesak',
                'peralatan_digunakan' => 'Toolkit listrik',
                'potensi_bahaya' => 'Sengatan listrik',
                'apd_digunakan' => 'Sarung tangan, helm',
                'nama_penanggung_jawab_vendor' => 'Budi',
                'jabatan_penanggung_jawab_vendor' => 'Supervisor',
                'nama_penanggung_jawab_perusahaan' => 'Andi',
                'jabatan_penanggung_jawab_perusahaan' => 'Manager',
                'dibuat_oleh' => 'system',
            ],
        ];

        $this->db->table('izin_lembur')->insertBatch($data);
    }
}
