<?php

namespace Tests\Feature\Api\Auth\Permission;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePermissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * CreatePermissionTest.
     *
     * @return void
     */
    
    protected $userRoleId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoleId = config('constants.role_id');

    }

    public function test_createPermission()
    {
        Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $prefix = array('user_','test_');
        $key = array_rand($prefix,1);
        
        $data = [
            'uuid' => 'uuid',
            'title' => $this->faker->lexify($prefix[$key] . '???'),
        ];
        
        $response = $this->post('api/v1/permission',$data);

        $response->assertStatus(200);
    }
    
    public function test_failUserCreatePermission()
    {
        $key = array_rand($this->userRoleId,1);
        
        Passport::actingAs(
            User::factory()->create(['role_id' => $this->userRoleId[$key]])
        );
        
        $prefix = array('user_','test_');
        $key = array_rand($prefix,1);
        
        $data = [
            'uuid' => 'uuid',
            'title' => $this->faker->lexify($prefix[$key] . '???'),
        ];
        
        $response = $this->post('api/v1/permission',$data);

        $response->assertStatus(403);
    }
}
