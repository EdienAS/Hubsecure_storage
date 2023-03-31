<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * UpdateUserTest.
     *
     * @return void
     */
    public function test_updateUser()
    {
        
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $uuid = $user->uuid;
        
        $updateUserData = [
            'name' => $this->faker->firstName(),
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            '_method' => 'patch'
        ];
        
        if($user->role_id == 1){

            $createUserData = [
                'uuid' => 'uuid',
                'name' => $this->faker->firstName(),
                'email' => $this->faker->email,
                'password' => $this->faker->password,
                'role_id' => 2
            ];

            $user = $this->post('api/v1/user', $createUserData);
            
            $uuid = $user['data']['uuid'];
            
            $updateUserData['role_id'] = rand(1,2);
            $updateUserData['is_active'] = rand(0,1);
        }
        
        $response = $this->patch('api/v1/user/' . $uuid, $updateUserData);
        
        $response->assertStatus(200);
    }
}
