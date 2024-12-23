<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            'user_id' => 'user',
            'email' => 'user@email.com',
            'username' => 'user',
            'password' => password_hash('123456' , PASSWORD_BCRYPT),
        );
        $this->db->table('users')->insert($data);

    }
}
