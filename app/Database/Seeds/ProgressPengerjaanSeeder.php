<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProgressPengerjaanSeeder extends Seeder
{
    public function run()
    {
        $wp = $this->db->table('work_permit')
            ->where('no_wp', 'K3/JMI2/WP/001/2026')
            ->get()
            ->getRow();

        if (!$wp) {
            echo 'Error: Work permit tidak ditemukan, jalankan WorkPermitSeeder terlebih dahulu';
            return;
        }

        $lembur = $this->db->table('izin_lembur')
            ->where('work_permit_id', $wp->id)
            ->get()
            ->getRow();

        $this->db->table('progress_pengerjaan')->insert([
            'work_permit_id'    => $wp->id,
            'izin_lembur_id'    => $lembur->id ?? null,
            'status_pengerjaan' => 'ongoing',
            'plant_id'          => $wp->plant_id,
            'updated_by'        => null,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);
    }
}
