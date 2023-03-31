<?php

namespace Tests\Feature\Api\Browse;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\TeamFolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrowseSharedWithMeTest extends TestCase
{
    use RefreshDatabase, WithFaker, TeamFolderTestData, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_browseSharedWithMeTest()
    {
        $admin = Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $this->userSettingsTestData($admin->id);
        
        $user = Passport::actingAs(
            User::factory()->create(['role_id' => 2])
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->createTeamFolderTestData($user->email);
        
        $teamFolder = $this->actingAs($admin)->post('api/v1/teams/folders', $data);
        
        $temp = $this->actingAs($user)->patch('api/v1/teams/invitations/' . $teamFolder['data']['teamInvitations'][0]['uuid']);
        
        $this->actingAs($user)->get('api/v1/browse/teams/shared-with-me?page=1')
                ->assertStatus(200);
        

    }
}
