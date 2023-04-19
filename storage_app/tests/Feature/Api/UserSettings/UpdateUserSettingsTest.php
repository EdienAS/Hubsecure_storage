<?php

namespace Tests\Feature\Api\UserSettings;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserSettingsTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_updateUserSettingsTest()
    {
        $user = Passport::actingAs(
            User::factory()->create(['role_id' => 2])
        );
        
        $uuid = $user->uuid;
        
        $updateUserSettingsData = [
            '_method' => 'patch',
            'uuid' => 'uuid',
            'file_storage_option_id' => 1,
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => rand(100000, 999999),
            'country' => $this->faker->country(),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'timezone' => rand(-12, 12)
        ];
        
            $this->userSettingsTestData($user->id);
        
        
        $response = $this->patch('api/v1/usersettings/' . $uuid, $updateUserSettingsData);
        
        $response->assertStatus(204);
    }
}
