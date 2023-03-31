<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_logoutUser()
    {
        
        Passport::actingAs(
            User::factory()->create()
        );
                
        $response = $this->post('api/v1/logout');

        $response->assertStatus(204);
    }
}
