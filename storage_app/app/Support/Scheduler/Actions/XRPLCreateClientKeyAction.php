<?php
namespace App\Support\Scheduler\Actions;

use App\Containers\User\Models\User;
use App\Containers\UserSettings\Models\Usersetting;
use App\Containers\XRPLBlock\Tasks\XRPLCreateClientKeyTask;

class XRPLCreateClientKeyAction
{
    /**
     * @var  XRPLCreateClientKeyAction
     */
    private $xrplCreateClientKeyTask;
    
    /**
     * XRPLCreateClientKeyAction constructor.
     *
     * @param \App\Containers\XRPLBlock\Tasks\XRPLCreateClientKeyTask     $xrplCreateClientKeyTask
     */
    public function __construct(
        XRPLCreateClientKeyTask $xrplCreateClientKeyTask
    ) {
        
        $this->xrplCreateClientKeyTask = $xrplCreateClientKeyTask;
    }
    
    /**
     * 
     */
    public function __invoke(): void
    {
        $pendingClientKeyUserIds = Usersetting::whereNull('client_encryption_key')->pluck('user_id');
        
        $pendingUsers = User::whereIn('id', $pendingClientKeyUserIds)
                ->select('id','uuid')
                ->get();
        
        ($this->xrplCreateClientKeyTask)($pendingUsers);
    }
}
