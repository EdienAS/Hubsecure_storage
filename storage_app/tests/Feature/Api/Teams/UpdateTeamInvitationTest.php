<?php

namespace Tests\Feature\Api\Teams;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\TeamFolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTeamInvitationTest extends TestCase
{
    use RefreshDatabase, WithFaker, TeamFolderTestData, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_updateTeamInvitationTest()
    {
        $admin = Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $this->userSettingsTestData($admin->id);
        
        $user = Passport::actingAs(
            User::factory()->create(['role_id' => 2])
        );
        
        $data = $this->createTeamFolderTestData($user->email);
        
        $teamFolder = $this->actingAs($admin)->post('api/v1/teams/folders', $data);
        
        $this->actingAs($user)->patch('api/v1/teams/invitations/' . $teamFolder['data']['teamInvitations'][0]['uuid'])
                ->assertStatus(200);
        
    }
}
