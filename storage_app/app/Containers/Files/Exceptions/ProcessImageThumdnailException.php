<?php

namespace App\Containers\Files\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProcessImageThumdnailException.
 *
 */
class ProcessImageThumdnailException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed processing image thumbnail File.';
}
