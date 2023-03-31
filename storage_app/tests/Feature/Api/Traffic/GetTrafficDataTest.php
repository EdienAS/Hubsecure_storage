<?php

namespace Tests\Feature\Api\Traffic;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use App\Containers\User\Models\User;
use App\Containers\Files\Models\File;
use Tests\Traits\UserSettingsTestData;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetTrafficDataTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getTrafficDataTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        Storage::fake('public');
        
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file
        ];
        
        $this->post('api/v1/upload/file', $uploadFileData);
        
        $fileData = File::where('user_id', $user->id)->first();

        $this->get($fileData->file_url);

        $this->get('api/v1/traffic/' . $user->uuid . '?duration=day&limit=30')
                ->assertStatus(200);
        $this->get('api/v1/traffic/' . $user->uuid . '?duration=month&limit=12')
                ->assertStatus(200);
        $this->get('api/v1/traffic/' . $user->uuid . '?duration=year&limit=3')
                ->assertStatus(200);

    }
}
