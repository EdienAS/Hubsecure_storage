<?php

namespace App\Containers\Authentication\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MissingTokenException
 * @package App\Containers\Authentication\Exceptions
 */
class MissingTokenException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_BAD_REQUEST;

    public $message = 'Token is required.';
}
