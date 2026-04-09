<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInduksiAbsensiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'induksi_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            // file absensi
            'filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'original_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'mime' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'size' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('induksi_id');

        $this->forge->createTable('induksi_absensi', true);

        // foreign key
        $this->db->query('
            ALTER TABLE `induksi_absensi`
            ADD CONSTRAINT `fk_induksi_absensi_induksi`
            FOREIGN KEY (`induksi_id`)
            REFERENCES `induksi`(`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `induksi_absensi` DROP FOREIGN KEY `fk_induksi_absensi_induksi`');
        $this->forge->dropTable('induksi_absensi', true);
    }
}
