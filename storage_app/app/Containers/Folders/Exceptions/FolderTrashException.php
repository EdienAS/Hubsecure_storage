<?php

namespace App\Containers\Folders\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FolderTrashException.
 *
 */
class FolderTrashException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed trashing Folder.';
}
