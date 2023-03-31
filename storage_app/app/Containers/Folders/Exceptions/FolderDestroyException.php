<?php

namespace App\Containers\Folders\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FolderDestroyException.
 *
 */
class FolderDestroyException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed destroying Folder.';
}
