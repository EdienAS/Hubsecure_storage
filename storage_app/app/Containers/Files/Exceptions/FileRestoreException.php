<?php

namespace App\Containers\Files\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FileRestoreException.
 *
 */
class FileRestoreException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed restoring File.';
}
