<?php   

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use App\Containers\XRPLBlock\Models\XrplBlockDocument;

trait XRPLBlockTrait
{
    
    public function getXRPLBlockPostData($documentUuid, $requestEndpoint) {
        
        $clientEncryptionKey = XrplBlockDocument::with('file')->where('uuid', $documentUuid)
                ->first()->file->user->userSettings->client_encryption_key;
        
        $postData =  array(
            'application' => array(
                'app_encryption_key' => env('XRPL_APP_ENCRYPTION_KEY')
            ),
            'client' => array(
                'client_encryption_key' => $clientEncryptionKey,
            ),
            'block_uuid' => $documentUuid
        );
        
        if(str_contains($requestEndpoint, 'create')){
            
            unset($postData['block_uuid']);

            $clientWalletSeed = XrplBlockDocument::with('file')->where('uuid', $documentUuid)
                    ->first()->file->user->userSettings->client_wallet_seed;

            $clientWalletSeq = XrplBlockDocument::with('file')->where('uuid', $documentUuid)
                    ->first()->file->user->userSettings->client_wallet_seq;
            
            $postData['client']['client_wallet_seed'] = $clientWalletSeed;
            $postData['client']['client_wallet_seq'] = $clientWalletSeq;
            $postData['document_uuid'] = $documentUuid;
        }
        return $postData;
    }
    
    public function xrplSendRequest($documentUuid, $method, $requestEndpoint, $file) {
        
        $xrplBlockDomain = env('XRPL_BLOCK_DOMAIN');
        
        if($requestEndpoint == config('constants.xrpl_block.endpoints.upload_document')){
            return Http::attach('files', $file)->$method($xrplBlockDomain . $requestEndpoint);
        } else {
        
            $postData = array();
            if($method == 'post'){
                $postData = $this->getXRPLBlockPostData($documentUuid, $requestEndpoint);
            }
        
            return Http::$method($xrplBlockDomain . $requestEndpoint, 
                            $postData);
        }
    }

}
