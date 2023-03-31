<?php

namespace Tests\Feature\Api\Auth\Permission;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Containers\Authorization\Models\Permission;

class DestroyPermissionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * DestroyPermissionTest.
     *
     * @return void
     */
        
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_destroyPermission()
    {
        
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $permissionIds = Permission::where('deleted_at', null)
                ->pluck('uuid')->toArray();
        
        $random_keys = array_rand($permissionIds,1);
        
        $response = $this->delete('api/v1/permission/' . $permissionIds[$random_keys]);

        $response->assertStatus(204);
    }
    
    public function test_failUserDestroyPermission()
    {
        
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $permissionIds = Permission::where('deleted_at', null)
                ->pluck('uuid')->toArray();
        
        $random_keys = array_rand($permissionIds,1);
        
        $response = $this->delete('api/v1/permission/' . $permissionIds[$random_keys]);

        $response->assertStatus(403);
    }
}
