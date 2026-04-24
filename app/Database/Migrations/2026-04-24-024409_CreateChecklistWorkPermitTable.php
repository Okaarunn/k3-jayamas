<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChecklistWorkPermitTable extends Migration
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

            'work_permit_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],

            // pemeriksaan bahaya
            'pemeriksaan_bahaya' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // penyediaan apd
            'penyediaan_apd' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // alat_pernapasan
            'alat_pernapasan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // pemeriksaan kelayakan
            'pemeriksaan_kelayakan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // tanda peringatan
            'tanda_peringatan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            //  perlengkapan k3
            'perlengkapan_k3' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // penaikan dan penurunan peralatan
            'penaikan_penurunan_peralatan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // peralatan terhubung dengan badan
            'peralatan_terhubung_dengan_badan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // pengecekan alat
            'pengecekan_alat' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // peralatan mengagetkan
            'peralatan_mengagetkan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // konfirmasi pekerja
            'konfirmasi_pekerja' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // monitoring pekerjaan
            'monitoring_pekerjaan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // monitoring kebersihan
            'monitoring_kebersihan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // izin bahan kimia
            'izin_bahan_kimia' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // tersedia apar
            'tersedia_apar' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],

            // penggunaan apd
            'penggunaan_apd' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            // pencegahan tambahan
            'pencegahan_tambahan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addUniqueKey('work_permit_id');

        // FOREIGN KEY
        $this->forge->addForeignKey(
            'work_permit_id',
            'work_permit',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('checklist_work_permit');
    }

    public function down()
    {
        $this->forge->dropTable('checklist_work_permit');
    }
}
