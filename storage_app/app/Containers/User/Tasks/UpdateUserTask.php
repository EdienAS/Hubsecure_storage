<?php

namespace App\Containers\User\Tasks;

use Hash;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\User\Models\User;
use Laravel\Passport\TokenRepository;
use App\Containers\User\Resources\UserResource;
use App\Containers\User\Exceptions\UserException;

/**
 * Class UpdateUserTask.
 *
 */
class UpdateUserTask extends Task
{
    
    /**
     * @param array $data
     * @param       $uuid
     *
     * @return mixed
     */
    public function run(array $data, $uuid)
    {
        
        try {
            DB::beginTransaction();

            $user = User::where('uuid',$uuid)->first();
            unset($data['uuid']);
            $data['password'] = Hash::make($data['password']);
            
            $user->update($data);

            if(isset($data['is_active']) && $data['is_active'] == 0){
                
                $tokenRepository = app(TokenRepository::class);
                $tokens = DB::table('oauth_access_tokens')->where('user_id', $user->id)
                        ->pluck('id');
                
                foreach($tokens as $token){
                    
                    $tokenRepository->revokeAccessToken($token);
                    
                }
                
            }
            
            DB::commit();
        } catch (\Exception $e) {
            throw (new UserException())->debug($e);
        }
        return array(new UserResource($user));
    }
    
}
