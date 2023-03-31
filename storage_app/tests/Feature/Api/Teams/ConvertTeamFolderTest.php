<?php

namespace Tests\Feature\Api\Teams;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use Tests\Traits\TeamFolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConvertTeamFolderTest extends TestCase
{
    use RefreshDatabase, WithFaker, FolderTestData, UserSettingsTestData, TeamFolderTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_convertTeamFolderTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $teamFolderData = $this->createTeamFolderTestData();
        
        $this->post('api/v1/teams/folders/' . $folder['data']['items'][0]['data']['uuid'] . '/convert', $teamFolderData)
                ->assertStatus(204);

    }
}
