<?php

namespace App\Containers\Authentication\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateResourceFailedException
 * @package App\Containers\Authentication\Exceptions
 */
class UpdateResourceFailedException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_EXPECTATION_FAILED;

    public $message = 'Failed to Update.';
}
