<?php

namespace App\Containers\Share\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShareItemUpdateException.
 *
 */
class ShareItemUpdateException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed updating share item.';
}
