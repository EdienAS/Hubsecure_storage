<?php

namespace App\Containers\Files\Tasks;

use App\Containers\Files\Exceptions\StorageFailedException;
use App\Abstracts\Task;
use Exception;
use Illuminate\Support\Facades\Storage;

/**
 * Class StoreFileToLocalDiskTask.
 *
 */
class StoreFileToLocalDiskTask extends Task
{

    

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
            Storage::disk('public')->put($temp . "files/$user->id/$name", $file->get());
           
        } catch (Exception $e) {
            throw (new StorageFailedException())->debug($e);
        }

        return true;
    }
}
