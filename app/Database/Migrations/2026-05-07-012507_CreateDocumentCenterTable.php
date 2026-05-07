<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentCenterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'work_permit_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],

            'izin_lembur_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],

            'progress_pengerjaan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        // foreign key
        $this->forge->addForeignKey(
            'work_permit_id',
            'work_permit',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->forge->addForeignKey(
            'izin_lembur_id',
            'izin_lembur',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->forge->addForeignKey(
            'progress_pengerjaan_id',
            'progress_pengerjaan',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('document_center');
    }

    public function down()
    {
        $this->forge->dropTable('document_center');
    }
}
