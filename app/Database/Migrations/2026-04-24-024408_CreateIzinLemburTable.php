<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIzinLemburTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'no_lembur' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'work_permit_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],

            'tanggal_lembur' => [
                'type' => 'DATE',
                'null' => false,
            ],

            'hari' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],

            'jam_mulai_lembur' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'jam_selesai_lembur' => [
                'type' => 'TIME',
                'null' => false,
            ],

            'uraian_pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'alasan_lembur' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'peralatan_digunakan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'potensi_bahaya' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'apd_digunakan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'nama_penanggung_jawab_vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'jabatan_penanggung_jawab_vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'nama_penanggung_jawab_perusahaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'jabatan_penanggung_jawab_perusahaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],


            'dibuat_oleh' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ]

        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // Unique
        $this->forge->addUniqueKey('no_lembur');

        $this->forge->addUniqueKey('work_permit_id');

        $this->forge->addForeignKey(
            'work_permit_id',
            'work_permit',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('izin_lembur');
    }

    public function down()
    {
        $this->forge->dropTable('izin_lembur');
    }
}
