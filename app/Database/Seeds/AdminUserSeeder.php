<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            'admin_id' => 'Admin',
            'email' => 'admin@email.com',
            'username' => 'Admin',
            'password' => password_hash('123456' , PASSWORD_BCRYPT),
        );
        $this->db->table('admin_user')->insert($data);

    }
}
