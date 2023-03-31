<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * DestroyUserTest.
     *
     * @return void
     */
    public function test_destroyUser()
    {
        
        Passport::actingAs(
            User::factory()->create()
        );
        
        $uuid = User::where('deleted_at', null)
                ->where('id', '!=', 1)
                ->pluck('uuid')->first();

        $response = $this->delete('api/v1/user/' . $uuid);

        $response->assertStatus(204);
    }
}
