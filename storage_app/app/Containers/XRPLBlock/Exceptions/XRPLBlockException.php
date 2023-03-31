<?php

namespace App\Containers\XRPLBlock\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class XRPLBlockException.
 *
 */
class XRPLBlockException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed storing File to XRPL Block.';
}
