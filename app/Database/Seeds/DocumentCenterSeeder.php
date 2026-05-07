<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DocumentCenterSeeder extends Seeder
{
    public function run()
    {
        $wp = $this->db->table('work_permit')
            ->where('no_wp', 'K3/JMI2/WP/001/2026')
            ->get()->getRow();

        if (!$wp) {
            echo 'Error: Work permit tidak ditemukan, jalankan WorkPermitSeeder terlebih dahulu';
            return;
        }

        $lembur = $this->db->table('izin_lembur')
            ->where('work_permit_id', $wp->id)
            ->get()->getRow();

        if (!$lembur) {
            echo 'Error: Izin lembur tidak ditemukan, jalankan IzinLemburSeeder terlebih dahulu';
            return;
        }

        $progress = $this->db->table('progress_pengerjaan')
            ->where('work_permit_id', $wp->id)
            ->get()->getRow();

        if (!$progress) {
            echo 'Error: Progress pengerjaan tidak ditemukan, jalankan ProgressPengerjaanSeeder terlebih dahulu';
            return;
        }

        $this->db->table('document_center')->insert([
            'work_permit_id'        => $wp->id,
            'izin_lembur_id'        => $lembur->id,
            'progress_pengerjaan_id' => $progress->id,
        ]);
    }
}
