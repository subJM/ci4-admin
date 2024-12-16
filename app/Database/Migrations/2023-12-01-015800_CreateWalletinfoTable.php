<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWalletinfoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_srl' => [
                'type' => 'INT',
                'null' => false,
            ],
            'wallet' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => false,
            ],
            'token_name' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => true,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
                'null' => false,
            ],
            'balance' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => '0.00',
                'null' => false,
            ],
            'create_at timestamp default current_timestamp',
        ]);

        $this->forge->addKey('Id', true); // Primary Key
        $this->forge->createTable('walletinfo', true); // Table creation
    }

    public function down()
    {
        $this->forge->dropTable('walletinfo', true);
    }
}
