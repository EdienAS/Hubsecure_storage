<?php

namespace Tests\Feature\Api\Files;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use App\Containers\Files\Models\File;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrashFileTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * TrashFileTest.
     *
     * @return void
     */
    public function test_trashFile()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file
        ];
        
        $this->post('api/v1/upload/file', $uploadFileData);
        
        $fileData = File::where('user_id', $user->id)->select('uuid', 'file_storage_option_id')->first();
        
        $shareItemData = [
            'uuid'          =>  'uuid',
            'item_uuid'     =>  $fileData->uuid,
            'type'          =>  'file',
            'permission'    =>  'visitor',
            'emails'        =>  [$user->email],
            'is_protected'  =>  1,
            'password'      =>  $this->faker->password
        ];
        
        $this->post('api/v1/share', $shareItemData);
        
        $response = $this->delete('api/v1/trashfile/' . $fileData->uuid);

        $response->assertStatus(204);
    }
}
