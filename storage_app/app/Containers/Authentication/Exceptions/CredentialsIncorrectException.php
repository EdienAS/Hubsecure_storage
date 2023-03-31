<?php

namespace App\Containers\Authentication\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CredentialsIncorrectException
 * @package App\Containers\Authentication\Exceptions
 */
class CredentialsIncorrectException extends ExceptionHttp
{
    public $httpStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
    public $message = 'Credentials is Incorrect.';
}
