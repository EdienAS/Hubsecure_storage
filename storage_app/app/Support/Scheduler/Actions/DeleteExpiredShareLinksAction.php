<?php
namespace App\Support\Scheduler\Actions;

use Carbon\Carbon;
use App\Containers\Share\Models\Share;

class DeleteExpiredShareLinksAction
{
    /**
     * Get and delete expired shared links
     */
    public function __invoke(): void
    {
        Share::whereNotNull('expire_in')
            ->get()
            ->each(function ($share) {
                // Get dates
                $created_at = Carbon::parse($share->created_at);

                // If time was over, then delete share record
                if ($created_at->diffInHours(now()) >= $share->expire_in) {
                    $share->delete();
                }
            });
    }
}
