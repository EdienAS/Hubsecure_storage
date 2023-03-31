<?php

namespace App\Containers\Share\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShareItemDestroyException.
 *
 */
class ShareItemDestroyException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed destroying share item.';
}
