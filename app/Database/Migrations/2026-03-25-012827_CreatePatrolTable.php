<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatrolTable extends Migration
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
            'kode' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,

            ],
            'nama_petugas' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'tanggal_patrol' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'tanggal_penyelesaian' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'foto_before_filename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'foto_before_original_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'foto_before_mime' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'foto_before_size' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'foto_after_filename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'foto_after_original_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'foto_after_mime' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'foto_after_size' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode');
        $this->forge->addKey('tanggal_patrol');
        $this->forge->addKey('created_by');
        $this->forge->createTable('patrol', true);

        $this->db->query('
            ALTER TABLE `patrol`
            ADD CONSTRAINT `fk_patrol_created_by`
                FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
                ON DELETE SET NULL ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_patrol_updated_by`
                FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`)
                ON DELETE SET NULL ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `patrol` DROP FOREIGN KEY `fk_patrol_created_by`');
        $this->db->query('ALTER TABLE `patrol` DROP FOREIGN KEY `fk_patrol_updated_by`');
        $this->forge->dropTable('patrol', true);
    }
}
