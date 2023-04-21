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

class UploadFilesFoldersSharedItemPubliclyTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    
    /**
     * UploadFilesSharedItemPubliclyTest.
     *
     * @return void
     */
    public function test_uploadFilesSharedItemPubliclyTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $folder = $this->post('api/v1/folder', $this->folderTestData());
        
        $folderData = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->select('id', 'uuid')->first();
        
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
        
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->image('avatar.jpg');
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadData = [
            'uuid' => 'uuid',
            'files' => $file,
            'parent_folder_id' => $folderData->id
        ];
        
        $this->withUnencryptedCookies($cookie)
                ->post('api/v1/sharing/upload/' . $sharedItem['data']['items'][0]['data']['attributes']['token'], $uploadData)
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
                ->post('api/v1/sharing/upload/' . $sharedItem['data']['items'][0]['data']['attributes']['token'], $uploadData)
                ->assertStatus(201);
    }
    
    /**
     * UploadFilesFoldersChunksSharedItemPubliclyTest.
     *
     * @return void
     */
    public function test_uploadFilesFoldersChunkSharedItemPubliclyTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $folder = $this->post('api/v1/folder', $this->folderTestData());
        
        $folderData = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->select('id', 'uuid')->first();
        
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
        
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->image('avatar.jpg');
        
        $uploadChunksData = [
            'uuid' => 'uuid',
            'files' => $file,
            'parent_folder_id' => $folderData->id,
            'path' => '/testchunk/' . $file[0]->getClientOriginalName(),
            'is_last_chunk' => 1,
            'extension' => explode('.', $file[0]->getClientOriginalName())[1]
        ];
        
        $this->withUnencryptedCookies($cookie)
                ->post('api/v1/sharing/upload/chunks/' . $sharedItem['data']['items'][0]['data']['attributes']['token'], $uploadChunksData)
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
                ->post('api/v1/sharing/upload/chunks/' . $sharedItem['data']['items'][0]['data']['attributes']['token'], $uploadChunksData)
                ->assertStatus(201);
    }
}
