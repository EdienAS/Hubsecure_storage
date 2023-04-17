<?php

namespace App\Containers\XRPLBlock\Actions;

use App\Abstracts\Action;
use App\Containers\Files\Models\File;
use App\Containers\Files\Resources\FileResource;
use App\Containers\XRPLBlock\Tasks\XRPLCreateBlockTask;;
use App\Containers\XRPLBlock\Tasks\StoreFileXRPLBlockTask;

/**
 * Class XrplUploadAction.
 *
 */
class XrplUploadAction extends Action
{
    /*
     * @var
     */
    private $storeFileXRPLBlockTask;
    
    /*
     * @var
     */
    private $xrplCreateBlockTask;
            
    public function __construct(StoreFileXRPLBlockTask $storeFileXRPLBlockTask,
            XRPLCreateBlockTask $xrplCreateBlockTask) {
        
        $this->storeFileXRPLBlockTask = $storeFileXRPLBlockTask;
        $this->xrplCreateBlockTask = $xrplCreateBlockTask;
    }
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $file = File::where('uuid', $request->uuid)->first();


        // Get file path
        $temp = (app()->environment() == 'testing') ? 'testing/' : null;
        $filePath = $temp . "files/$file->user_id/$file->basename";
        
        //XRPL Block
        $xrplBlockDocument = $this->storeFileXRPLBlockTask->run($filePath);



            $file->xrpl_block_document_id = $xrplBlockDocument->id;
            $file->save();


        ($this->xrplCreateBlockTask)(array($file->xrplBlockDocument));
        
        return array('items' => array(new FileResource($file)));
    }
}
