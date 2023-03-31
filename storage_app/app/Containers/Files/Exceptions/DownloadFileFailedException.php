<?php

namespace App\Containers\Files\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DownloadFileFailedException.
 *
 */
class DownloadFileFailedException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed downloading File.';
}
