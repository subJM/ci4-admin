<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PHPUnit\Framework\Constraint\Constraint;

class CreateUsersTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'=>[
                'type'          => 'INT',
                'unsigned'      => true,
                'auto_increment'=> true,
            ],
            'user_id'=>[
                'type'          => 'VARCHAR',
                'constraint'    => '255',
            ],
            'username'=>[
                'type'          => 'VARCHAR',
                'constraint'    => '255'
            ],
            'email'=>[
                'type'          => 'VARCHAR',
                'constraint'    => '255'
            ], 
            'password'=>[
                'type'          => 'VARCHAR',
                'constraint'    => '255'
            ],
            'picture'=>[
                'type'          => 'VARCHAR',
                'constraint'    => '255',
                'null'          => true
            ],
            'bio'=>[
                'type'          => 'VARCHAR',
                'constraint'    => '10',
                'null'          => true
            ],
            'kyc_certification'=>[
                'type'          => 'VARCHAR',
                'constraint'    => '10',
                'default'          => 'NO'
            ],
            'block'=>[
                'type'          => 'VARCHAR',
                'constraint'    => '10',
                'default'          => 'NO'
            ],
            'created_at timestamp default current_timestamp',
            'update_at timestamp default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users',true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('users',true);
    }
}
