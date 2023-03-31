<?php

namespace App\Containers\User\Tasks\Blacklist;

use Exception;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\User\Models\User;
use Laravel\Passport\TokenRepository;
use App\Containers\User\Models\Blacklist;
use App\Containers\User\Exceptions\BlacklistException;

/**
 * Class CreateBlacklistTask.
 *
 */
class CreateBlacklistTask extends Task
{

    /**
     * @param array $data
     * @param bool  $login
     *
     * @return mixed
     */
    public function run(array $data)
    {
        try {
            
            $user = User::where('uuid', $data['uuid'])->first(); 
            
            $tokens = DB::table('oauth_access_tokens')->where('user_id', $user->id)
                    ->pluck('id');
             
            DB::beginTransaction();

            Blacklist::updateOrCreate(['user_id' => $user->id], ['tokens' => json_encode($tokens)]);
            

            $tokenRepository = app(TokenRepository::class);

            foreach($tokens as $token){

                $tokenRepository->revokeAccessToken($token);

            }
                

            DB::commit();

        } catch (Exception $e) {
            throw (new BlacklistException())->debug($e);
        }

        return $user;
    }

}
