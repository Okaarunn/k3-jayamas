<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JobSafetyAnalystSeeder extends Seeder
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
                'tahap_pekerjaan' => 'Mencopot kabel yang terpasang',
                'bahaya_pekerjaan' => 'kabel',
                'resiko_pekerjaan' => 'kesetrum',
                'pengendalian' => 'memakai sarung tangan anti listrik',
                'penanggung_jawab' => 'ahmad'
            ],
            [
                'work_permit_id' => $wp->id,
                'tahap_pekerjaan' => 'Memasang kabel yang baru',
                'bahaya_pekerjaan' => 'kabel',
                'resiko_pekerjaan' => 'kesetrum',
                'pengendalian' => 'memakai sarung tangan anti listrik',
                'penanggung_jawab' => 'ahmad'
            ],
        ];

        $this->db->table('job_safety_analyst')->insertBatch($data);
    }
}
