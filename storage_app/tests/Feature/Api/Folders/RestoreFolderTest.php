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

class RestoreFolderTest extends TestCase
{
    use RefreshDatabase, WithFaker, FolderTestData, UserSettingsTestData;
    /**
     * RestoreFolderTest.
     *
     * @return void
     */
    public function test_restoreFolders()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $this->post('api/v1/folder', $data);
        $this->post('api/v1/folder', $data);
        
        $folders = Folder::where('user_id', $user->id)
                ->select('uuid')->get();
        
        $items = array();
        
        foreach($folders as $key => $folder){
            $this->delete('api/v1/trashfolder/' . $folder->uuid);
            $items[$key]['type'] = 'folder';
            $items[$key]['uuid'] = $folder->uuid;
        }

        $restoreData = [
            '_method'   =>  'patch',
            'items'     =>  $items
            
        ];
        
        $response = $this->patch('api/v1/restorefolders', $restoreData);

        $response->assertStatus(204);
    }
}
