<?php

namespace App\Containers\Authentication\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserNotAdminException
 * @package App\Containers\Authentication\Exceptions
 */
class UserNotAdminException extends ExceptionHttp
{
    public $httpStatusCode = Response::HTTP_UNAUTHORIZED;

    public $message = 'User is not an Admin.';
}
