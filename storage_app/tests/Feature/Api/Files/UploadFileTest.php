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

class UploadFileTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    /**
     * UploadFileTest.
     *
     * @return void
     */
    public function test_uploadFile()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $folderId = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->pluck('id')->first();
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->image('avatar.jpg');
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file,
            'parent_folder_id' =>  $folderId
        ];
        
        $response = $this->post('api/v1/upload/file', $uploadFileData);

        foreach($response['data']['items'] as $data){
            if($data['data']['attributes']['file_storage_option_id'] == 1){
                $filePath = "testing/files/$user->id/" . $data['data']['attributes']['basename'];
                Storage::disk('public')->assertExists($filePath);
            }
        }
        
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function testFileFactory()
    {
        $file = File::factory()
            ->create();

        $this->assertDatabaseHas('files', [
            'id' => $file->id,
        ]);
    }
}
