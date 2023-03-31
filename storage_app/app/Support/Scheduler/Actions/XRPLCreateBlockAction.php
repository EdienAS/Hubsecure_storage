<?php
namespace App\Support\Scheduler\Actions;

use App\Containers\XRPLBlock\Models\XrplBlockDocument;
use App\Containers\XRPLBlock\Tasks\XRPLCreateBlockTask;

class XRPLCreateBlockAction
{
    /**
     * @var  XRPLCreateBlockTask
     */
    private $xrplCreateBlockTask;
    
    /**
     * XRPLCreateBlockAction constructor.
     *
     * @param \App\Containers\XRPLBlock\Tasks\XRPLCreateBlockTask     $xrplCreateBlockTask
     */
    public function __construct(
        XRPLCreateBlockTask $xrplCreateBlockTask
    ) {
        
        $this->xrplCreateBlockTask = $xrplCreateBlockTask;
    }
    
    /**
     * 
     */
    public function __invoke(): void
    {
        $pendingXrplDocuments = XrplBlockDocument::recordsOlderThan(5)
                ->whereNot('status', config('constants.xrpl_block.status.compleated'))
                ->select('id','uuid')
                ->get();
        
        ($this->xrplCreateBlockTask)($pendingXrplDocuments);
    }
}
