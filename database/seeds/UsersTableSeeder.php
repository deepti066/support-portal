<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'superadmin@admin.com',
                'password'       => bcrypt('12345678'),
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Agent 1',
                'email'          => 'agent1@agent1.com',
                'password'       => bcrypt('123456'),
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'Agent 2',
                'email'          => 'agent2@agent2.com',
                'password'       => bcrypt('123456'),
                'remember_token' => null,
            ],
            [
                'id'             => 4,
                'name'           => 'Agent 3',
                'email'          => 'agent3@agent3.com',
                'password'       => bcrypt('123456'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
