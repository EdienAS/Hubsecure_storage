<?php

namespace Tests\Feature\Api\Zip;

use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Support\Facades\Storage;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateZipTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    /**
     * GenerateZipTest.
     *
     * @return void
     */
    public function test_generateZip()
    {
        $queryParams = null;
        
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $folderData = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->select('id','uuid')->first();
        
        $queryParams .= $folderData->uuid . '|folder,';
        
        Storage::fake('local');
        
//        $file[] = UploadedFile::fake()->image('avatar.jpg');
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file,
            'parent_folder_id' =>  $folderData->id
        ];
        
        $file = $this->post('api/v1/upload/file', $uploadFileData);
        
        $fileData = array();
        foreach($file['data']['items'] as $file){
            $fileData[] = $file['data']['uuid'] . '|file';
        }
        
        $queryParams .= implode(',' , $fileData);
        
        $response = $this->get('api/v1/zip?items=' . $queryParams);

        $response->assertStatus(200);
    }
}
