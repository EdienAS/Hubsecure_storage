<?php

namespace Tests\Feature\Api\Auth\Permission;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Containers\Authorization\Models\Permission;

class UpdatePermissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * UpdatePermissionTest.
     *
     * @return void
     */
                    
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_updatePermission()
    {
        
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $permissionIds = Permission::where('deleted_at', null)
                ->pluck('uuid')->toArray();
        
        $random_keys = array_rand($permissionIds,1);
        
        $prefix = array('user_','test_');
        $key = array_rand($prefix,1);
        
        $data = [
            'title' => $this->faker->lexify($prefix[$key] . '???'),
            '_method' => 'patch'
        ];
        
        $response = $this->patch('api/v1/permission/' . $permissionIds[$random_keys], $data);

        $response->assertStatus(200);
        
    }
    
    public function test_failUserUpdatePermission()
    {
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $permissionIds = Permission::where('deleted_at', null)
                ->pluck('uuid')->toArray();
        
        $random_keys = array_rand($permissionIds,1);
        
        $prefix = array('user_','test_');
        $key = array_rand($prefix,1);
        
        $data = [
            'title' => $this->faker->lexify($prefix[$key] . '???'),
            '_method' => 'patch'
        ];
        
        $response = $this->patch('api/v1/permission/' . $permissionIds[$random_keys], $data);

        $response->assertStatus(403);
        
    }

}
