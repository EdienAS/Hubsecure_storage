<?php
namespace App\Containers\Teams\Tasks;

use Illuminate\Support\Facades\DB;
use App\Containers\Folders\Models\Folder;
use App\Containers\Teams\Models\TeamFolderMember;
use App\Containers\Teams\Exceptions\DestroyAttachedMembersException;

class DestroyAttachedMembersTask
{
    public function __invoke(Folder $folder): void
    {
        try {

            DB::beginTransaction();

            TeamFolderMember::where('parent_folder_id', $folder->id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            throw (new DestroyAttachedMembersException())->debug($e);
        }
    }
}
