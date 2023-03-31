<?php   

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidTrait
{
    
    public function generateUuid() {
        $uuid = Str::uuid(date('YmdHisu'));

        // call the same function if the uuid exists already
        if ($this->uuidExists($uuid)) {
            return generateUuid();
        }

        // otherwise, it's valid and can be used
        return $uuid;
    }

    public function uuidExists($uuid) {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        
        return get_called_class()::whereuuid($uuid)->exists();
    }
}
