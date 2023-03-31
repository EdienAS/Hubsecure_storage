<?php

namespace App\Containers\Share\Actions;

use App\Containers\Share\Tasks\UpdateShareItemTask;
use App\Abstracts\Action;

/**
 * Class UpdateShareItemAction.
 *
 */
class UpdateShareItemAction extends Action
{
    /**
     * @var  \App\Containers\Share\Tasks\UpdateShareItemTask
     */
    private $updateShareItemTask;

    /**
     * UpdateShareItemAction constructor.
     *
     * @param \App\Containers\Share\Tasks\UpdateShareItemTask     $updateShareItemTask
     */
    public function __construct(UpdateShareItemTask $updateShareItemTask)
    {
        $this->updateShareItemTask = $updateShareItemTask;

    }


    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {

        $data = $request->all();

        $update = $this->updateShareItemTask->run($data, $request->token);
        
        return array('items' => array($update));
    }
}
