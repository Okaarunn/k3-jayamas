<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUsersLogs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            // actor who create action
            'actor_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],

            // user who get affected by action
            'target_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],

            // what method actor do to target user
            'action' => [
                'type' => 'ENUM',
                'constraint' => ['INSERT', 'UPDATE', 'DELETE'],
            ],

            // description
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('actor_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('target_user_id', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('user_logs');
    }

    public function down()
    {
        $this->forge->dropTable('users_log');
    }
}
