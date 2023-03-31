<?php

namespace App\Containers\User\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlacklistException.
 *
 */
class BlacklistException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed to blacklist user.';
}
