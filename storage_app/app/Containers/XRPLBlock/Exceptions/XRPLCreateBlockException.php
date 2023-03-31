<?php

namespace App\Containers\XRPLBlock\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class XRPLCreateBlockException.
 *
 */
class XRPLCreateBlockException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed creating XRPL Block.';
}
