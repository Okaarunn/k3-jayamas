<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJobSafetyAnalystTable extends Migration
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

            'tahap_pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'bahaya_pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'resiko_pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'pengendalian' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],

            'penanggung_jawab' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('work_permit_id', 'work_permit', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('job_safety_analyst');
    }

    public function down()
    {
        $this->forge->dropTable('job_safety_analyst');
    }
}
