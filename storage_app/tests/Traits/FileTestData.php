<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\WithFaker;

trait FileTestData
{
    use WithFaker;
    /**
     * @before
     */
    public function fileTestData($file, $folderId)
    {
        $data = [
            'uuid'  =>  'uuid',
            'files' =>  $file,
            'parent_folder_id' =>  $folderId
        ];
        
        return $data;

    }

}