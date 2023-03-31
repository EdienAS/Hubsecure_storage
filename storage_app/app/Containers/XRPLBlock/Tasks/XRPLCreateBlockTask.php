<?php
namespace App\Containers\XRPLBlock\Tasks;

use App\Traits\XRPLBlockTrait;
use Illuminate\Support\Facades\DB;
use App\Containers\XRPLBlock\Models\XrplBlockDocument;
use App\Containers\XRPLBlock\Exceptions\XRPLCreateBlockException;

class XRPLCreateBlockTask
{
    
    use XRPLBlockTrait;

    public function __invoke(
            $pendingXrplDocuments
    ): void {
        try {
            
            foreach($pendingXrplDocuments as $pendingXrplDocument){
                
                $request = $this->xrplSendRequest(
                        $pendingXrplDocument->uuid,
                        'post',
                        config('constants.xrpl_block.endpoints.create_block'),
                        null);
                
                $response = json_decode($request->getBody(), true);
                
                
                DB::beginTransaction();

                    $xrplDocument = XrplBlockDocument::where('uuid', $pendingXrplDocument->uuid)->first();

                        $xrplDocument->status = $response['status'];
                    
                    $xrplDocument->save();

                DB::commit();

            }

        } catch (\Exception $e) {
            throw (new XRPLCreateBlockException())->debug($e);
        }
    }
}
