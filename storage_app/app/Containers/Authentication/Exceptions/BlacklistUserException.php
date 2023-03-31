<?php

namespace App\Containers\Authentication\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlacklistUserException
 * @package App\Containers\Authentication\Exceptions
 */
class BlacklistUserException extends ExceptionHttp
{
    public $httpStatusCode = Response::HTTP_FORBIDDEN;

    public $message = 'User is blacklisted.';
}
