<?php

namespace Tests\Feature\Api\Browse;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\TeamFolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrowseTeamFoldersTest extends TestCase
{
    use RefreshDatabase, WithFaker, TeamFolderTestData, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_browseTeamFoldersTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->createTeamFolderTestData();
        
        $teamFolder = $this->post('api/v1/teams/folders', $data);
        
        $this->get('api/v1/browse/teams/folders?page=1')->assertStatus(200);
        
        $this->get('api/v1/browse/teams/folders/' . $teamFolder['data']['uuid'] . '?page=1')
                ->assertStatus(200);

    }
}
