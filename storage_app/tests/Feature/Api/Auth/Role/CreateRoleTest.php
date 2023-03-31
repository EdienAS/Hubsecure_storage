<?php

namespace Tests\Feature\Api\Auth\Role;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * CreateRoleTest.
     *
     * @return void
     */
                        
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_createRole()
    {
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $data = [
            'uuid' => 'uuid',
            'title' => $this->faker->lexify('????'),
        ];
        
        $response = $this->post('api/v1/role', $data);

        $response->assertStatus(200);
    }
    
    public function test_failUserCreateRole()
    {
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $data = [
            'uuid' => 'uuid',
            'title' => $this->faker->lexify('????'),
        ];
        
        $response = $this->post('api/v1/role', $data);

        $response->assertStatus(403);
    }
}
