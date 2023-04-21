<?php
namespace App\Containers\XRPLBlock\Tasks;

use App\Traits\XRPLBlockTrait;
use Illuminate\Support\Facades\DB;
use App\Containers\UserSettings\Models\Usersetting;
use App\Containers\XRPLBlock\Models\XrplBlockDocument;
use App\Containers\XRPLBlock\Exceptions\XRPLCreateBlockException;

class XRPLCreateClientKeyTask
{
    
    use XRPLBlockTrait;

    public function __invoke(
            $pendingUsers
    ): void {
        try {
            
            foreach($pendingUsers as $pendingUser){
                
                $clientEncryptionKeyRequest = $this->xrplSendRequest(
                    null,
                    'get',
                    config('constants.xrpl_block.endpoints.generate_client_encryption_key'),
                    null);
                
                $clientEncryptionKeyResponse = json_decode($clientEncryptionKeyRequest->getBody(), true);
                
                $clientEncryptionKey = !empty($clientEncryptionKeyResponse) ? 
                        $clientEncryptionKeyResponse : generateRandomPhrase();
                
                $clientGenerateWalletRequest = $this->xrplSendRequest(
                    null,
                    'get',
                    config('constants.xrpl_block.endpoints.generate_wallet'),
                    null);
                
                $clientGenerateWalletResponse = json_decode($clientGenerateWalletRequest->getBody(), true);
                
                
                DB::beginTransaction();

                    Usersetting::where('user_id', $pendingUser->id)->update([
                        'client_encryption_key' => $clientEncryptionKey,
                        'client_wallet_seed' => $clientGenerateWalletResponse['seed'],
                        'client_wallet_seq' => $clientGenerateWalletResponse['seq'],
                        'generate_wallet_response' => json_encode($clientGenerateWalletResponse)
                    ]);

                DB::commit();

            }

        } catch (\Exception $e) {
            throw (new XRPLCreateBlockException())->debug($e);
        }
    }
}
