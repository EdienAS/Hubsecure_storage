<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            AuthorsTableSeeder::class,
            SettingsTableSeeder::class,
            FileStorageOptionsTableSeeder::class,
            UserSettingsTableSeeder::class,
            UserLimitationsTableSeeder::class,
        ]);
        
        \Artisan::call('passport:install',['-vvv' => true]);
        
        \Artisan::call('storage:link',['-vvv' => true]);
    }
}
