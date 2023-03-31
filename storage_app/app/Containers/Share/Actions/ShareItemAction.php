<?php

namespace App\Containers\Share\Actions;

use App\Abstracts\Action;
use App\Containers\Share\Tasks\ShareItemTask;
use App\Containers\Share\Tasks\ShareItemSendViaEmailTask;

/**
 * Class ShareItemAction.
 *
 */
class ShareItemAction extends Action
{
    /**
     * @var  \App\Containers\Share\Tasks\ShareItemTask
     * @var  \App\Containers\Share\Tasks\ShareItemSendViaEmailTask
     */
    private $shareItemTask;
    private $shareItemSendViaEmailTask;

    /**
     * GetFileAction constructor.
     *
     * @param \App\Containers\Share\Tasks\ShareItemTask     $shareItemTask
     * @param \App\Containers\Share\Tasks\ShareItemSendViaEmailTask     $shareItemSendViaEmailTask
     */
    public function __construct(ShareItemTask $shareItemTask,
            ShareItemSendViaEmailTask $shareItemSendViaEmailTask)
    {
        $this->shareItemTask = $shareItemTask;
        $this->shareItemSendViaEmailTask = $shareItemSendViaEmailTask;

    }
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        // Share items
        $shared = $this->shareItemTask->run($request);
        
        // Send shared link via email
        if ($request->has('emails')) {
            ($this->shareItemSendViaEmailTask)->execute(
                emails: $request->input('emails'),
                token: $shared->token,
                user: $shared->user,
            );
        }

        return array('items' => array($shared));
    }
}
