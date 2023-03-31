<?php

namespace Tests\Feature\Api\Browse;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrowseTrashedFoldersTest extends TestCase
{
    use RefreshDatabase, WithFaker, FolderTestData, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_BrowseTrashedFoldersTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $this->post('api/v1/folder', $data);
        
        $uuid = Folder::where('user_id', $user->id)
                ->pluck('uuid')->first();
        
        $shareItemData = [
            'uuid'          =>  'uuid',
            'item_uuid'     =>  $uuid,
            'type'          =>  'folder',
            'permission'    =>  'editor',
            'emails'        =>  [$user->email],
            'is_protected'  =>  1,
            'password'      =>  $this->faker->password
        ];
        
        $this->post('api/v1/share', $shareItemData);
        
        $this->delete('api/v1/trashfolder/' . $uuid);

        $this->get('api/v1/browse/trash?page=1')->assertStatus(200);

    }
}
