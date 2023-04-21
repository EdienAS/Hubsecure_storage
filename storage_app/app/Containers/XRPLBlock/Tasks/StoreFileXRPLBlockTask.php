<?php

namespace App\Containers\XRPLBlock\Tasks;

use Exception;
use App\Abstracts\Task;
use App\Traits\XRPLBlockTrait;
use Illuminate\Support\Facades\DB;
use App\Containers\XRPLBlock\Models\XrplBlockDocument;
use App\Containers\XRPLBlock\Exceptions\XRPLBlockException;

/**
 * Class StoreFileXRPLBlockTask.
 *
 */
class StoreFileXRPLBlockTask extends Task
{

    use XRPLBlockTrait;
        
    /**
     * @param array $data
     * @param bool  $login
     *
     * @return mixed
     */
    public function run($filepath)
    {        
        try {            
            
            $file = fopen(storage_path('app/public/'). $filepath, 'r');
            
            $uploadRequest = $this->xrplSendRequest(
                            null,
                            'post',
                            config('constants.xrpl_block.endpoints.upload_document'),
                            $file);

            $uploadResponse = json_decode($uploadRequest->getBody())[0];
            
            DB::beginTransaction();

                $xrplData = XrplBlockDocument::create([
                    'uuid' => $uploadResponse->uuid,
                    'name' => $uploadResponse->name,
                    'content_type' => $uploadResponse->content_type,
                    'gen_name' => $uploadResponse->gen_name,
                    'file_size' => $uploadResponse->file_size,
                    'file_sha_hash' => $uploadResponse->file_sha_hash,
                    'status' => $uploadResponse->status,
                    'db_id' => $uploadResponse->db_id,
                    'upload_document_response' => json_encode($uploadResponse)
                ]);
            
            DB::commit();
            
        } catch (Exception $e) {
            throw (new XRPLBlockException())->debug($e);
        }

        return $xrplData;
    }
}
