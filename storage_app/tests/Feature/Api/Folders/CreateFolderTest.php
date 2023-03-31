<?php

namespace Tests\Feature\Api\Folders;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateFolderTest extends TestCase
{
    use RefreshDatabase, WithFaker, FolderTestData, UserSettingsTestData;
    /**
     * CreateFolderTest.
     *
     * @return void
     */
    public function test_createFolder()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $parentFolderId = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->pluck('id')->first();
        
        $dataTwo = $this->folderTestData($parentFolderId);
        
        $response = $this->post('api/v1/folder', $dataTwo);

        $response->assertStatus(200);
    }
}
