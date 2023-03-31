<?php

namespace App\Containers\Authentication\Exceptions;

use App\Abstracts\ExceptionHttp;

/**
 * Class UserWithEmailExistsException
 * @package App\Containers\Authentication\Exceptions
 */
class UserWithEmailExistsException extends ExceptionHttp
{
    public $httpStatusCode = 452;
    
    public $message = 'User with current email already exists';
}
