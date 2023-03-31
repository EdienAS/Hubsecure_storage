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

class UpdateSharedItemPubliclyTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    
    /**
     * UpdateSharedItemFilePubliclyTest.
     *
     * @return void
     */
    public function test_updateSharedItemFilePubliclyTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $folder = $this->post('api/v1/folder', $this->folderTestData());
        
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

        $password = $this->faker->password;
        
        $shareItemData = [
            'uuid'          =>  'uuid',
            'emails'        =>  [$user->email],
            'isPassword'  =>  1,
            'password'      =>  $password
        ];

        $shareItemData['item_uuid']  =   $folderData->uuid;
        $shareItemData['type']       =   'folder';
        $shareItemData['permission'] =   'visitor';

        $sharedItem = $this->post('api/v1/share', $shareItemData);
        
        $cookie = ['share_session' => json_encode([
                'token'         => $sharedItem['data']['items'][0]['data']['attributes']['token'],
                'authenticated' => true,
            ])];
        
        $updateSharedItem = [
            '_method' => 'patch',
            'type' => 'file',
            'name' => $this->faker->lexify('????')
        ];
        
        $this->withUnencryptedCookies($cookie)
                ->patch('api/v1/sharing/update/' . $file['data']['items'][0]['data']['id'] . '/' . $sharedItem['data']['items'][0]['data']['attributes']['token'], $updateSharedItem)
                ->assertStatus(403);
        
        $deleteData = [
          '_method' =>  'delete',
          'tokens'   =>  [$sharedItem['data']['items'][0]['data']['attributes']['token']]
        ];
        
        $this->delete('api/v1/share', $deleteData);
        
        $shareItemData['permission'] =   'editor';
        
        $sharedItem = $this->post('api/v1/share', $shareItemData);
        
        $cookie = ['share_session' => json_encode([
                'token'         => $sharedItem['data']['items'][0]['data']['attributes']['token'],
                'authenticated' => true,
            ])];
        
        $this->withUnencryptedCookies($cookie)
                ->patch('api/v1/sharing/update/' . $file['data']['items'][0]['data']['id'] . '/' . $sharedItem['data']['items'][0]['data']['attributes']['token'], $updateSharedItem)
                ->assertStatus(204);
    }
    
    
    /**
     * UpdateSharedItemFolderPubliclyTest.
     *
     * @return void
     */
    public function test_updateSharedItemFolderPubliclyTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $folder = $this->post('api/v1/folder', $this->folderTestData());
        
        $folderData = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->select('id', 'uuid')->first();
        
        $subFolder = $this->post('api/v1/folder', $this->folderTestData($folderData->id));
        
        $password = $this->faker->password;
        
        $shareItemData = [
            'uuid'          =>  'uuid',
            'emails'        =>  [$user->email],
            'isPassword'  =>  1,
            'password'      =>  $password
        ];

        $shareItemData['item_uuid']  =   $folderData->uuid;
        $shareItemData['type']       =   'folder';
        $shareItemData['permission'] =   'visitor';

        $sharedItem = $this->post('api/v1/share', $shareItemData);
        
        $cookie = ['share_session' => json_encode([
                'token'         => $sharedItem['data']['items'][0]['data']['attributes']['token'],
                'authenticated' => true,
            ])];
        
        $updateSharedItem = [
            '_method' => 'patch',
            'type' => 'folder',
            'name' => $this->faker->lexify('????')
        ];
        
        $this->withUnencryptedCookies($cookie)
                ->patch('api/v1/sharing/update/' . $subFolder['data']['items'][0]['data']['id'] . '/' . $sharedItem['data']['items'][0]['data']['attributes']['token'], $updateSharedItem)
                ->assertStatus(403);
        
        $deleteData = [
          '_method' =>  'delete',
          'tokens'   =>  [$sharedItem['data']['items'][0]['data']['attributes']['token']]
        ];
        
        $this->delete('api/v1/share', $deleteData);
        
        $shareItemData['permission'] =   'editor';
        
        $sharedItem = $this->post('api/v1/share', $shareItemData);
        
        $cookie = ['share_session' => json_encode([
                'token'         => $sharedItem['data']['items'][0]['data']['attributes']['token'],
                'authenticated' => true,
            ])];
        
        $this->withUnencryptedCookies($cookie)
                ->patch('api/v1/sharing/update/' . $subFolder['data']['items'][0]['data']['id'] . '/' . $sharedItem['data']['items'][0]['data']['attributes']['token'], $updateSharedItem)
                ->assertStatus(204);
    }
}
