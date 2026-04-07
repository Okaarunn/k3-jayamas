<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PlantSeeder extends Seeder
{
    public function run()
    {
        $plants = [
            ['kode_plant' => '1000', 'nama_plant' => 'krian', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            ['kode_plant' => '2000', 'nama_plant' => 'mojoagung', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            ['kode_plant' => '3000', 'nama_plant' => 'batang', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($plants as $plant) {
            if (!$this->db->table('plant')->where('nama_plant', $plant['nama_plant'])->get()->getRow()) {
                $this->db->table('plant')->insert($plant);
            }
        }
    }
}
