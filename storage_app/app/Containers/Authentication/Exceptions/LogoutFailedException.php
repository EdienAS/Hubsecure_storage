<?php

namespace App\Containers\Authentication\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LogoutFailedException
 * @package App\Containers\Authentication\Exceptions
 */
class LogoutFailedException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_BAD_REQUEST;

    public $message = 'Failed to logout!';
}
