<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUserTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * ShowUserTest.
     *
     * @return void
     */
    public function test_showUser()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $userIds = User::where('deleted_at', null)
                ->where('id', '!=', 1)
                ->pluck('uuid')->toArray();
        
        $random_keys = array_rand($userIds,1);
        
        $response = $this->get('api/v1/user/' . $userIds[$random_keys]);

        $response->assertStatus(200);
    }
}
