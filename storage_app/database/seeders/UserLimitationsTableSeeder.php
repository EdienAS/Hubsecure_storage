<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Containers\User\Models\UserLimitation;

class UserLimitationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userLimitations = [
            [
                'user_id'        => 1,
                'max_storage_amount' => 100,
                'max_team_members' => 10
            ],
        ];

        UserLimitation::insert($userLimitations);
    }
}
