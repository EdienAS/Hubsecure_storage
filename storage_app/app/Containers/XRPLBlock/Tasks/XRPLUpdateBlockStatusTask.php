<?php
namespace App\Containers\XRPLBlock\Tasks;

use App\Traits\XRPLBlockTrait;
use Illuminate\Support\Facades\DB;
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
                    
                    if($response['status'] == config('constants.xrpl_block.status.compleated')){

                        $xrplDocument->status = $response['status'];
                    
                        $xrplDocument->block_data = json_encode($response['block_data']);

                    }

                    $xrplDocument->save();
                
                DB::commit();

            }

        } catch (\Exception $e) {
            throw (new XRPLUpdateBlockStatusException())->debug($e);
        }
    }
}
