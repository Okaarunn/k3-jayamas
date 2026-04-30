<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDataLogsTable extends Migration
{
    // app/Database/Migrations/2026-01-01-000010_CreateUserLogsTable.php
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // null jika user sudah dihapus
            ],
            'module' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                // contoh: 'patrol', 'induksi', 'work_permit', 'user'
            ],
            'action' => [
                'type'       => 'ENUM',
                'constraint' => ['create', 'update', 'delete', 'export', 'login', 'logout'],
            ],
            'target_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // ID record yang diubah
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                // contoh: 'Menambahkan patrol K3-0001'
            ],
            'old_data' => [
                'type' => 'JSON',
                'null' => true, // data sebelum diubah (untuk update/delete)
            ],
            'new_data' => [
                'type' => 'JSON',
                'null' => true, // data sesudah diubah (untuk create/update)
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('module');
        $this->forge->addKey('created_at');
        $this->forge->createTable('data_logs');
    }

    public function down()
    {
        $this->forge->dropTable('data_logs');
    }
}
