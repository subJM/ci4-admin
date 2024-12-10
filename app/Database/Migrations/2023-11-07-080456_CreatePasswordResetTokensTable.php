<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePasswordResetTokensTable extends Migration
{
    public function up()
    {
        //
        $db = db_connect();
        if (!$db->tableExists('password_reset_tokens') ) {
            $this->forge->addField([
                'email' => [
                    'type' =>'VARCHAR',
                    'constraint' => 255,
                ],
                'token' => [
                    'type'=> 'VARCHAR',
                    'constraint' => 255,
                ],
                'create_at timestamp default current_timestamp'
            ]);
            $this->forge->createTable('password_reset_tokens',true);
        }
    }

    public function down()
    {
        //
        $this->forge->dropTable('password_reset_tokens', true);
    }
}
