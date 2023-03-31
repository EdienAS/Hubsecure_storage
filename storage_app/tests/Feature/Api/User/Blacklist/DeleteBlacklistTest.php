<?php

namespace Tests\Feature\Api\User\Blacklist;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteBlacklistTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * DeleteBlacklistTest.
     *
     * @return void
     */
                          
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_deleteBlacklist()
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
        
        $this->post('api/v1/user/blacklist/' . $user['data']['uuid']);
        
        $response = $this->delete('api/v1/user/blacklist/' . $user['data']['uuid']);

        $response->assertStatus(204);
    }
    
    public function test_failUserDeleteBlacklist()
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
        
        $this->post('api/v1/user/blacklist/' . $user['data']['uuid']);
        
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $response = $this->delete('api/v1/user/blacklist/' . $user['data']['uuid']);

        $response->assertStatus(403);
    }
}
