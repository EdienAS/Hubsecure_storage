<?php

namespace App\Containers\UserSettings\UI\Api\Transformers;

use App\Abstracts\Transformer;
use App\Containers\UserSettings\Models\Usersetting;

/**
 * Class UserSettingsTransformer.
 *
 */
class UserSettingsTransformer extends Transformer
{

    /**
     * @param \App\Containers\UserSettings\Models\Usersetting $userSetting
     *
     * @return array
     */
    public function transform($userSetting)
    {
        
            $data['uuid'] = $userSetting['uuid'];
            $data['user_id'] = $userSetting['user_id'];
            $data['file_storage_option_id'] = $userSetting['file_storage_option_id'];
            $data['storage_limit_mb'] = $userSetting['storage_limit_mb'];
            
        return $data;
    }
    
}
