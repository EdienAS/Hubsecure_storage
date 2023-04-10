<?php

namespace App\Containers\User\Tasks;

use Exception;
use App\Abstracts\Task;
use App\Traits\XRPLBlockTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Containers\User\Models\User;
use App\Containers\User\Models\UserLimitation;
use App\Containers\UserSettings\Models\Usersetting;
use App\Containers\User\Exceptions\AccountFailedException;
use App\Containers\Authentication\Tasks\ApiLoginThisUserObjectTask;

/**
 * Class CreateUserTask.
 *
 */
class CreateUserTask extends Task
{
    use XRPLBlockTrait;

    /**
     * @var \App\Containers\Authentication\Tasks\ApiLoginThisUserObjectTask
     */
    private $apiLoginThisUserObjectTask;


    /**
     * CreateUserTask constructor.
     *
     * @param \App\Containers\User\Contracts\UserRepositoryInterface          $userRepository
     * @param \App\Containers\User\Tasks\CreateUserDataTask                   $createUserDataTask
     * @param \App\Containers\Authentication\Tasks\ApiLoginThisUserObjectTask $apiLoginThisUserObjectTask
     */
    public function __construct(
        ApiLoginThisUserObjectTask $apiLoginThisUserObjectTask
    ) {
        $this->apiLoginThisUserObjectTask = $apiLoginThisUserObjectTask;
    }


    /**
     * @param array $data
     * @param bool  $login
     *
     * @return mixed
     */
    public function run(array $data, $login = false)
    {
        try {

           $userEmailExistcheck = DB::table('users')->where('email', $data['email'])->first();
           $isRegistrationcheck = isset($userEmailExistcheck) ? $userEmailExistcheck->isRegisterationCompleted : "";

           if($userEmailExistcheck && $isRegistrationcheck == 0){
                $user =  User::find($userEmailExistcheck->id);
           }else{
            DB::beginTransaction();

                $user = User::create($data);
                    
                $userSetting = array(
                    'uuid' => 'uuid',
                    'user_id' => $user->id,
                    'file_storage_option_id' => 1,
                    'storage_limit_mb' => 100
                );
                
                Usersetting::create($userSetting);
                
                $userLimitation = array(
                    'user_id' => $user->id,
                    'max_storage_amount' => 100,
                    'max_team_members' => 10
                    );
                
                UserLimitation::create($userLimitation);

            DB::commit();
           }

        } catch (Exception $e) {
            throw (new AccountFailedException())->debug($e);
        }

        if ($login) {
            $user = $this->apiLoginThisUserObjectTask->run($user);
        }
        return $user;
    }


    /**
     * @param array $data
     *
     * @return array
     */
    private function handleAttributes(array $data)
    {
        if(empty($data['email']) || empty($data['password'])) {
            return [];
        }
        
        $attributes = [
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
        ];
        
        return $attributes;
    }
}
