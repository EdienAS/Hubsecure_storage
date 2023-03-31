<?php

namespace App\Containers\Authentication\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MissingVisitorIdException
 * @package App\Containers\Authentication\Exceptions
 */
class MissingVisitorIdException extends ExceptionHttp
{
    public $httpStatusCode = Response::HTTP_BAD_REQUEST;

    public $message = '(visitor-id) is required.';
}
