<?php
namespace App\Containers\Teams\Tasks;

use Illuminate\Support\Facades\DB;
use App\Containers\Folders\Models\Folder;
use App\Containers\Teams\Models\TeamFolderInvitation;
use App\Containers\Teams\Exceptions\DestroyInvitationsException;

class DestroyExistingInvitationsTask
{
    public function __invoke(Folder $folder): void
    {
        try {

            DB::beginTransaction();

            TeamFolderInvitation::where('parent_folder_id', $folder->id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            throw (new DestroyInvitationsException())->debug($e);
        }
    }
}
