<?php

namespace Tests\Feature\Api\UserSettings;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetUserAvatarTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getUserAvatarTest()
    {
        $user = Passport::actingAs(
            User::factory()->create(['role_id' => 2])
        );
        
        $uuid = $user->uuid;
        
        $updateUserSettingsData = [
            '_method' => 'patch',
            'uuid' => 'uuid',
            'file_storage_option_id' => 1,
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ];
        
        $this->userSettingsTestData($user->id);
        
        $this->patch('api/v1/usersettings/' . $uuid, $updateUserSettingsData);
        
        $avatarUrl = User::where('uuid', $uuid)->first()->avatar_url;
        
        foreach($avatarUrl as $url){
            
            $this->get($url)->assertStatus(200);
        }

    }
}
