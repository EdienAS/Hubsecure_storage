<?php

namespace App\Containers\UserSettings\Tasks;

use Exception;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\User\Models\User;
use App\Containers\UserSettings\Models\Usersetting;
use App\Containers\UserSettings\Exceptions\UserSettingsException;

/**
 * Class UpdateUserSettingsTask.
 *
 */
class UpdateUserSettingsTask extends Task
{

    /**
     * @param array $data
     * @param bool  $login
     *
     * @return mixed
     */
    public function run($request)
    {
        
        try {
            
            $userId = User::where('uuid', $request->uuid)->pluck('id')->first();

            DB::beginTransaction();
            
            $data = $request->all();
            $data['avatar'] = store_avatar($request, 'avatar');
            
            $userSettings = Usersetting::updateOrCreate(
                    ['user_id' => $userId],$data
                );
            


            DB::commit();

        } catch (Exception $e) {
            throw (new UserSettingsException())->debug($e);
        }

        return $userSettings;
    }

}
