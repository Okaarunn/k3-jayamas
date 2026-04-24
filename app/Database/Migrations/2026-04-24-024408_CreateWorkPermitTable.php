<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWorkPermitTable extends Migration
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

            'no_wp' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'tipe_pengaju' => [
                'type' => 'ENUM("vendor", "internal")',
                'null' => false,
            ],

            'nama_pengaju' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'alamat_vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],


            'notelp_vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'nama_pekerja_vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'jabatan_pekerja_vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'no_ktp_pic_vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'departemen' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'lokasi_kerja' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'tanggal' => [
                'type' => 'DATE',
                'null' => false,
            ],

            'pekerjaan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],


            'jam_mulai' => [
                'type' => 'TIME',
                'null' => false,
            ],

            'jam_selesai' => [
                'type' => 'TIME',
                'null' => false,
            ],

            'tipe_approval' => [
                'type' => 'ENUM("K3","P2K3")',
                'null' => true,
            ],

            'izin_lembur_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],

            'approved_k3' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],

            'approved_p2k3' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('no_wp');

        // foreign key table pekerjaan
        $this->forge->addForeignKey('pekerjaan_id', 'pekerjaan', 'id', 'CASCADE', 'CASCADE');

        // foreign key table izin lembur
        $this->forge->addForeignKey('izin_lembur_id', 'izin_lembur', 'id', 'SET NULL', 'CASCADE');

        // foreign key table user
        $this->forge->addForeignKey(
            'approved_k3',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'approved_p2k3',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'updated_by',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('work_permit');
    }

    public function down()
    {
        $this->forge->dropTable('work_permit');
    }
}
