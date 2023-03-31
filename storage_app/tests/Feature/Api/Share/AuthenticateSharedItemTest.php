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

class AuthenticateSharedItemTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    /**
     * AuthenticateSharedItemTest.
     *
     * @return void
     */
    public function test_authenticateSharedItemTest()
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

        $password = $this->faker->password;
        
        $shareItemData = [
            'uuid'          =>  'uuid',
            'emails'        =>  [$user->email],
            'isPassword'  =>  1,
            'password'      =>  $password
        ];
        
        $random = rand(1,2);
        
        if($random == 1){
            $shareItemData['item_uuid']  =   $folderData->uuid;
            $shareItemData['type']       =   'folder';
            $shareItemData['permission'] =   'editor';
        } else {
            $shareItemData['item_uuid']  =   $file['data']['items'][0]['data']['uuid'];
            $shareItemData['type']       =   'file';
        }
        
        $sharedItem = $this->post('api/v1/share', $shareItemData);

        $authenticateData = array(
            'password' => $password
        );
        
        $response = $this->post('api/v1/sharing/authenticate/' . $sharedItem['data']['items'][0]['data']['attributes']['token'], $authenticateData);

        $response->assertStatus(204);
    }
}
