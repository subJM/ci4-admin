<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLOTTHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'token_name' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => false,
            ],
            'user_srl' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => false,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'default' => 'withdraw',
                'comment' => "'withdraw', 'deposit'",
            ],
            'from_address' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'to_address' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '50,18',
                'null' => false,
            ],
            'usedFee' => [
                'type' => 'DECIMAL',
                'constraint' => '50,18',
                'null' => false,
            ],
            'IsExternalTrade' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'default' => 'no',
                'null' => false,
            ],
            'transactionHash' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'default' => 'pending',
                'comment' => "'COMPLETE', 'PENDING', 'FAIL'",
            ],
            'create_at timestamp default current_timestamp',
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('LOTT_history', true); // Table creation
    }

    public function down() 
    {
        $this->forge->dropTable('LOTT_history', true);
    }
}
