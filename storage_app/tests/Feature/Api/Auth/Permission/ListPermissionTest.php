<?php

namespace Tests\Feature\Api\Auth\Permission;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListPermissionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * ListPermissionTest.
     *
     * @return void
     */
            
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_listPermission()
    {
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $response = $this->get('api/v1/permissions');

        $response->assertStatus(200);
    }
    
    public function test_failUserListPermission()
    {
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $response = $this->get('api/v1/permissions');

        $response->assertStatus(403);
    }

}
