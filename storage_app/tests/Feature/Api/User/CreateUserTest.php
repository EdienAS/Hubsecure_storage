<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * CreateUserTest.
     *
     * @return void
     */
                       
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_createUser()
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
        
        $response = $this->post('api/v1/user',$data);

        $response->assertStatus(200);
    }
    
    public function test_failUserCreateUser()
    {
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $data = [
            'uuid' => 'uuid',
            'name' => $this->faker->firstName(),
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'role_id' => rand(1,2)
        ];
        
        $response = $this->post('api/v1/user',$data);

        $response->assertStatus(403);
    }
}
