<?php

namespace App\Containers\Files\Tasks;

use Exception;
use App\Abstracts\Task;
use App\Traits\StorageDiskTrait;
use App\Containers\Files\Exceptions\StorageFailedException;

/**
 * Class StoreFileToLocalDiskTask.
 *
 */
class StoreFileToLocalDiskTask extends Task
{

    use StorageDiskTrait;
    
    /**
     * @param array $data
     * @param bool  $login
     *
     * @return mixed
     */
    public function run($file, $user, $name)
    {
        try {
            
            $temp = (app()->environment() == 'testing') ? 'testing/' : null;
            $this->getStorageDisk()->put($temp . "files/$user->id/$name", $file->get());
           
        } catch (Exception $e) {
            throw (new StorageFailedException())->debug($e);
        }

        return true;
    }
}
