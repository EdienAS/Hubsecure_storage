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

class GetThumbnailSharedItemPubliclyTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getThumbnailSharedItemPubliclyTest()
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
        
        $file[] = UploadedFile::fake()->image('avatar.jpg');
        
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
        
        foreach($file['data']['items'][0]['data']['attributes']['thumbnail'] as $url){
        $this->withUnencryptedCookies($cookie)
                ->get($url)
                ->assertStatus(200);
        }
        
    }
}
