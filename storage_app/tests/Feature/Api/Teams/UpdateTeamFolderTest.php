<?php

namespace Tests\Feature\Api\Teams;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\TeamFolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

    class UpdateTeamFolderTest extends TestCase
{
    use RefreshDatabase, WithFaker, TeamFolderTestData, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_updateTeamFolderTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->createTeamFolderTestData();
        
        $teamFolder = $this->post('api/v1/teams/folders', $data);
        
        $updateData = $this->updateTeamFolderTestData($user->id);
        
        $this->post('api/v1/teams/folders/' . $teamFolder['data']['uuid'], $updateData)
                ->assertStatus(200);
    }
}
