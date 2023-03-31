<?php

namespace App\Containers\Authorization\Exceptions\Role;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RoleFailedException.
 *
 */
class RoleFailedException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed creating new role.';
}
