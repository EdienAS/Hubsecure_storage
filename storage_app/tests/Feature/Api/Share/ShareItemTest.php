<?php

namespace Tests\Feature\Api\Share;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Support\Facades\Storage;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShareItemTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    /**
     * ShareItemTest.
     *
     * @return void
     */
    public function test_shareItemTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $folderData = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->select('id', 'uuid')->first();
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file,
            'parent_folder_id' =>  $folderData->id
        ];
        
        $file = $this->post('api/v1/upload/file', $uploadFileData);

        $shareItemData = [
            'uuid'          =>  'uuid',
            'emails'        =>  [$user->email],
            'is_protected'  =>  1,
            'password'      =>  $this->faker->password
        ];
        
        $random = rand(1,2);
        
        if($random == 1){
            $shareItemData['item_uuid']  =   $folderData->uuid;
            $shareItemData['type']       =   'folder';
            $shareItemData['permission'] =   'editor';
        } else {
            $shareItemData['item_uuid']  =   $file['data']['items'][0]['data']['uuid'];
            $shareItemData['type']       =   'file';
            $shareItemData['permission'] =   'visitor';
        }
        
        $response = $this->post('api/v1/share', $shareItemData);

        $response->assertStatus(200);
    }
}
