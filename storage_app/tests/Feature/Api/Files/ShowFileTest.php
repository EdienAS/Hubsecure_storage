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

class ShowFileTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * ShowFileTest.
     *
     * @return void
     */
    public function test_showFile()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file
        ];
        
        $this->post('api/v1/upload/file', $uploadFileData);
        
        $fileUuid = File::where('user_id', $user->id)->pluck('uuid')->first();
        
        $response = $this->get('api/v1/file/' . $fileUuid);

        $response->assertStatus(200);
    }
}
