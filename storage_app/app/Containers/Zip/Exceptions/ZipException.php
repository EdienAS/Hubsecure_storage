<?php

namespace App\Containers\Zip\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ZipException.
 *
 */
class ZipException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed zippping operation.';
}
