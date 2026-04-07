<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPlantIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'plant_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'username',
            ],
        ]);

        // update users set plant_id
        $this->db->query("UPDATE `users` SET `plant_id` = 1 WHERE `username` = 'admin'");
        $this->db->query("UPDATE `users` SET `plant_id` = 1 WHERE `username` = 'editor'");
        $this->db->query("UPDATE `users` SET `plant_id` = 1 WHERE `username` = 'viewer'");

        // foreign key to plant id
        $this->db->query('
            ALTER TABLE `users`
            ADD CONSTRAINT `fk_users_plant`
                FOREIGN KEY (`plant_id`)
                REFERENCES `plant` (`id`)
                ON DELETE SET NULL
                ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `users` DROP FOREIGN KEY `fk_users_plant`');
        $this->forge->dropColumn('users', 'plant_id');
    }
}
