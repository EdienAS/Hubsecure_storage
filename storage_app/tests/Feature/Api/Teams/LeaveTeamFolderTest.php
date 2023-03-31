<?php

namespace Tests\Feature\Api\Teams;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\TeamFolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveTeamFolderTest extends TestCase
{
    use RefreshDatabase, WithFaker, TeamFolderTestData, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_leaveTeamFolderTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->createTeamFolderTestData();
        
        $teamFolder = $this->post('api/v1/teams/folders', $data);
        
        $this->delete('api/v1/teams/folders/' . $teamFolder['data']['uuid'] . '/leave')
                ->assertStatus(204);

    }
}
