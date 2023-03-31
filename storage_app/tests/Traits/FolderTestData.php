<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\WithFaker;

trait FolderTestData
{
    use WithFaker;
    /**
     * @before
     */
    public function folderTestData($parentFolderId = null)
    {
        $data = [
            'uuid'        =>  'uuid',
            'parent_folder_id'   =>  $parentFolderId,
            'name'        =>  'testFolderName',
            'color'       =>  'testColor',
            'emoji'       =>  'testEmoji',
        ];
        
        return $data;

    }

}