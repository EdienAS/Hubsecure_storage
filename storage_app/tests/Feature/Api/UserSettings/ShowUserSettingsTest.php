<?php

namespace Tests\Feature\Api\UserSettings;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUserSettingsTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_showUserSettingsTest()
    {
        $user = Passport::actingAs(
            User::factory()->create(['role_id' => 2])
        );
        
        $uuid = $user->uuid;
                
            $this->userSettingsTestData($user->id);
        
        $response = $this->get('api/v1/usersettings/' . $uuid);

        $response->assertStatus(200);
    }
}
