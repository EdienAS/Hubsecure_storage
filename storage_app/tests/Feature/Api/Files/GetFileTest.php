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

class GetFileTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * GetFileTest.
     *
     * @return void
     */
    public function test_getFile()
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
        
        $fileData = File::where('user_id', $user->id)->first();

        $response = $this->get($fileData->file_url);

        $response->assertStatus(200);
    }
}
