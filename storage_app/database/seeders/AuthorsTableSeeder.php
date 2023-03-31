<?php

namespace Database\Seeders;

use App\Containers\Authorization\Models\Author;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        $authors = [
            [
                'id'         => 1,
                'title'      => 'User',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id'         => 2,
                'title'      => 'Member',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id'         => 3,
                'title'      => 'Visitor',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ];

        Author::insert($authors);
    }
}
