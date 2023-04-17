<?php   

namespace App\Traits;

use Storage;

trait StorageDiskTrait
{
    
    public function getStorageDisk() {
        
        return Storage::disk('local');
    }

}
