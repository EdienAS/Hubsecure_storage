<?php

namespace Tests\Feature\Api\UserSettings;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserSettingsTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_updateUserSettingsTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $uuid = $user->uuid;
        
        $updateUserSettingsData = [
            '_method' => 'patch',
            'uuid' => 'uuid',
            'file_storage_option_id' => 1
        ];
        
        if($user->role_id == 1){

            $createUserData = [
                'uuid' => 'uuid',
                'name' => $this->faker->firstName(),
                'email' => $this->faker->email,
                'password' => $this->faker->password,
                'role_id' => 2,
                'is_active' => 1
            ];

            $user = $this->post('api/v1/user', $createUserData);
            
            $uuid = $user['data']['uuid'];
            
            $updateUserSettingsData['storage_limit_mb'] = rand(1,100);
        } else {
            
            $this->userSettingsTestData($user->id);
        
        }
        
        $response = $this->patch('api/v1/usersettings/' . $uuid, $updateUserSettingsData);
        
        $response->assertStatus(204);
    }
}
