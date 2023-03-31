<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */    
    public function test_loginUser()
    {
        $data = [
            'email' => 'admin@admin.com',
            'password' => 'password'
        ];
        
        $response = $this->post('api/v1/login', $data);

        $response->assertStatus(200);
    }
    
    public function test_failLoginInactiveUser()
    {
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $data = $this->userTestData();
        
        //Creating new user
        $userData = $this->post('api/v1/user',$data);

        $updateUserData = [
            '_method' => 'patch',
            'is_active' => 0
        ];
        
        //Making user inactive
        $this->patch('api/v1/user/' . $userData['data']['uuid'], $updateUserData);
        
        
        $loginData = [
            'email' => $data['email'],
            'password' => $data['password']
        ];
        
        $response = $this->post('api/v1/login', $loginData);

        $response->assertStatus(401);
    }
    
    public function test_failLoginBlacklistUser()
    {
        
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $data = $this->userTestData();
        
        //Creating new user
        $userData = $this->post('api/v1/user',$data);

        //blacklisting user
        $this->post('api/v1/user/blacklist/' . $userData['data']['uuid']);

        $loginData = [
            'email' => $data['email'],
            'password' => $data['password']
        ];
        
        $response = $this->post('api/v1/login', $loginData);

        $response->assertStatus(401);
    }
    
    public function userTestData(){
        
        $data = [
            'uuid' => 'uuid',
            'name' => $this->faker->firstName(),
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'role_id' => rand(1,2)
        ];
        
        return $data;
    }
}
