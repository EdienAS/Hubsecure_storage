<?php

namespace Tests\Feature\Api\Files;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use App\Containers\Files\Models\File;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Support\Facades\Storage;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadChunkTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    /**
     * UploadChunkTest.
     *
     * @return void
     */
    public function test_uploadChunk()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $folderId = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->pluck('id')->first();
        
//        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->image('avatar.jpg');
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        
        foreach($file as $fileData){
            
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  array($fileData),
            'parent_folder_id' =>  $folderId,
            'path' => '/testchunk/' . $fileData->getClientOriginalName(),
            'is_last_chunk' => 1,
            'extension' => explode('.', $fileData->getClientOriginalName())[1]
        ];
            $response = $this->post('api/v1/upload/chunks', $uploadFileData);
        }

        if(isset($response['data']['items'][0]['data']['uuid']) && !empty($response['data']['items'][0]['data']['uuid'])){
            $response->assertStatus(200);
        } else {
            $this->assertTrue(false);
        }
        
    }
}
