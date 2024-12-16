<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuggestionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_srl' => [
                'type' => 'INT',
                'null' => false,
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => false,
            ],
            'user_email' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => false,
            ],
            'suggestions' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => false,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'createAt timestamp default current_timestamp',
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('suggestions', true); // Table creation
    }

    public function down()
    {
        $this->forge->dropTable('suggestions', true);
    }
}
