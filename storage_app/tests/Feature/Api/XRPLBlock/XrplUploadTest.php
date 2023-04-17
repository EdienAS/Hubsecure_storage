<?php

namespace Tests\Feature\Api\XRPLBlock;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use App\Traits\StorageDiskTrait;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use App\Containers\Files\Models\File;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Support\Facades\Storage;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class XrplUploadTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData, 
            StorageDiskTrait;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_xrplUploadTest()
    {$user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $folderId = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->pluck('id')->first();
        
//        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file,
            'parent_folder_id' =>  $folderId
        ];
        
        $file = $this->post('api/v1/upload/file', $uploadFileData);
        
        $this->post('api/v1/xrpl/upload/' . $file['data']['items'][0]['data']['uuid'])->assertStatus(200);
    }
}
