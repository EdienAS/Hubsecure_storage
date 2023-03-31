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

class UpdateFileTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * UpdateFileTest.
     *
     * @return void
     */
    public function test_updateFile()
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
        
        $fileData = File::where('user_id', $user->id)->select('uuid', 'file_storage_option_id')->first();
        
        $data = [
            '_method'   =>  'patch',
            'name'      =>  $this->faker->lexify('????')
        ];

        $response = $this->patch('api/v1/file/' . $fileData->uuid, $data);
        
            if($fileData->file_storage_option_id == 1){
            $response->assertStatus(200);
        } else {
            
            $response->assertStatus(403);
        }
    }
}
