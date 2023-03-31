<?php

namespace App\Containers\Authentication\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthenticationFailedException
 * @package App\Containers\Authentication\Exceptions
 */
class AuthenticationFailedException extends ExceptionHttp
{
    public $httpStatusCode = Response::HTTP_UNAUTHORIZED;

    public $message = 'Credentials Incorrect.';
}
