<?php

namespace Tests\Feature\Api\Share;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Tests\Traits\FolderTestData;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use App\Containers\Files\Models\File;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Support\Facades\Storage;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Containers\XRPLBlock\Tasks\XRPLUpdateBlockStatusTask;

class GetDetailsDownloadSharedItemTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    
    /**
     * GetDetailsDownloadSharedItemFileTest.
     *
     * @return void
     */
    public function test_getDetailsDownloadSharedItemFileTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $folderData = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->select('id', 'uuid')->first();
        
//        Storage::fake('local');
        
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
        
        $shareItemData['item_uuid']  =   $file['data']['items'][0]['data']['uuid'];
        $shareItemData['type']       =   'file';

        $sharedItem = $this->post('api/v1/share', $shareItemData);

        $cookie = ['share_session' => json_encode([
                'token'         => $sharedItem['data']['items'][0]['data']['attributes']['token'],
                'authenticated' => true,
            ])];
        
        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'])
                ->assertStatus(200);

        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . ''
                        . '?orderBy=desc&limit=2')
                ->assertStatus(200);
        
        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . 
                        '?download=1')->assertStatus(200);
        
        $this->post('api/v1/xrpl/upload/' . $file['data']['items'][0]['data']['uuid']);
        
        $newFileData = File::where('user_id', $user->id)->first();
        
        sleep(30);
        
        resolve(XRPLUpdateBlockStatusTask::class)(array($newFileData->xrplBlockDocument));
                
        sleep(5);
        
        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . 
                        '?download=1')->assertStatus(200);
        
        
    }
    
    /**
     * GetDetailsDownloadSharedItemFolderTest.
     *
     * @return void
     */
    public function test_getDetailsDownloadSharedItemFolderTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $folderData = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->select('id', 'uuid')->first();
        
//        Storage::fake('local');
        
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
        $shareItemData['permission'] =   'editor';

        $sharedItem = $this->post('api/v1/share', $shareItemData);

        $cookie = ['share_session' => json_encode([
                'token'         => $sharedItem['data']['items'][0]['data']['attributes']['token'],
                'authenticated' => true,
            ])];
        
        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'])
                ->assertStatus(200);

        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . ''
                        . '?orderBy=desc&limit=2')
                ->assertStatus(200);
        
        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . 
                        '?folderUuid=' . $folderData->uuid)->assertStatus(200);

        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . 
                        '?folderUuid=' . $folderData->uuid . '&orderBy=desc&limit=2')
                ->assertStatus(200);
        
        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . 
                        '?folderUuid=' . $folderData->uuid . '&download=1')
                ->assertStatus(200);
        
        $this->post('api/v1/xrpl/upload/' . $file['data']['items'][0]['data']['uuid']);
        
        $newFileData = File::where('user_id', $user->id)->first();
        
        sleep(30);
        
        resolve(XRPLUpdateBlockStatusTask::class)(array($newFileData->xrplBlockDocument));
                
        sleep(5);
        
        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/item/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . 
                        '?folderUuid=' . $folderData->uuid . '&download=1')
                ->assertStatus(200);
        
        
    }
}
