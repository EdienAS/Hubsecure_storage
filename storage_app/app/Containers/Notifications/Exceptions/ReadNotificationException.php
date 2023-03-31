<?php

namespace App\Containers\Notifications\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ReadNotificationException.
 *
 */
class ReadNotificationException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed updating notification.';
}
