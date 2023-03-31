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

class RestoreFileTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * RestoreFileTest.
     *
     * @return void
     */
    public function test_restoreFiles()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->image('avatar.jpg');
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file
        ];
        
        $this->post('api/v1/upload/file', $uploadFileData);
        
        $files = File::where('user_id', $user->id)->select('uuid')->get();
        
        $items = array();
        
        foreach($files as $key => $file){
        $this->delete('api/v1/trashfile/' . $file->uuid);
            $items[$key]['type'] = 'file';
            $items[$key]['uuid'] = $file->uuid;
        }

        $restoreData = [
            '_method'   =>  'patch',
            'items'     =>  $items
            
        ];
        
        $response = $this->post('api/v1/restorefiles', $restoreData);

        $response->assertStatus(204);
    }
}
