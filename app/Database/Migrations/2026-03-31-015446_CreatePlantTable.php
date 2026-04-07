<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlantTable extends Migration
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

            'kode_plant' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],

            'nama_plant' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode_plant');
        $this->forge->addUniqueKey('nama_plant');
        $this->forge->createTable('plant');
    }

    public function down()
    {
        $this->forge->dropTable('plant', true);
    }
}
