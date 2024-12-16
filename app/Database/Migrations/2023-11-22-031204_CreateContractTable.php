<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContractTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => true,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => true,
            ],
            'token_name' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => false,
            ],
            'token_simbol' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
            ],
            'amount' => [
                'type' => 'INT',
                'null' => false,
            ],
            'mintable' => [
                'type' => 'TINYINT',
                'null' => false,
            ],
            'burnable' => [
                'type' => 'TINYINT',
                'null' => false,
            ],
            'pausable' => [
                'type' => 'TINYINT',
                'null' => false,
            ],
            'permit' => [
                'type' => 'TINYINT',
                'null' => false,
            ],
            'flashminting' => [
                'type' => 'TINYINT',
                'null' => false,
            ],
            'deployContract' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'create_at timestamp default current_timestamp',
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('contract', true); // Table creation
    }

    public function down()
    {
        $this->forge->dropTable('contract', true);
    }
}
