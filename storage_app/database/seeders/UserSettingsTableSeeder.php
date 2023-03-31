<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Containers\User\Models\User;
use App\Containers\UserSettings\Models\Usersetting;

class UserSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        $userSetting = [
            [
                'id'             => 1,
                'uuid'           => Str::uuid(),
                'user_id'        => User::find(1)->pluck('id')->first(),
                'file_storage_option_id' => 1,
                'storage_limit_mb' => 100,
                
                'created_at'     => $date,
                'updated_at'     => $date,
            ],
        ];

        Usersetting::insert($userSetting);
    }
}
