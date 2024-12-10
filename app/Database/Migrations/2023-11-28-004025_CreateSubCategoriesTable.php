<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'name'=> [
                'type' => 'VARCHAR',
                'constraint'=> '255',
            ],
            'slug'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255',
            ],
            'parent_cat'=>[
                'type'=> 'INT',
                'constraint'=>11,
                'default'=>0,
            ],
            'description'=>[
                'type'=>'TEXT',
                'null'=>true,
            ],
            'ordering'=>[
                'type'=> 'int',
                'constraint'=>11,
                'dafault'=> 10000,
            ],
            'create_at timestamp default current_timestamp',
            'update_at timestamp default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addKey('id');
        $this->forge->createTable('sub_categories',true);

    }

    public function down()
    {
        $this->forge->dropTable('sub_categories',true);
    }
}
