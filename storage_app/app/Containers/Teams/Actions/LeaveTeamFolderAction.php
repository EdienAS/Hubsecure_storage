<?php

namespace App\Containers\Teams\Actions;

use App\Abstracts\Action;
use App\Containers\Folders\Models\Folder;
use App\Containers\Teams\Tasks\DestroyTeamFolderMemberTask;

/**
 * Class LeaveTeamFolderAction.
 *
 */
class LeaveTeamFolderAction extends Action
{

    /**
     * @var  \App\Containers\Teams\Tasks\DestroyTeamFolderMemberTask
     */
    private $destroyTeamFolderMemberTask;

    /**
     * ConvertFolderAction constructor.
     *
     * @param \App\Containers\Teams\Tasks\DestroyTeamFolderMemberTask     $destroyTeamFolderMemberTask
     */
    public function __construct(DestroyTeamFolderMemberTask $destroyTeamFolderMemberTask
    ) {
        
        $this->destroyTeamFolderMemberTask = $destroyTeamFolderMemberTask;
    }
    
    
    /**
     * @param $request
     *
     * @return true
     */
    public function run($request)
    {
        // Find and delete attached member from team folder
        $this->destroyTeamFolderMemberTask->run(Folder::where('uuid', $request->uuid)->first());
        
        return true;
    }
}
