<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * ListUserTest.
     *
     * @return void
     */
                   
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_listUser()
    {
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $response = $this->get('api/v1/users');

        $response->assertStatus(200);
    }
    
    public function test_failUserListUser()
    {
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $response = $this->get('api/v1/users');

        $response->assertStatus(403);
    }
}
