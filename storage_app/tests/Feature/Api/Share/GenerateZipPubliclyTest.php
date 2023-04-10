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

class GenerateZipPubliclyTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    /**
     * GenerateZipPubliclyTest.
     *
     * @return void
     */
    public function test_generateZipPubliclyTest()
    {
        $queryParams = null;
        
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $data = $this->folderTestData();
        
        $folder = $this->post('api/v1/folder', $data);
        
        $folderData = Folder::where('uuid', $folder['data']['items'][0]['data']['uuid'])
                ->select('id','uuid')->first();
        
        $queryParams .= $folderData->uuid . '|folder,';
        
//        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->image('avatar.jpg');
//        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
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
        
        
        $fileData = array();
        foreach($file['data']['items'] as $singleFile){
            $fileData[] = $singleFile['data']['uuid'] . '|file';
        }
        
        $queryParams .= implode(',' , $fileData);
        
        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/zip/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . '?items=' . $queryParams)
                ->assertStatus(200);

        $this->post('api/v1/xrpl/upload/' . $file['data']['items'][0]['data']['uuid']);
        
        $newFileData = File::where('user_id', $user->id)->first();
        
        sleep(30);
        
        resolve(XRPLUpdateBlockStatusTask::class)(array($newFileData->xrplBlockDocument));
                
        sleep(5);
        
        
        $this->withUnencryptedCookies($cookie)
                ->get('api/v1/sharing/zip/' . $sharedItem['data']['items'][0]['data']['attributes']['token'] . '?items=' . $queryParams)
                ->assertStatus(200);
        
    }
}
