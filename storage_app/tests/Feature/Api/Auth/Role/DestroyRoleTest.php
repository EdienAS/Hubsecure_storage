<?php

namespace Tests\Feature\Api\Auth\Role;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use App\Containers\Authorization\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyRoleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * DestroyRoleTest.
     *
     * @return void
     */
                            
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_destroyRole()
    {
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $roleIds = Role::where('deleted_at', null)
                ->pluck('uuid')->toArray();
        
        $random_keys = array_rand($roleIds,1);
        
        $response = $this->delete('api/v1/role/' . $roleIds[$random_keys]);

        $response->assertStatus(204);
    }
    
    public function test_failUserDestroyRole()
    {
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $roleIds = Role::where('deleted_at', null)
                ->pluck('uuid')->toArray();
        
        $random_keys = array_rand($roleIds,1);
        
        $response = $this->delete('api/v1/role/' . $roleIds[$random_keys]);

        $response->assertStatus(403);
    }
}
