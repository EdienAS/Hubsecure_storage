<?php

namespace Database\Seeders;

use App\Containers\User\Models\User;
use Illuminate\Database\Seeder;
use Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        $users = [
            [
                'id'             => 1,
                'uuid'           => Str::uuid(),
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => Hash::make('password'),
                'role_id'        => 1,
                'remember_token' => null,
                'created_at'     => $date,
                'updated_at'     => $date,
            ],
        ];

        User::insert($users);
    }
}
