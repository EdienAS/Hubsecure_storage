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

class ListTrashedFolderTest extends TestCase
{
    use RefreshDatabase, WithFaker, FolderTestData, UserSettingsTestData;
    /**
     * ListTrashedFolderTest.
     *
     * @return void
     */
    public function test_listTrashedFolders()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $this->post('api/v1/folder', $data);
        
        
        $uuid = Folder::where('user_id', $user->id)
                ->pluck('uuid')->first();
        
        $this->delete('api/v1/trashfolder/' . $uuid);

        $response = $this->get('api/v1/trashedfolders');

        $response->assertStatus(200);
    }
}
