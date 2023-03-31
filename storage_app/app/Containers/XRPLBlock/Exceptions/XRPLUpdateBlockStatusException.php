<?php

namespace App\Containers\XRPLBlock\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class XRPLUpdateBlockStatusException.
 *
 */
class XRPLUpdateBlockStatusException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed updating XRPL Block.';
}
