<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNoticeTable extends Migration
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
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'content' => [
                'type' => 'TEXT',
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint'=> '255'
            ],
            'featured_image' => [
                'type' => 'VARCHAR',
                'constraint'=> '255',
                'null' => true,
            ],
            'tags'=>[
                'type'=> 'TEXT',
                'null'=>true
            ],
            'meta_keywords'=>[
                'type'=>'TEXT',
                'null'=>true,
            ],
            'meta_description'=>[
                'type'=>'TEXT',
                'null'=>true,
            ],
            'visibility'=>[
                'type'=>'INT',
                'constraint'=>11,
                'default'=>1,
            ],
            'create_at timestamp default current_timestamp',
            'update_at timestamp default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('notice', true); // Table creation
    }

    public function down()
    {
        $this->forge->dropTable('notice', true);
    }
}
