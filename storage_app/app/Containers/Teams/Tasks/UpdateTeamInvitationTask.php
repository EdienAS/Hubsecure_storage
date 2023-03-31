<?php
namespace App\Containers\Teams\Tasks;

use Illuminate\Support\Facades\DB;
use App\Containers\Teams\Models\TeamFolderInvitation;
use App\Containers\Teams\Exceptions\UpdateTeamInvitationException;

class UpdateTeamInvitationTask
{
    public function __invoke($data ,TeamFolderInvitation $invitation): void
    {
        try{
            
            DB::beginTransaction();
               $invitation->update($data);
            DB::commit();
            
        } catch (\Exception $e) {
            throw (new UpdateTeamInvitationException())->debug($e);
        }
    }
}
