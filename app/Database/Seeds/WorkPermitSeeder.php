<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WorkPermitSeeder extends Seeder
{
    public function run()
    {

        // get users mojoagung
        $userk3 = $this->db->table('users')
            ->where('username', 'k3mojoagung')
            ->get()
            ->getRow();

        $userp2k3 = $this->db->table('users')->where('username', 'p2k3mojoagung')->get()->getRow();

        if (!$userk3) {
            echo 'Error: user k3mojoagung tidak ditemukan, jalankan users seeder terlebih dahulu';
            return;
        }

        if (!$userp2k3) {
            echo 'Error: user p2k3mojoagung tidak ditemukan, jalankan users seeder terlebih dahulu';
            return;
        }

        // get plant
        $plant = $this->db->table('plant')
            ->where('kode_plant', '2000')
            ->get()
            ->getRow();

        if (!$plant) {
            echo 'Error: plant tidak ditemukan, jalankan plant seeder terlebih dahulu';
            return;
        }

        // get pekerjaan
        $kategori_pekerjaan = $this->db->table('kategori_pekerjaan')->where('id', 3)->get()->getRow();

        if (!$kategori_pekerjaan) {
            echo 'Error: Pekerjaan tidak ditemukan, jalankan pekerjaan seeder terlebih dahulu';
            return;
        }

        $data = [
            [
                'no_wp' => 'K3/JMI2/WP/001/2026',
                'tipe_pengaju' => 'internal',
                'plant_id' => $plant->id,
                'nama_pengaju' => 'Maintenance',
                'email_pengaju' => 'adityafirjaya@gmail.com',
                'alamat_vendor' => null,
                'notelp_vendor' => null,
                'nama_pekerja_vendor' => null,
                'jabatan_pekerja_vendor' => null,
                'no_ktp_pic_vendor' => null,
                'departemen' => 'Maintenance',
                'lokasi_kerja' => 'Gudang',
                'tgl_mulai' => '2026-05-04',
                'kategori_pekerjaan_id' => $kategori_pekerjaan->id,
                'nama_pekerjaan' => 'Memperbaiki kabel di gudang',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '18:00:00',
                'status_approval' => 'approve_by_p2k3',
                'keterangan_ditolak' => null,
                'approved_k3_by' => $userk3->id,
                'approved_p2k3_by' => $userp2k3->id,
                'rejected_k3_by' => null,
                'rejected_p2k3_by' => null,
                'verified_k3_at' => date('Y-m-d H:i:s'),
                'verified_p2k3_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $userp2k3->id,
            ],
        ];

        $this->db->table('work_permit')->insertBatch($data);
    }
}
