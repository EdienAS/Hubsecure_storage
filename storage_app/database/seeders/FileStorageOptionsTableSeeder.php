<?php

namespace Database\Seeders;

use App\Containers\FileStorageOptions\Models\Filestorageoption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FileStorageOptionsTableSeeder extends Seeder
{
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        $roles = [
            [
                'id'         => 1,
                'uuid'       => Str::uuid(date('YmdHisu')),
                'name'      => 'XRPL Storage',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ];

        Filestorageoption::insert($roles);
    }
}
