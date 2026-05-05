<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgressPengerjaanTable extends Migration
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

            'izin_lembur_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'status_pengerjaan' => [
                'type' => "ENUM('ongoing', 'finish')"
            ],

            'plant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],

            'updated_by' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // work permit id
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
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'plant_id',
            'plant',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'updated_by',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('progress_pengerjaan');
    }

    public function down()
    {
        $this->forge->dropTable('progress_pengerjaan');
    }
}
