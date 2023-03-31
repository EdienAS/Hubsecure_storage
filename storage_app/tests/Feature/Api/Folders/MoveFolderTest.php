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

class MoveFolderTest extends TestCase
{
    use RefreshDatabase, WithFaker, FolderTestData, UserSettingsTestData;
    /**
     * MoveFolderTest.
     *
     * @return void
     */
    public function test_moveFolder()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $this->post('api/v1/folder', $data);
        
        $this->post('api/v1/folder', $data);
        
        $folder = Folder::where('user_id', $user->id)->first();
        
        $uuid = Folder::where('user_id', $user->id)
                ->pluck('uuid')->last();
        
        $updateData = [
            '_method'   =>  'patch',
            'parent_folder_id' =>  $folder->id
        ];
        
        $response = $this->patch('api/v1/movefolder/' . $uuid, $updateData);

        $response->assertStatus(200);
    }
}
