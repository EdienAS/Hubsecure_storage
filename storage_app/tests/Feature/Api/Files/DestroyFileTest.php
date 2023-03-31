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

class DestroyFileTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * DestroyFileTest.
     *
     * @return void
     */
    public function test_destroyFile()
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
        
        $fileUuid = File::where('user_id', $user->id)->pluck('uuid')->first();
        
        $shareItemData = [
            'uuid'          =>  'uuid',
            'item_uuid'     =>  $fileUuid,
            'type'          =>  'file',
            'permission'    =>  'visitor',
            'emails'        =>  [$user->email],
            'is_protected'  =>  1,
            'password'      =>  $this->faker->password
        ];
        
        $this->post('api/v1/share', $shareItemData);
        
        $this->delete('api/v1/trashfile/' . $fileUuid);

        $data = [
            '_method'       =>  'delete',
            'force_delete'  =>  1,
        ];
        
        $response = $this->delete('api/v1/file/' . $fileUuid, $data);

        $response->assertStatus(204);
    }
}
