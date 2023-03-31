<?php

namespace Database\Seeders;

use App\Containers\Settings\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
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
                'name'         => 'upload_limit',
                'value'      => '8',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name'         => 'default_max_storage_amount',
                'value'      => '5',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name'         => 'default_max_team_member',
                'value'      => '5',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ];

        Setting::insert($authors);
    }
}
