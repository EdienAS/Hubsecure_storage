<?php
namespace App\Containers\XRPLBlock\Tasks;

use Storage;
use App\Traits\XRPLBlockTrait;
use Illuminate\Support\Facades\DB;
use App\Containers\Files\Models\File;
use App\Containers\XRPLBlock\Models\XrplBlockDocument;
use App\Containers\XRPLBlock\Exceptions\XRPLUpdateBlockStatusException;

class XRPLUpdateBlockStatusTask
{
    use XRPLBlockTrait;
    
    public function __invoke(
            $processingXrplDocuments
    ): void {
        try {
            
            foreach($processingXrplDocuments as $processingXrplDocument){
                
                $request = $this->xrplSendRequest(
                        $processingXrplDocument->uuid,
                        'get',
                        config('constants.xrpl_block.endpoints.get_block_status') . $processingXrplDocument->uuid,
                        null);
                
                $response = json_decode($request->getBody(), true);
                
                DB::beginTransaction();

                    $xrplDocument = XrplBlockDocument::where('uuid', $processingXrplDocument->uuid)->first();
                    
                    $xrplDocument->status = $response['status'];
                    
                    if($response['status'] == config('constants.xrpl_block.status.compleated')){

                        $xrplDocument->block_data = json_encode($response['block_data']);

                        $file = File::where('xrpl_block_document_id', $processingXrplDocument->id)->first();
                        
                        $file->file_storage_option_id = 2;
                        $file->save();
                        
                        Storage::delete("files/$file->user_id/$file->basename");

                    }

                    $xrplDocument->save();
                
                DB::commit();

            }

        } catch (\Exception $e) {
            throw (new XRPLUpdateBlockStatusException())->debug($e);
        }
    }
}
