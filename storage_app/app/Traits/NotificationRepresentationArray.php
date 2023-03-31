<?php   

namespace App\Traits;

use Config;
use Illuminate\Support\Str;
use App\Containers\UserSettings\Models\Usersetting;

trait NotificationRepresentationArray
{
    
    public function notificationRepresentationArray($category, $title, $description,
            $action_type, $action_params_id) {
        
        $representationArray = [
            'category'    => $category,
            'title'       => $title,
            'description' => $description,
            'action'      => [
                'type'   => $action_type,
                'params' => [
                    'id' => $action_params_id,
                ]
            ]
        ];
        
        return $representationArray;
            
    }

}
