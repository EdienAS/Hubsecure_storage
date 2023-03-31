<?php

namespace Tests\Feature\Api\Browse;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrowseFoldersTest extends TestCase
{
    use RefreshDatabase, WithFaker, FolderTestData, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_browseFoldersTest()
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
        
        $this->patch('api/v1/movefolder/' . $uuid, $updateData);

        $this->get('api/v1/browse/folders?page=1')->assertStatus(200);
        
        $this->get('api/v1/browse/folders?page=1&orderBy=desc&limit=2')
                ->assertStatus(200);
        
        
        $this->get('api/v1/browse/folders/' . $folder->uuid . '?page=1')
                ->assertStatus(200);
        
        $this->get('api/v1/browse/folders/' . $folder->uuid . ''
                . '?page=1&orderBy=desc&limit=2')
                ->assertStatus(200);
        
        
    }
}
