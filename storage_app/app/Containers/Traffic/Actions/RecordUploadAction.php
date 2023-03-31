<?php
namespace App\Containers\Traffic\Actions;

use App\Containers\Traffic\Models\Traffic;

class RecordUploadAction
{
    /**
     * Record user upload filesize
     */
    public function __invoke(
        int $file_size,
        int $user_id,
    ) {
        $record = Traffic::currentDay()
            ->firstOrCreate([
                'user_id' => $user_id,
            ],[
                'upload'=> $file_size
            ]);
        
        $record->increment('upload', $file_size);
    }
}
