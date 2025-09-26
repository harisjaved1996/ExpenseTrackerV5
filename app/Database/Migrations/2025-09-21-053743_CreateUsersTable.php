<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUsersTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                // store a hash here later (e.g. password_hash)
            ],

            // created_at: default CURRENT_TIMESTAMP
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],

            // updated_at: we’ll set ON UPDATE CURRENT_TIMESTAMP after table creation
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);          // primary key
        $this->forge->addUniqueKey('email');       // make email unique (recommended)
        $this->forge->createTable('users', true);

        // MySQL's "ON UPDATE CURRENT_TIMESTAMP" is not directly expressible in Forge,
        // so alter the column right after creation:
        $this->db->query(
            'ALTER TABLE `users`
             MODIFY `updated_at` TIMESTAMP NOT NULL
             DEFAULT CURRENT_TIMESTAMP
             ON UPDATE CURRENT_TIMESTAMP'
        );
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
