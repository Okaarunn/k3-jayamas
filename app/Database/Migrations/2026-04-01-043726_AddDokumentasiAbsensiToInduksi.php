<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDokumentasiAbsensiToInduksi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('induksi', [
            'dokumentasi_absensi_filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'dokumentasi_size',
            ],
            'dokumentasi_absensi_original_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'dokumentasi_absensi_filename',
            ],
            'dokumentasi_absensi_mime' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'dokumentasi_absensi_original_name',
            ],
            'dokumentasi_absensi_size' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'     => true,
                'after'    => 'dokumentasi_absensi_mime',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('induksi', 'dokumentasi_absensi_filename');
        $this->forge->dropColumn('induksi', 'dokumentasi_absensi_original_name');
        $this->forge->dropColumn('induksi', 'dokumentasi_absensi_mime');
        $this->forge->dropColumn('induksi', 'dokumentasi_absensi_size');
    }
}
