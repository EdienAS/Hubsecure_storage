<?php

namespace Tests\Feature\Api\Folders;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListFolderTest extends TestCase
{
    use RefreshDatabase, FolderTestData, UserSettingsTestData;
    /**
     * ListFolderTest.
     *
     * @return void
     */
    public function test_listFolder()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $this->post('api/v1/folder', $data);
        
        $response = $this->get('api/v1/folders');

        $response->assertStatus(200);
    }
}
