<?php

namespace Database\Seeders;

use App\Containers\Authorization\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        $roles = [
            [
                'id'         => 1,
                'uuid'       => Str::uuid(date('YmdHisu')),
                'title'      => 'Admin',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id'         => 2,
                'uuid'       => Str::uuid(date('YmdHisu')),
                'title'      => 'User',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ];

        Role::insert($roles);
    }
}
