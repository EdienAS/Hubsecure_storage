<?php

namespace Tests\Feature\Api\Teams;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\TeamFolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListTeamInvitationTest extends TestCase
{
    use RefreshDatabase, WithFaker, TeamFolderTestData, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_listTeamInvitationTest()
    {
        $admin = Passport::actingAs(
            User::factory()->create(['role_id' => 1])
        );
        
        $this->userSettingsTestData($admin->id);
        
        $user = Passport::actingAs(
            User::factory()->create(['role_id' => 2])
        );
        
        $data = $this->createTeamFolderTestData($user->email);
        
        $this->actingAs($admin)->post('api/v1/teams/folders', $data);
        
        $this->actingAs($user)->get('api/v1/teams/invitations')
                ->assertStatus(200);
        
        $this->actingAs($user)->get('api/v1/teams/invitations?orderBy=desc&limit=5')
                ->assertStatus(200);
        
        $this->actingAs($user)->get('api/v1/teams/invitations?type=sent&orderBy=desc&limit=5')
                ->assertStatus(200);
    }
}
