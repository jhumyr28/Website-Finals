<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Check if admin already exists
        $db = \Config\Database::connect();
        $existing = $db->table('users')->where('email', 'admin@example.com')->get()->getRow();

        if (!$existing) {
            $data = [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'is_admin' => 1,
            ];
            $db->table('users')->insert($data);
        }
    }
}
