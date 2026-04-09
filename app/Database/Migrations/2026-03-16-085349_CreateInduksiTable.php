<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInduksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal_induksi' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'jumlah_peserta' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // relasi user
            'created_by' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'updated_by' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal_induksi');

        $this->forge->createTable('induksi', true);

        // FK
        $this->db->query('
            ALTER TABLE `induksi`
            ADD CONSTRAINT `fk_induksi_created_by`
            FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
            ON DELETE SET NULL ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_induksi_updated_by`
            FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`)
            ON DELETE SET NULL ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `induksi` DROP FOREIGN KEY `fk_induksi_created_by`');
        $this->db->query('ALTER TABLE `induksi` DROP FOREIGN KEY `fk_induksi_updated_by`');
        $this->forge->dropTable('induksi', true);
    }
}
