<?php

namespace App\Containers\Authorization\Exceptions\Permission;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PermissionFailedException.
 *
 */
class PermissionFailedException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed creating new permission.';
}
