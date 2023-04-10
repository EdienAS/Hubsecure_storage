<?php

namespace Tests\Feature\Api\Zip;

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
use App\Containers\XRPLBlock\Tasks\XRPLUpdateBlockStatusTask;

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
        
//        Storage::fake('local');
        
//        $file[] = UploadedFile::fake()->image('avatar.jpg');
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file,
            'parent_folder_id' =>  $folderData->id
        ];
        
        $file = $this->post('api/v1/upload/file', $uploadFileData);
        
        $fileData = array();
        foreach($file['data']['items'] as $singleFile){
            $fileData[] = $singleFile['data']['uuid'] . '|file';
        }
        
        $queryParams .= implode(',' , $fileData);
        
        $this->get('api/v1/zip?items=' . $queryParams)->assertStatus(200);

        $this->post('api/v1/xrpl/upload/' . $file['data']['items'][0]['data']['uuid']);
        
        $newFileData = File::where('user_id', $user->id)->first();
        
        sleep(30);
        
        resolve(XRPLUpdateBlockStatusTask::class)(array($newFileData->xrplBlockDocument));
                
        sleep(5);
        
        $this->get('api/v1/zip?items=' . $queryParams)->assertStatus(200);
        
    }
}
