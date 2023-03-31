<?php

namespace App\Containers\UserSettings\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserSettingsException.
 *
 */
class UserSettingsException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed creating new User settings.';
}
