<?php

namespace Tests\Feature\Api\Search;

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

class SearchTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserSettingsTestData, FolderTestData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_searchTest()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );
        
        $this->userSettingsTestData($user->id);
        
        $testData = $this->folderTestData();
        
        $this->post('api/v1/folder', $testData);
        
        
        $folder = Folder::where('user_id', $user->id)->first();
        
        Storage::fake('local');
        
        $file[] = UploadedFile::fake()->createWithContent('document.pdf', 100);
        
        $uploadFileData = [
            'uuid'  =>  'uuid',
            'files' =>  $file
        ];
        
        $this->post('api/v1/upload/file', $uploadFileData);
        
        $file = File::where('user_id', $user->id)->first();
        
        $this->get('api/v1/search?query=' . $folder->name)
                ->assertStatus(200);
        
        $this->get('api/v1/search?query=' . $file->name)
                ->assertStatus(200);
    }
}
