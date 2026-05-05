<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriPekerjaanTable extends Migration
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
            'nama_kategori_pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true, 'PRIMARY');
        $this->forge->createTable('kategori_pekerjaan');
    }

    public function down()
    {
        $this->forge->dropTable('kategori_pekerjaan');
    }
}
