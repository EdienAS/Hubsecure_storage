<?php

namespace Tests\Feature\Api\User\Blacklist;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateBlacklistTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * CreateBlacklistTest.
     *
     * @return void
     */
                            
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_createBlacklist()
    {
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $data = [
            'uuid' => 'uuid',
            'name' => $this->faker->firstName(),
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'role_id' => rand(1,2)
        ];
        
        $user = $this->post('api/v1/user',$data);
        
        $response = $this->post('api/v1/user/blacklist/' . $user['data']['uuid']);

        $response->assertStatus(201);
    }
    
    public function test_failUserCreateBlacklist()
    {
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $data = [
            'uuid' => 'uuid',
            'name' => $this->faker->firstName(),
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'role_id' => rand(1,2)
        ];
        
        $user = $this->post('api/v1/user',$data);
        
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $response = $this->post('api/v1/user/blacklist/' . $user['data']['uuid']);
        
        $response->assertStatus(403);
    }
}
