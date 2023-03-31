<?php

namespace App\Containers\Files\Actions;

use Gate;
use App\Abstracts\Action;
use App\Containers\Files\Tasks\GetFileTask;
use App\Containers\Files\Tasks\DownloadFileTask;

/**
 * Class GetFileAction.
 *
 */
class GetFileAction extends Action
{
    /**
     * @var  \App\Containers\Files\Tasks\GetFileTask
     */
    private $getFileTask;

    /**
     * GetFileAction constructor.
     *
     * @param \App\Containers\Files\Tasks\GetFileTask     $getFileTask
     * @param \App\Containers\Files\Tasks\DownloadFileTask     $downloadFileTask
     */
    public function __construct(GetFileTask $getFileTask, DownloadFileTask $downloadFileTask)
    {
        $this->getFileTask = $getFileTask;
        
        $this->downloadFileTask = $downloadFileTask;

    }
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        
        $file = $this->getFileTask->run($request);
        
        // Check if user can download file
        if (! $file->user->canDownload()) {
             abort(401, 'Forbidden.');
        }
        
        // Check if user has privileges to download file
        if (! Gate::any(['can-edit', 'can-view'], [$file, null])) {
             abort(403, 'Unauthorized action.');
        }

        $encrypted_string = 'EOnM1p95SpDpp8XZO0T5d16KBdzTDYDWloKqf1gL6o1pYOsagQJGlKJSsTvGCvVNXxeHcluhO0IS8Wkscb+d3A==';
        $ivlen = openssl_cipher_iv_length(config('filemanager.encryption_method'));
        $iv = $request['iv'];
        $decrypted_string=openssl_decrypt($encrypted_string,config('filemanager.encryption_method'),'password', 0, 'testtesttesttest');
        
//        if($decrypted_string == $file->file_hash){
//            dd('matched');
            return $this->downloadFileTask->run($file);
//        } else {
//            abort(403, 'File corrupted.');
//        }
        
    }
}
