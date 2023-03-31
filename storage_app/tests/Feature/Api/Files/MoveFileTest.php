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

class MoveFileTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    /**
     * MoveFileTest.
     *
     * @return void
     */
    public function test_moveFile()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $testData = $this->folderTestData();
        
        $this->post('api/v1/folder', $testData);
        
        
        $parentFolderId = Folder::where('user_id', $user->id)
                ->pluck('id')->first();
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file
        ];
        
        $this->post('api/v1/upload/file', $uploadFileData);
        
        $fileUuid = File::where('user_id', $user->id)->pluck('uuid')->first();
        
        $data = [
            '_method'   =>  'patch',
            'parent_folder_id'      =>  $parentFolderId
        ];
        
        $response = $this->patch('api/v1/movefile/' . $fileUuid, $data);

        $response->assertStatus(200);
    }
}
