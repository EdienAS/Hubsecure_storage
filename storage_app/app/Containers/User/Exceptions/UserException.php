<?php

namespace App\Containers\User\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserCreateException.
 *
 */
class UserException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed to process request';
}
