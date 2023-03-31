<?php
namespace App\Containers\Traffic\Actions;

use App\Containers\Traffic\Models\Traffic;

class RecordDownloadAction
{
    /**
     * Record user download filesize
     */
    public function __invoke(
        int $file_size,
        int $user_id,
    ): void {
        $record = Traffic::currentDay()
            ->firstOrCreate([
                'user_id' => $user_id,
            ],[
                'download'=> $file_size
            ]);

        $record->increment('download', $file_size);
    }
}
