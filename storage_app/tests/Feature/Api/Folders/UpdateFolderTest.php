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

class UpdateFolderTest extends TestCase
{
    use RefreshDatabase, WithFaker, FolderTestData, UserSettingsTestData;
    /**
     * UpdateFolderTest.
     *
     * @return void
     */
    public function test_updateFolder()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $this->post('api/v1/folder', $data);
        
        
        $uuid = Folder::where('user_id', $user->id)
                ->pluck('uuid')->first();
        
        $updateData = [
            '_method'   =>  'patch',
            'name'      =>  $this->faker->lexify('????')
        ];
        
        $response = $this->patch('api/v1/folder/' . $uuid, $updateData);

        $response->assertStatus(200);
    }
}
