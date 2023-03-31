<?php
namespace App\Containers\XRPLBlock\Tasks;

use App\Traits\XRPLBlockTrait;
use App\Containers\XRPLBlock\Models\XrplBlockDocument;
use App\Containers\XRPLBlock\Exceptions\XRPLDownloadDocumentException;

class XRPLDownloadDocumentTask
{
    
    use XRPLBlockTrait;

    public function __invoke(
            $documentUuid
    ) {
        try {
            
            $xrplBlockDocumentData = XrplBlockDocument::where('uuid', $documentUuid)->first();
            
            if($xrplBlockDocumentData->status == config('constants.xrpl_block.status.compleated')){
            
                do{
                    $request = $this->xrplSendRequest(
                            $documentUuid,
                            'post',
                            config('constants.xrpl_block.endpoints.get_document'), 
                            null);

                    $response = json_decode($request, true);

                    sleep(5);
                } while ($response['status'] != config('constants.xrpl_block.status.completed'));

                return $response;
            } else {
                abort(422, 'XRPL Block not completed');
            }

        } catch (\Exception $e) {
            throw (new XRPLDownloadDocumentException())->debug($e);
        }
    }
}
