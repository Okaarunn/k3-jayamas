<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

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

            'plant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],

            'nama_pengaju' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'email_pengaju' => [
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

            'tgl_mulai' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'tgl_selesai' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'kategori_pekerjaan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],

            'nama_pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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

            'status_approval' => [
                'type'       => 'ENUM("pending", "approve_by_k3", "approve_by_p2k3", "reject_by_k3", "reject_by_p2k3")',
                'default'    => 'pending',
                'null'       => true,
            ],

            'keterangan_ditolak' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],

            'approved_k3_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],

            'approved_p2k3_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],

            'rejected_k3_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],

            'rejected_p2k3_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],

            'verified_k3_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],

            'verified_p2k3_at' => [
                'type' => 'DATETIME',
                'null' => true
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
        $this->forge->addForeignKey('kategori_pekerjaan_id', 'kategori_pekerjaan', 'id', 'CASCADE', 'CASCADE');

        // foreign key table plant
        $this->forge->addForeignKey('plant_id', 'plant', 'id', 'CASCADE', 'CASCADE');

        // foreign key table user

        // approve
        $this->forge->addForeignKey(
            'approved_k3_by',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'approved_p2k3_by',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // reject

        $this->forge->addForeignKey(
            'rejected_k3_by',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'rejected_p2k3_by',
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
