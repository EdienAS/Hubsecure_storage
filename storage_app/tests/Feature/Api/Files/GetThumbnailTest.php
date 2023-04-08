<?php

namespace Tests\Feature\Api\Files;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use App\Containers\Files\Models\File;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetThumbnailTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getThumbnailTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->image('avatar.jpg');
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file
        ];
        
        $this->post('api/v1/upload/file', $uploadFileData);
        
        $fileUuid = File::where('user_id', $user->id)->pluck('uuid')->first();
        
        $fileData = $this->get('api/v1/file/' . $fileUuid);
        
        $this->get($fileData['data']['items'][0]['data']['attributes']['thumbnail']['sm'])->assertStatus(200);
        
        $this->get($fileData['data']['items'][0]['data']['attributes']['thumbnail']['xs'])->assertStatus(200);
    }
}
