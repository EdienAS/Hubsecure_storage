<?php

namespace App\Containers\Notifications\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DestroyNotificationException.
 *
 */
class DestroyNotificationException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed deleting notification.';
}
