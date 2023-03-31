<?php

namespace App\Containers\Authentication\Tasks;

use App\Containers\User\Models\User;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

/**
 * Class ApiLogoutTask.
 *
 */
class ApiLogoutTask extends Task
{    
    
    /**
     * @param \App\Containers\User\Models\User $user
     * @param                                  $token
     *
     * @return bool
     */
    public function run(User $user)
    {
        
        DB::beginTransaction();
        $tokens =  $user->tokens->pluck('id');
        Token::whereIn('id', $tokens)
            ->update(['revoked'=> true]);

        RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
    
        DB::commit();
        
        return true;
    }

}
