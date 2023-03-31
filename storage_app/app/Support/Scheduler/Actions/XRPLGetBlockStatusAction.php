<?php
namespace App\Support\Scheduler\Actions;

use App\Containers\XRPLBlock\Models\XrplBlockDocument;
use App\Containers\XRPLBlock\Tasks\XRPLUpdateBlockStatusTask;

class XRPLGetBlockStatusAction
{
    /**
     * @var  XRPLGetBlockStatusAction
     */
    private $xrplUpdateBlockStatusTask;
    
    /**
     * XRPLGetBlockStatusAction constructor.
     *
     * @param \App\Containers\XRPLBlock\Tasks\XRPLUpdateBlockStatusTask     $xrplUpdateBlockStatusTask
     */
    public function __construct(
        XRPLUpdateBlockStatusTask $xrplUpdateBlockStatusTask
    ) {
        
        $this->xrplUpdateBlockStatusTask = $xrplUpdateBlockStatusTask;
    }
    
    /**
     * C
     */
    public function __invoke(): void
    {
        $processingXrplDocuments = XrplBlockDocument::recordsOlderThan(1)
                ->where('status', 'processing')->select('id','uuid')
                ->get();

        ($this->xrplUpdateBlockStatusTask)($processingXrplDocuments);
    }
}
