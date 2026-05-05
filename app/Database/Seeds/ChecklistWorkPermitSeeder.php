<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ChecklistWorkPermitSeeder extends Seeder
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
                'work_permit_id' => $wp->id,
                'pemeriksaan_bahaya' => 1,
                'penyediaan_apd' => 1,
                'alat_pernapasan' => 1,
                'pemeriksaan_kelayakan' => 1,
                'tanda_peringatan' => 1,
                'perlengkapan_k3' => 1,
                'penaikan_penurunan_peralatan' => 1,
                'peralatan_terhubung_dengan_badan' => 1,
                'pengecekan_alat' => 1,
                'peralatan_mengagetkan' => 1,
                'konfirmasi_pekerja' => 1,
                'monitoring_pekerjaan' => 1,
                'monitoring_kebersihan' => 1,
                'izin_bahan_kimia' => 0,
                'tersedia_apar' => 1,
                'penggunaan_apd' => 'Sepatu safety, sarung tangan anti listrik, kacamata safety, helm',
                'pencegahan_tambahan' => 'Tangga yang kokoh',
                'pengawasan' => 'Aji, Diana',
                'bagian_pekerjaan' => 'aditya (memasang kabel), hendra (memotong kabel), samsul (pengecekan aliran listrik)',
                'mengetahui_ak3' => 'Diana',
                'penanggung_jawab' => 'ahmad'
            ]
        ];
        $this->db->table('checklist_work_permit')->insertBatch($data);
    }
}
