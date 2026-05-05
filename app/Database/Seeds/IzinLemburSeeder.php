<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IzinLemburSeeder extends Seeder
{
    public function run()
    {

        // get work permit
        $wp = $this->db->table('work_permit')
            ->where('no_wp', 'K3/JMI2/WP/001/2026')
            ->get()
            ->getRow();

        if (!$wp) {
            echo 'Error: Work permit tidak ditemukan, jalankan work permit seeder terlebih dahulu';
            return;
        }

        $data = [
            [
                'no_lembur' => 'K3/JMI1/LEMBUR/001/2026',
                'work_permit_id' => $wp->id,
                'tanggal_lembur' => date('Y-m-d H:i:s'),
                'hari' => 'Senin',
                'jam_mulai_lembur' => '16:00:00',
                'jam_selesai_lembur' => '18:00:00',
                'uraian_pekerjaan' => 'perbaikan listrik di gudang',
                'alasan_lembur' => 'terlalu banyak barang di gudang jadi harus dipindah terlebih dahulu',
                'peralatan_digunakan' => 'tang, obeng, bor',
                'potensi_bahaya' => 'kesetrum',
                'apd_digunakan' => 'sarung tangan anti listrik, helm, sepatu safety',
                'nama_penanggung_jawab_vendor' => 'wisnu',
                'jabatan_penanggung_jawab_vendor' => 'kepala bagian',
                'nama_penanggung_jawab_perusahaan' => 'ahmad',
                'jabatan_penanggung_jawab_perusahaan' => 'kepala k3',
                'dibuat_oleh' => 'agung'
            ],
        ];

        $this->db->table('izin_lembur')->insertBatch($data);
    }
}
