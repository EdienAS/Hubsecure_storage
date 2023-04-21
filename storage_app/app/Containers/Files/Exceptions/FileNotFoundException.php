<?php

namespace App\Containers\Files\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FileNotFoundException.
 *
 */
class FileNotFoundException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'File not found.';
}
