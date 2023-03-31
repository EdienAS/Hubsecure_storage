<?php

namespace App\Containers\Files\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UploadFileFailedException.
 *
 */
class UploadFileFailedException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed uploading new File.';
}
