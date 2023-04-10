<?php

namespace App\Containers\User\Tasks;

use Hash;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\User\Models\User;
use Laravel\Passport\TokenRepository;
use App\Containers\User\Resources\UserResource;
use App\Containers\User\Exceptions\UserException;
use App\Containers\UserSettings\Models\Usersetting;

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
            
            if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
            }
            
            $user->update($data);
            if(!empty($data['name'])){

                // Split username
                $name = split_name($data['name']);

                $userSetting = Usersetting::where('user_id', $user->id)->first();
                
                $userSetting->first_name = $name['first_name'];
                $userSetting->last_name = $name['last_name'];
                
                $userSetting->save();
                
                      
            }

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
